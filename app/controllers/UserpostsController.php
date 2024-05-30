<?php

namespace app\controllers;

use app\classes\Csrf;
use app\classes\Redirect;
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


    public function getMyPosts($params = null)
    {
        $posts = new posts;
        $res = $posts->getUserPosts($params);
        echo $res;
    }

    public function newPost(){

        $Csrf = new Csrf;
        $ua = session::sessionValidate() ?? ['sv' => 0];
        View::render('newposts', ['ua' => $ua]);
    }

    public function saveNewPost(){
        $post = new posts;
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        if(!isset($data['title']) || !isset($data['body'])){
            echo json_encode(['r' => false, 'code' => 1]); /* 1 = datos incompletos */
        }
        $data['userId'] = session::sessionValidate()['id'];
        $cond = [
            'title' => $data['title']
        ];
        $val = [
            'userId' => $data['userId'],
            'body' => $data['body']     
           ];
        $post->saveOrUpdatePost($cond, $val);
        Redirect::to('home');
    }
    public function deletePost($params){
        //print_r($params);die();
        $post = new posts();
        echo json_encode( ['r' => $post->deletePost($params[2])] );
        //$this->getMyPosts([ 2 => $params['userId'] ]);
    }

}
