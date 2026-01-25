<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Middlewares;

use App\Systems\Middleware;
use Symfony\Component\HttpFoundation\Request;

class ApiMiddleware extends Middleware
{

    public function __construct($app){
        parent::__construct($app);
        $this->view->setIsolated('web');
    }

    public function handle(Request $request)
    {

        if( strpos($request->server->get('HTTP_USER_AGENT'), 'Dart') === false ){
            return false;
        } 

        if( strpos($request->server->get('HTTP_USER_AGENT'), 'Wget') !== false ){
            return false;
        }

        if($this->config->app->private_app_api_key != $_REQUEST['api_key']){
            return false;
        }   

        if($request->getMethod() == 'GET'){
            $this->api->updateActiveStat($_GET["session_id"]);
        }

        return true;  
    }
}