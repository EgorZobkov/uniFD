<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Middlewares;

use App\Systems\Middleware;
use Symfony\Component\HttpFoundation\Request;

class DashboardMiddleware extends Middleware
{

    public function __construct($app){
        parent::__construct($app);
        $this->view->setIsolated('dashboard');
        $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/chat.js\" type=\"module\" ></script>"]);
    }

    public function handle(Request $request)
    {

        $this->router->setRouteEndPoint("dashboard-route-end-point");

        if($this->user->dashboard(true)->verificationAuth()){

            $this->system->initСustomizeTemplate();

            return true;

        }else{

            if($request->getMethod() == 'GET'){
                $this->router->goToRoute("dashboard-auth");
            }else{
                echo json_answer(["auth"=>false, "route"=>$this->router->getRoute("dashboard-auth")]);
            }

            return false;

        }  

    }
}