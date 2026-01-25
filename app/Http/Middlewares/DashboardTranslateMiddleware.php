<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Middlewares;

use App\Systems\Middleware;
use Symfony\Component\HttpFoundation\Request;

class DashboardTranslateMiddleware extends Middleware
{

    public function __construct($app){
        parent::__construct($app);
        $this->view->setIsolated('dashboard');
    }

    public function handle(Request $request){

        $this->translate->setContent($this->system->getSystemTemplate()->language);

        if($request->getMethod() == 'GET'){
            $this->translate->setJs();
        }

        return true;
    }

}