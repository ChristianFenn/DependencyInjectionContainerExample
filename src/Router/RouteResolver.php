<?php

namespace App\Router;

use App\Controllers\HomeController;
use App\Controllers\AboutController;

class RouteResolver {

    /**
     * Undocumented function
     *
     * @param string $route
     * @return void
     */
    public function resolve(string $view) {
        switch ($view) {
            // __DIR__ is src/Router. Go back ../../
            case '/':
                (new HomeController)->index();
                break;
            case '/home':
                (new HomeController)->index();
                break;
            case '/about':
                (new AboutController)->index();
                break;
            default:
                http_response_code(404);
                require __DIR__ . '/../../views/errors/404.php';
        }
    }

}
