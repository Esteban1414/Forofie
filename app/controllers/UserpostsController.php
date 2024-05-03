<?php

namespace app\controllers;

use app\classes\View;
use app\controllers\auth\SessionController as session;
use app\models\posts;

class UserpostsController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $ua = session::sessionValidate();
        if (is_null($ua)) {
            View::render('home', ['ua' => ['sv' => 0], 'title' => 'Foro Fie']);
            exit();
        }
        View::render('myposts', ['ua' => $ua, 'title' => 'Mis Publicaciones']);
    }
}
