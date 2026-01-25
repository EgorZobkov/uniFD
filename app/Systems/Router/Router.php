<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Systems\Router;

use Closure;
use Exception;
use ReflectionMethod;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Router
 *
 * @method $this any($route, $callback, array $options = [])
 * @method $this get($route, $callback, array $options = [])
 * @method $this post($route, $callback, array $options = [])
 * @method $this put($route, $callback, array $options = [])
 * @method $this delete($route, $callback, array $options = [])
 * @method $this patch($route, $callback, array $options = [])
 * @method $this head($route, $callback, array $options = [])
 * @method $this options($route, $callback, array $options = [])
 * @method $this ajax($route, $callback, array $options = [])
 * @method $this xpost($route, $callback, array $options = [])
 * @method $this xput($route, $callback, array $options = [])
 * @method $this xdelete($route, $callback, array $options = [])
 * @method $this xpatch($route, $callback, array $options = [])
 */
class Router
{

    protected $container;

    /**
     * @var string $baseFolder Pattern definitions for parameters of Route
     */
    protected $baseFolder;

    /**
     * @var array $routes Routes list
     */
    protected static $routes = [];

    protected static $aliases = [];

    protected static $dataAliases = [];

    public $currentRoute = null;
    public $beforeRouteName = null;

    /**
     * @var array $groups List of group routes
     */
    protected $groups = [];

    /**
     * @var array $patterns Pattern definitions for parameters of Route
     */
    protected static $patterns = [
        ':all' => '(.*)',
        ':any' => '([^/]+)',
        ':id' => '(\d+)',
        ':int' => '(\d+)',
        ':number' => '([+-]?([0-9]*[.])?[0-9]+)',
        ':float' => '([+-]?([0-9]*[.])?[0-9]+)',
        ':bool' => '(true|false|1|0)',
        ':string' => '([\w\-_]+)',
        ':slug' => '([\w\-_]+)',
        ':uuid' => '([0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12})',
        ':date' => '([0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]))',
    ];

    /**
     * @var array $namespaces Namespaces of Controllers and Middlewares files
     */
    protected $namespaces = [
        'middlewares' => '',
        'controllers' => '',
    ];

    /**
     * @var array $path Paths of Controllers and Middlewares files
     */
    protected $paths = [
        'controllers' => 'Controllers',
        'middlewares' => 'Middlewares',
    ];

    /**
     * @var string $mainMethod Main method for controller
     */
    protected $mainMethod = 'main';

    /**
     * @var string $cacheFile Cache file
     */
    protected $cacheFile = null;

    /**
     * @var bool $cacheLoaded Cache is loaded?
     */
    protected $cacheLoaded = false;

    /**
     * @var Closure $errorCallback Route error callback function
     */
    protected $errorCallback;

    /**
     * @var array $middlewares General middlewares for per request
     */
    protected $middlewares = [];

    /**
     * @var array $routeMiddlewares Route middlewares
     */
    protected $routeMiddlewares = [];

    /**
     * @var array $middlewareGroups Middleware Groups
     */
    protected $middlewareGroups = [];

    /**
     * @var RouterRequest
     */
    private $request;

    /**
     * Router constructor method.
     *
     * @param array         $params
     * @param Request|null  $request
     * @param Response|null $response
     */
    public function __construct(Request $request = null, Response $response = null)
    {
        $this->baseFolder = realpath(getcwd());

        $params = [
            'paths' => [
                'controllers' => 'app/Http/Controllers',
                'middlewares' => 'app/Http/Middlewares',
            ],
            'namespaces' => [
                'controllers' => 'App\Http\Controllers',
                'middlewares' => 'App\Http\Middlewares',
            ],
            'cache' => $this->container->config->storage->cache . '/routes.php',
        ];

        if (isset($params['debug']) && is_bool($params['debug'])) {
            RouterException::$debug = $params['debug'];
        }

        $request = $request ?? Request::createFromGlobals();
        $response = $response ?? new Response('', Response::HTTP_OK, ['content-type' => 'text/html']);

        $this->request = new RouterRequest($request, $response);

        $data = require BASE_PATH . '/config/app.php';

        $global_middlewares = $data["middlewares"];

        if(isset($global_middlewares)){
            $this->setMiddleware($global_middlewares);
        }

        $this->setPaths($params);
        $this->loadCache();
    }

    public function setContainer($container){
        $this->container = $container;
    }

