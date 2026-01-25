<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Middlewares;

use App\Systems\Middleware;
use Symfony\Component\HttpFoundation\Request;

class WebTranslateMiddleware extends Middleware
{

    public function __construct($app){
        parent::__construct($app);
        $this->view->setIsolated('web');
    }

    public function handle(Request $request){

        if($request->getMethod() == 'GET'){
            $this->translate->hasLanguageRequest();
            $this->translate->setContent();
            $this->component->seo->setLang($this->translate->getChangeLang());
            $this->translate->setJs();
        }else{
            $this->translate->setContent();
            $this->component->seo->setLang($this->translate->getChangeLang());
        }

        return true;
    }

}