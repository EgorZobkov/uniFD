<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Middlewares;

use App\Systems\Middleware;
use Symfony\Component\HttpFoundation\Request;

class DashboardAuthorizeMiddleware extends Middleware
{

    public function __construct($app){
        parent::__construct($app);
        $this->view->setIsolated('dashboard');
    }

    public function handle(Request $request)
    {
        if($this->user->dashboard(true)->verificationAuth()){
            $this->router->goToRoute("dashboard");
        }
        $this->system->initСustomizeTemplate();
        return true;
    }
}