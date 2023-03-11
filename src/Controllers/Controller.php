<?php

namespace App\Controllers;

class Controller {

    /**
     * Undocumented function
     *
     * @param string $view
     * @return void
     */
    protected function render(string $view) {
        switch ($view) {
            // __DIR__ is src/Router. Go back ../../
            case '/':
                require __DIR__ . "/../../views/$view.php";
                break;
            case 'home/index':
                require __DIR__ . "/../../views/$view.php";
                break;
            case 'about/index':
                require __DIR__ . "/../../views/$view.php";
                break;
            default:
                http_response_code(404);
                require __DIR__ . '/../../views/errors/404.php';
        }
    }

}
