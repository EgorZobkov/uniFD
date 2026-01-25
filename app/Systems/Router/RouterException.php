<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 */

namespace App\Systems\Router;

use Exception;

class RouterException
{
    /**
     * Create Exception Class.
     *
     * @param string $message
     *
     * @param int    $statusCode
     *
     * @throws Exception
     */
    public function __construct(string $message, int $statusCode = 404)
    {
        if($statusCode == 404){
            abort(404);
        }else{
            throw new Exception($message, $statusCode);
        }
    }
}
