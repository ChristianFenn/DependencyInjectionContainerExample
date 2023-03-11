<?php

namespace App\Controllers;

use App\Controllers\Controller;

class AboutController extends Controller {

    public function index() {
        return $this->render('about/index');
    }

}
