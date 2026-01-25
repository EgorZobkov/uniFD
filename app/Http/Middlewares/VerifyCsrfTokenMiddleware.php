<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Middlewares;

use App\Systems\Middleware;
use Symfony\Component\HttpFoundation\Request;

class VerifyCsrfTokenMiddleware extends Middleware
{

    public function __construct($app){
        parent::__construct($app);
    }

    public function handle(Request $request){

        if($request->getMethod() == 'POST') {

            $token = $request->headers->get('x-csrf-token') ?: $request->request->get('csrf-token');

            if(empty($token) || empty($this->session->get('csrf-token')) || !compareValues($this->session->get('csrf-token'),$token)){
                return false;
            }

        }

        return true;
    }

}