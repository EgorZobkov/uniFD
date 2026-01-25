<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Systems;
use Symfony\Component\HttpFoundation\Request;

class View
{
    public $path;
    public $pathComponent;
    public $isolated;
    public $paramsComponent = [];
    public $paramsPreload = [];
    static $blocks = [];

    public $visible_header = true;
    public $visible_footer = true;

    public function setPath($path=null) {
        $this->path = $path;
    }

    public function params($params=[]) {
        return array_merge($params,["template"=>$this->templateFunctions()]);
    }

    public function setParamsComponent($params=[]) {
        global $app;
        $this->paramsComponent = $params;
        return $this;
    }

    public function setIsolated($name=null) {
        global $app;

        $this->isolated = $name;
        
        if($name == "dashboard"){
            $this->path = $app->config->resource->view->dashboard->path;
            $this->pathComponent = $app->config->resource->components->dashboard;
        }elseif($name == "web"){
            $this->path = $app->config->resource->view->web->path;
            $this->pathComponent = $app->config->resource->components->web;
        }

    }

    public function templateFunctions(){
        global $app;
        return (object)[
            "view"=>$app->view,
            "asset"=>$app->asset,
            "storage"=>$app->storage,
            "settings"=>$app->settings,
            "translate"=>$app->translate,
            "router"=>$app->router,
            "component"=>$app->component,
            "user"=>$app->user,
            "system"=>$app->system,
            "pagination"=>$app->pagination,
            "ui"=>$app->ui,
            "datetime"=>$app->datetime,
            "geo"=>$app->geo,
        ];
    }

    public function accessDenied(){
        $this->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_d898fe8c5596b396e4a5e2459083a06a")=>null]]]);
        return $this->render('access-denied', $this->params(["title"=>translate("tr_d898fe8c5596b396e4a5e2459083a06a")]));
    }

    public function render($view=null, $vars=[]){

        $vars = array_merge($vars,["template"=>$this->templateFunctions()]);

        if(file_exists($this->path.'/'.$view.'.tpl')) {
            $cached_file = $this->save($view.'.tpl');
            extract($vars, EXTR_SKIP);
            require $cached_file;
        }else{
            throw new Exception('view "'.$this->path.'/'.$view.'.tpl" not found', '404');
        }

    }

    public function preload($view=null, $vars=[]){

        $request = Request::createFromGlobals();

        $vars = array_merge($vars,["template"=>$this->templateFunctions()]);

        if(file_exists($this->path.'/preload.tpl')) {

            if($request->getMethod() == 'GET') {
                $cached_file = $this->save('preload.tpl');
            }else{
                $cached_file = $this->save($view.'.tpl');
            }

            extract($vars, EXTR_SKIP);
            require $cached_file;
        }else{
            throw new Exception('view "'.$this->path.'/preload.tpl" not found', '404');
        }

    }

    public function setParamsPreload($params=[]){
        global $app;

        $this->paramsPreload = $params;

    }

    public function getParamsPreload(){
        global $app;

        return trim(requestBuildVars($this->paramsPreload), "?");

    }

    public function save($file) {
        global $app;

        if(!is_dir($app->config->storage->cache)){
            _mkdir($app->config->storage->cache, 0777);
        }

        $cached_file = $app->config->storage->cache . '/' . str_replace(array('/', '.tpl'), array('_', ''), $file . '.php');

        $code = $this->includeFiles($file);
        $code = $this->compileCode($code);

        if($this->isolated == "web"){
            $code .= '<section class="js-auth-status" style="display:none;" data-status="'.($app->user->isAuth() ? 'true' : 'false').'" ></section>';
        }

        _file_put_contents($cached_file, '<?php class_exists(\'' . __CLASS__ . '\') or exit; ?>' . PHP_EOL . $code);

        return $cached_file;
    }

    public function clearCache() {
        global $app;
        foreach(glob($app->config->storage->cache . '*') as $file) {
            unlink($file);
        }
    }

    public function compileCode($code) {
        $code = $this->compileBlock($code);
        $code = $this->compileYield($code);
        $code = $this->compileEscapedEchos($code);
        $code = $this->compileEchos($code);
        $code = $this->compilePHP($code);
        return $code;
    }

    public function includeFiles($file) {
        global $app;
        $code = _file_get_contents($this->path.'/'.$file);
        $code = $app->clean->phpCode($code);
        preg_match_all('/{% ?(extends|include|component) ?\'?(.*?)\'? ?%}/i', $code, $matches, PREG_SET_ORDER);
        foreach ($matches as $value) {
            if($value[1] == "component"){
                $code = str_replace($value[0], $this->includeComponent($value[2]), $code);
            }else{
                $code = str_replace($value[0], $this->includeFiles($value[2]), $code);
            }
        }
        $code = preg_replace('/{% ?(extends|include|component) ?\'?(.*?)\'? ?%}/i', '', $code);
        return $code;
    }

    public function includeComponent($file) {
        global $app;

        $params = [];

        if(file_exists($this->pathComponent."/".$file)){

            $params = array_merge($this->paramsComponent,["app"=>$app]);
            return obContent($this->pathComponent.'/'.$file,$params);
            
        }
        return '';
    }

    public function compilePHP($code) {
        return preg_replace('~\{%\s*(.+?)\s*\%}~is', '<?php $1; ?>', $code);
    }

    public function compileEchos($code) {
        return preg_replace('~\{{\s*(.+?)\s*\}}~is', '<?php echo $1; ?>', $code);
    }

    public function compileEscapedEchos($code) {
        return preg_replace('~\{{{\s*(.+?)\s*\}}}~is', '<?php echo htmlentities($1, ENT_QUOTES, \'UTF-8\') ?>', $code);
    }

    public function compileBlock($code) {
        preg_match_all('/{% ?block ?(.*?) ?%}(.*?){% ?endblock ?%}/is', $code, $matches, PREG_SET_ORDER);
        foreach ($matches as $value) {
            if (!array_key_exists($value[1], static::$blocks)) static::$blocks[$value[1]] = '';
            if (strpos($value[2], '@parent') === false) {
                static::$blocks[$value[1]] = $value[2];
            } else {
                static::$blocks[$value[1]] = str_replace('@parent', static::$blocks[$value[1]], $value[2]);
            }
            $code = str_replace($value[0], '', $code);
        }
        return $code;
    }

    public function compileYield($code) {
        foreach(static::$blocks as $block => $value) {
            $code = preg_replace('/{% ?yield ?' . $block . ' ?%}/', $value, $code);
        }
        $code = preg_replace('/{% ?yield ?(.*?) ?%}/i', '', $code);
        return $code;
    }

}