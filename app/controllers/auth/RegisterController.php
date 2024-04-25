<?php

namespace app\controllers\auth;

use app\controllers\Controller;
use app\classes\View;
use app\models\Model;
use app\models\user;

class RegisterController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index (){
        
        $response = [
        'title' => 'Registro',
        'code' => 200
        ];
        View::render('auth/register', $response);
    }

    public function register()
    {
        $user = new user;
        $res = $user->registerUser(filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS));
        echo json_encode(["r" => $res]);
    }
}
