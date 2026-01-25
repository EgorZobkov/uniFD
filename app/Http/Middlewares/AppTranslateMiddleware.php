<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Middlewares;

use App\Systems\Middleware;
use Symfony\Component\HttpFoundation\Request;

class AppTranslateMiddleware extends Middleware
{

    public function __construct($app){
        parent::__construct($app);
    }

    public function handle(Request $request){

        $this->translate->setContent($_REQUEST["lang_iso"]);

        return true;
    }

}