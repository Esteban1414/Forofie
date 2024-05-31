<?php

namespace app\controllers;

use app\classes\View;
use app\controllers\auth\SessionController as session;
use app\classes\Redirect;
use app\models\user;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($params = null)
    {
        $ua = session::sessionValidate();
        if (is_null($ua)) {
            View::render('home', ['ua' => $ua, 'title' => 'Foro FIE']);
            exit();
        }
        View::render('auth/userprofile', ['ua' => $ua, 'title' => 'Mi perfil']);
    }
    
    public function update()
    {
        $user = new user;
        $res = $user->updateUser(filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS));
        echo json_encode(["r" => $res]);

    }
}
