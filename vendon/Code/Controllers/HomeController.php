<?php

namespace Vendon\Code\Controllers;

class HomeController
{
    private const VIEW_DIR = __DIR__.'/../../views/';

    public function index(): void
    {
        echo file_get_contents(self::VIEW_DIR.'/home.html');
    }

}
