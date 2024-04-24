<?php

namespace app\controllers\auth;

use app\controllers\Controller;
use app\classes\View;

class SessionController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function iniSession($params = null)
    {
        $response = [
            'title' => "Iniciar Sessión",
            'code' => 200
        ];
        View::render('auth/inisession', $response);
    }
}