    /**
     * Add route method;
     * Get, Post, Put, Delete, Patch, Any, Ajax...
     *
     * @param $method
     * @param $params
     *
     * @return mixed
     * @throws
     */
    public function __call($method, $params)
    {
        if ($this->cacheLoaded) {
            return true;
        }

        if (is_null($params)) {
            return false;
        }

        if (!in_array(strtoupper($method), explode('|', $this->request->validMethods()))) {
            return $this->exception("Method is not valid. [{$method}]");
        }

        [$route, $callback] = $params;
        $options = $params[2] ?? null;
        if (strstr($route, ':')) {
            $route1 = $route2 = '';
            foreach (explode('/', $route) as $key => $value) {
                if ($value != '') {
                    if (!strpos($value, '?')) {
                        $route1 .= '/' . $value;
                    } else {
                        if ($route2 == '') {
                            $this->addRoute($route1, $method, $callback, $options);
                        }

                        $route2 = $route1 . '/' . str_replace('?', '', $value);
                        $this->addRoute($route2, $method, $callback, $options);
                        $route1 = $route2;
                    }
                }
            }

            if ($route2 == '') {
                $this->addRoute($route1, $method, $callback, $options);
            }
        } else {
            $this->addRoute($route, $method, $callback, $options);
        }

        return $this;
    }

    /**
     * Add new route method one or more http methods.
     *
     * @param string         $methods
     * @param string         $route
     * @param string|closure $callback
     * @param array          $options
     *
     * @return bool
     */
    public function add(string $methods, string $route, $callback, array $options = [])
    {
        if ($this->cacheLoaded) {
            return true;
        }

        if (strstr($methods, '|')) {
            foreach (array_unique(explode('|', $methods)) as $method) {
                if (!empty($method)) {
                    $this->addRoute($route, $method, $callback, $options);
                }
            }
        } else {
            $this->addRoute($route, $methods, $callback, $options);
        }

        return true;
    }

    /**
     * Add new route rules pattern; String or Array
     *
     * @param string|array $pattern
     * @param null|string  $attr
     *
     * @return mixed
     * @throws
     */
    public function pattern($pattern, $attr = null)
    {
        if (is_array($pattern)) {
            foreach ($pattern as $key => $value) {
                if (in_array($key, array_keys(static::$patterns))) {
                    return $this->exception($key . ' pattern cannot be changed.');
                }
                static::$patterns[$key] = '(' . $value . ')';
            }
        } else {
            if (in_array($pattern, array_keys($this->patterns))) {
                return $this->exception($pattern . ' pattern cannot be changed.');
            }
            static::$patterns[$pattern] = '(' . $attr . ')';
        }

        return true;
    }

    /**
     * Run Routes
     *
     * @return void
     * @throws
     */
    public function run(): void
    {
        $uri = $this->getRequestUri();
        $method = $this->request->getMethod();
        $searches = array_keys(static::$patterns);
        $replaces = array_values(static::$patterns);
        $foundRoute = false;

        foreach (static::$routes as $data) {
            $route = $data['route'];
            if (!$this->request->validMethod($data['method'], $method)) {
                continue;
            }

            // Direct Route Match
            if ($route === $uri) {
                $foundRoute = true;

                $this->currentRoute = (object)$data;

                $this->runRouteMiddleware($data, 'before');
                $this->runRouteCommand($data['callback']);
                $this->runRouteMiddleware($data, 'after');
                break;

                // Parameter Route Match
            } elseif (strstr($route, ':') !== false) {
                $route = str_replace($searches, $replaces, $route);
                if (preg_match('#^' . $route . '$#', $uri, $matched)) {
                    $foundRoute = true;

                    $this->currentRoute = (object)$data;

                    $this->runRouteMiddleware($data, 'before');

                    array_shift($matched);
                    $matched = array_map(function ($value) {
                        return trim(urldecode($value));
                    }, $matched);

                    foreach ($data['groups'] as $group) {
                        if (strstr($group, ':') !== false) {
                            array_shift($matched);
                        }
                    }

                    $this->runRouteCommand($data['callback'], $matched);
                    $this->runRouteMiddleware($data, 'after');
                    break;
                }
            }

        }

        // If it originally was a HEAD request, clean up after ourselves by emptying the output buffer
        if ($this->request()->isMethod('HEAD')) {
            ob_end_clean();
        }

        if ($foundRoute === false) {
            if (!$this->errorCallback) {
                $this->errorCallback = function () {
                    $this->response()
                        ->setStatusCode(Response::HTTP_NOT_FOUND)
                        ->sendHeaders();
                    return $this->exception('Page "'.$this->request()->server->get('REQUEST_URI').'" not found');
                };
            }
            call_user_func($this->errorCallback);
        }
    }

