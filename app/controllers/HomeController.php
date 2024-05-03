<?php

namespace app\controllers;

use app\classes\View;
use app\controllers\auth\SessionController as session;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($params = null)
    {
        $response = [
            'ua' => session::sessionValidate() ?? ['sv' => false],
            'title' => 'Foro FIE',
            'code' => 200
        ];
        View::render('home', $response);
    }
}
