<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Middlewares;

use App\Systems\Middleware;
use Symfony\Component\HttpFoundation\Request;

class VerificationAuthMiddleware extends Middleware
{

    public function __construct($app){
        parent::__construct($app);
        $this->view->setIsolated('web');
    }

    public function handle(Request $request)
    {

        if($this->user->verificationAuth()){

            return true;

        }else{

            if($request->getMethod() == 'GET'){
                $this->router->goToRoute("auth");
            }else{
                echo json_answer(["auth"=>false, "route"=>$this->router->getRoute("auth")]);
            }

            return false;

        }
 
    }
}