    /**
     * Routes Group
     *
     * @param string  $prefix
     * @param closure $callback
     * @param array   $options
     *
     * @return bool
     */
    public function group(string $prefix, Closure $callback, array $options = []): bool
    {
        if ($this->cacheLoaded) {
            return true;
        }

        $group = [];
        $group['route'] = $this->clearRouteName($prefix);
        $group['before'] = $this->calculateMiddleware($options['before'] ?? []);
        $group['after'] = $this->calculateMiddleware($options['after'] ?? []);
        $group['dashboard'] = $options['dashboard'] ? true : false;

        array_push($this->groups, $group);

        if (is_object($callback)) {
            call_user_func_array($callback, [$this]);
        }

        $this->endGroup();

        return true;
    }

    /**
     * Added route from methods of Controller file.
     *
     * @param string $route
     * @param string $controller
     * @param array  $options
     *
     * @return mixed
     * @throws
     */
    public function controller(string $route, string $controller, array $options = [])
    {
        if ($this->cacheLoaded) {
            return true;
        }

        $only = $options['only'] ?? [];
        $except = $options['except'] ?? [];
        $controller = $this->resolveClassName($controller);
        $classMethods = get_class_methods($controller);
        if ($classMethods) {
            foreach ($classMethods as $methodName) {
                if (!strstr($methodName, '__')) {
                    $method = 'any';
                    foreach (explode('|', $this->request->validMethods()) as $m) {
                        if (stripos($methodName, $m = strtolower($m), 0) === 0) {
                            $method = $m;
                            break;
                        }
                    }

                    $methodVar = lcfirst(
                        preg_replace('/' . $method . '_?/i', '', $methodName, 1)
                    );
                    $methodVar = strtolower(preg_replace('%([a-z]|[0-9])([A-Z])%', '\1-\2', $methodVar));

                    if ((!empty($only) && !in_array($methodVar, $only))
                        || (!empty($except) && in_array($methodVar, $except))) {
                        continue;
                    }

                    $ref = new ReflectionMethod($controller, $methodName);
                    $endpoints = [];
                    foreach ($ref->getParameters() as $param) {
                        $typeHint = $param->hasType() ? $param->getType()->getName() : null;
                        if (!in_array($typeHint, ['int', 'float', 'string', 'bool']) && $typeHint !== null) {
                            continue;
                        }
                        $pattern = isset(static::$patterns[":{$typeHint}"]) ? ":{$typeHint}" : ":any";
                        $endpoints[] = $param->isOptional() ? "{$pattern}?" : $pattern;
                    }

                    $value = ($methodVar === $this->mainMethod ? $route : $route . '/' . $methodVar);
                    $this->{$method}(
                        ($value . '/' . implode('/', $endpoints)),
                        ($controller . '@' . $methodName),
                        $options
                    );
                }
            }
            unset($ref);
        }

        return true;
    }

    /**
     * Routes error function.
     *
     * @param Closure $callback
     *
     * @return void
     */
    public function error(Closure $callback): void
    {
        $this->errorCallback = $callback;
    }

    /**
     * Get all Routes
     *
     * @return array
     */
    public function getRoutes(): array
    {
        return static::$routes;
    }

    /**
     * Cache all routes
     *
     * @return bool
     *
     * @throws Exception
     */
    public function cache(): bool
    {
        foreach ($this->getRoutes() as $key => $route) {
            if (!is_string($route['callback'])) {
                throw new Exception(sprintf('Routes cannot contain a Closure/Function callback while caching.'));
            }
        }

        $cacheContent = '<?php return ' . var_export($this->getRoutes(), true) . ';' . PHP_EOL;
        if (false === _file_put_contents($this->cacheFile, $cacheContent)) {
            throw new Exception(sprintf('Routes cache file could not be written.'));
        }

        return true;
    }

    /**
     * Set general middlewares
     *
     * @param array $middlewares
     *
     * @return void
     */
    public function setMiddleware(array $middlewares): void
    {
        $this->middlewares = $middlewares;
    }

    /**
     * Set Route middlewares
     *
     * @param array $middlewares
     *
     * @return void
     */
    public function setRouteMiddleware(array $middlewares): void
    {
        $this->routeMiddlewares = $middlewares;
    }

    /**
     * Set middleware groups
     *
     * @param array $middlewareGroup
     *
     * @return void
     */
    public function setMiddlewareGroup(array $middlewareGroup): void
    {
        $this->middlewareGroups = $middlewareGroup;
    }

    /**
     * Get All Middlewares
     *
     * @return array
     */
    public function getMiddlewares(): array
    {
        return [
            'middlewares' => $this->middlewares,
            'routeMiddlewares' => $this->routeMiddlewares,
            'middlewareGroups' => $this->middlewareGroups,
        ];
    }

