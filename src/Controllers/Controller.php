<?php

namespace App\Controllers;

use App\Exceptions\ViewNotFoundException;

class Controller {

    /**
     * Render a given $view. Note that the file must be in the views directory.
     *
     * @param string $view
     * @return void
     */
    protected function render(string $view) {
        switch ($view) {
            // __DIR__ is src/Router. Go back ../../ to get 
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
                throw new ViewNotFoundException("$view not found.");
        }
    }

}
