<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Middlewares;

use App\Systems\Middleware;
use Symfony\Component\HttpFoundation\Request;

class WebMiddleware extends Middleware
{

    public function __construct($app){
        parent::__construct($app);
        $this->view->setIsolated('web');
    }

    public function handle(Request $request)
    {

        if( strpos($request->server->get('REQUEST_URI'), '//') !== false ){
            $this->router->goToUrl(getHost().'/'.preg_replace('|([/]+)|s', '/', trim($request->server->get('REQUEST_URI'), "/")));
        }

        if( strpos($request->server->get('SERVER_NAME'), 'www.') !== false ){
            $this->router->goToUrl(str_replace("www.", "", getHost().'/'.trim($request->server->get('REQUEST_URI'), "/")));
        }

        if( strpos($request->server->get('HTTP_USER_AGENT'), 'Wget') !== false ){
            abort(404);
        } 

        if( strpos($request->server->get('HTTP_USER_AGENT'), 'python') !== false ){
            abort(404);
        }
 
        $this->user->createSessionId();
        $this->system->fixTraffic();
        $this->system->checkAccessSite();
        $this->user->verificationAuth();
        $this->component->cart->updateUserItems();
        $this->component->geo->setUserChange();

        if($this->router->currentRoute->name != "catalog"){
            $this->session->delete("request-catalog");
        }

        return true;  
    }
}