    /**
     * Detect Routes Middleware; before or after
     *
     * @param array  $middleware
     * @param string $type
     *
     * @return void
     */
    protected function runRouteMiddleware(array $middleware, string $type): void
    {
        $this->routerCommand()->beforeAfter($middleware[$type]);
    }

    /**
     * @return Request
     */
    protected function request(): Request
    {
        return $this->request->symfonyRequest();
    }

    /**
     * @return Response
     */
    protected function response(): Response
    {
        return $this->request->symfonyResponse();
    }

    /**
     * Throw new Exception for Router Error
     *
     * @param string $message
     * @param int    $statusCode
     *
     * @return RouterException
     * @throws Exception
     */
    protected function exception($message = '', int $statusCode = 404): RouterException
    {
        return new RouterException($message, $statusCode);
    }

    /**
     * RouterCommand class
     *
     * @return RouterCommand
     */
    protected function routerCommand(): RouterCommand
    {

        return RouterCommand::getInstance(
            $this->baseFolder, $this->paths, $this->namespaces,
            $this->request(), $this->response(),
            $this->getMiddlewares(),
            $this->container
        );
    }

    /**
     * Set paths and namespaces for Controllers and Middlewares.
     *
     * @param array $params
     *
     * @return void
     */
    protected function setPaths(array $params): void
    {
        if (empty($params)) {
            return;
        }

        if (isset($params['paths']) && $paths = $params['paths']) {
            $this->paths['controllers'] = isset($paths['controllers'])
                ? trim($paths['controllers'], '/')
                : $this->paths['controllers'];

            $this->paths['middlewares'] = isset($paths['middlewares'])
                ? trim($paths['middlewares'], '/')
                : $this->paths['middlewares'];
        }

        if (isset($params['namespaces']) && $namespaces = $params['namespaces']) {
            $this->namespaces['controllers'] = isset($namespaces['controllers'])
                ? trim($namespaces['controllers'], '\\') . '\\'
                : '';

            $this->namespaces['middlewares'] = isset($namespaces['middlewares'])
                ? trim($namespaces['middlewares'], '\\') . '\\'
                : '';
        }

        if (isset($params['base_folder'])) {
            $this->baseFolder = rtrim($params['base_folder'], '/');
        }

        if (isset($params['main_method'])) {
            $this->mainMethod = $params['main_method'];
        }

        $this->cacheFile = $params['cache'];
    }

    /**
     * @param string $controller
     *
     * @return RouterException|string
     */
    protected function resolveClassName(string $controller)
    {
        $controller = str_replace([$this->namespaces['controllers'], '\\', '.'], ['', '/', '/'], $controller);
        $controller = trim(
            preg_replace(
                '/' . str_replace('/', '\\/', $this->paths['controllers']) . '/i',
                '',
                $controller,
                1
            ),
            '/'
        );

        $file = realpath("{$this->paths['controllers']}/{$controller}.php");
        if (!file_exists($file)) {
            return $this->exception("{$controller} class is not found! Please check the file.");
        }

        $controller = $this->namespaces['controllers'] . str_replace('/', '\\', $controller);
        if (!class_exists($controller)) {
            require_once $file;
        }

        return $controller;
    }

    /**
     * Load Cache file
     *
     * @return bool
     */
    protected function loadCache(): bool
    {
        if (file_exists($this->cacheFile)) {
            static::$routes = require_once $this->cacheFile;
            $this->cacheLoaded = true;
            return true;
        }

        return false;
    }

    /**
     * Add new Route and it's settings
     *
     * @param string $uri
     * @param string $method
     * @param        $callback
     * @param array  $options
     *
     * @return void
     */
    protected function addRoute(string $uri, string $method, $callback, $options = [])
    {
        $groupUri = '';
        $dashboardStatus = false;
        $groupStack = [];
        $beforeMiddlewares = [];
        $afterMiddlewares = [];
        if (!empty($this->groups)) {
            foreach ($this->groups as $key => $value) {
                $groupUri .= $value['route'];
                $groupStack[] = trim($value['route'], '/');
                $beforeMiddlewares = array_merge($beforeMiddlewares, $value['before']);
                $afterMiddlewares = array_merge($afterMiddlewares, $value['after']);
                if($value['dashboard']){
                    $dashboardStatus = true;
                }
            }
        }

        $beforeMiddlewares = array_merge($beforeMiddlewares, $this->calculateMiddleware($options['before'] ?? []));
        $afterMiddlewares = array_merge($afterMiddlewares, $this->calculateMiddleware($options['after'] ?? []));

        $callback = is_array($callback) ? implode('@', $callback) : $callback;
        $routeName = is_string($callback)
            ? strtolower(preg_replace(
                '/[^\w]/i', '.', str_replace($this->namespaces['controllers'], '', $callback)
            ))
            : null;

        if(!$dashboardStatus){
            if($options['dashboard']){
                $dashboardStatus = true;
            }
        }

        $data = [
            'route' => $this->clearRouteName("{$groupUri}/{$uri}"),
            'method' => strtoupper($method),
            'callback' => $callback,
            'name' => $options['name'] ?? $routeName,
            'route_id' => $options['route_id'] ?? null,
            'before' => $beforeMiddlewares,
            'after' => $afterMiddlewares,
            'groups' => $groupStack,
            'dashboard' => $dashboardStatus,
        ];

        $this->addAlias($data);

        array_push(static::$routes, $data);
    }

