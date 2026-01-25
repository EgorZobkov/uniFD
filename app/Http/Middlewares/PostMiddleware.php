<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Middlewares;

use App\Systems\Middleware;
use Symfony\Component\HttpFoundation\Request;

class PostMiddleware extends Middleware
{

    public function __construct($app){
        parent::__construct($app);
        $this->view->setIsolated('web');
    }

    public function handle(Request $request)
    {

        if( strpos($request->server->get('HTTP_USER_AGENT'), 'Wget') !== false ){
            return false;
        } 

        if( strpos($request->server->get('HTTP_USER_AGENT'), 'python') !== false ){
            return false;
        }

        $this->user->verificationAuth();
        
        $this->router->beforeRouteName = $request->headers->get('before-route') ?: null;

        return true;  

    }
}