    protected function addAlias($data=[]){
        array_push(static::$aliases, [$data['name']=>$data['route']]);
        array_push(static::$dataAliases, $data);
    }

    /**
     * @param array|string $middleware
     *
     * @return array
     */
    protected function calculateMiddleware($middleware): array
    {
        if (is_null($middleware)) {
            return [];
        }

        return is_array($middleware) ? $middleware : [$middleware];
    }

    /**
     * Run Route Command; Controller or Closure
     *
     * @param $command
     * @param $params
     *
     * @return void
     */
    protected function runRouteCommand($command, $params = [])
    {
        $this->routerCommand()->runRoute($command, $params);
    }

    /**
     * Routes Group endpoint
     *
     * @return void
     */
    protected function endGroup(): void
    {
        array_pop($this->groups);
    }

    /**
     * @param string $route
     *
     * @return string
     */
    protected function clearRouteName(string $route = ''): string
    {
        $route = trim(preg_replace('~/{2,}~', '/', $route), '/');
        return $route === '' ? '/' : "/{$route}";
    }

    /**
     * @return string
     */
    protected function getRequestUri(): string
    {
        global $app;

        $uri = $this->request()->server->get('REQUEST_URI');

        $uri_explode = explode("/", trim($uri, "/"));

        if($app->config->app->prefix_path){

            if($uri_explode[0] == $app->config->app->prefix_path){
                unset($uri_explode[0]);
                $uri_explode = array_values($uri_explode);
            }

        }

        if($app->settings->multi_languages_status){
            if($app->translate->hasLang($uri_explode[0])){
                $app->translate->hasLangRequest = true;
                $app->translate->isoLangRequest = $uri_explode[0];
                unset($uri_explode[0]);
            }
        }    

        $uri = implode("/", $uri_explode);    

        return $this->clearRouteName(explode('?', $uri)[0]);
    }

    public static function getRoute($name=null,$params=[],$host=false,$prefix=true){
        global $app;

        $prefix_path = $prefix ? $app->config->app->prefix_path : '';

        $vars = [];
        $aliases = static::$aliases;
        if(count($aliases)){
            foreach ($aliases as $value){
                if(isset($value[$name])){
                    if(count($params)) {
                        $explode = explode(':', $value[$name]);
                        if(count($explode)){
                            foreach ($explode as $var){
                                foreach (static::$patterns as $key => $pattern){
                                    if(strpos(':'.$var, $key) !== false){
                                        $vars[] = $key;
                                    }
                                }
                            }
                        }
                        if(count($vars)){
                            $value[$name] = str_replace($vars, $params, $value[$name]);
                        }
                    }
                    if($prefix_path){
                        return $host ? getHost() . $value[$name] : '/' . $prefix_path . $value[$name];
                    }else{
                        return $host ? getHost() . $value[$name] : $value[$name];
                    }
                }
            }
        }
        return $host ? getHost() : '/' . $prefix_path;
    }

    public static function goToRoute($alias=null)
    {
        global $app;
        $aliases = static::$aliases;
        if(isset($alias)){
            foreach ($aliases as $key => $value) {
                if(isset($value[$alias])){
                    header("Location: ".outLink($value[$alias]));
                    die();
                }
            }
        }
        header("Location: ".outLink());
        die();        
    }

    public function setRouteEndPoint($name=null){
        global $app;

        if(isset($name)){
            if($this->request->getMethod() == 'GET'){
                $app->session->set($name, $this->request()->server->get('REQUEST_URI'));
            }
        }
        
    }

    public function getAliases(){
        return static::$aliases;
    }

    public function getDataAliases(){
        return static::$dataAliases;
    }

    public static function goToUrl($url=null)
    {
        if(isset($url)){
            header("Location: {$url}");
            die();
        }else{
            header("Location: ".getHost());
            die();
        }
    }

}
