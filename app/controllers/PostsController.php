<?php

namespace app\controllers;

use app\models\posts;
use app\models\interactions as inter;

class PostsController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getPosts()
    {
        $posts = new posts();
        $result = $posts->getAllPosts();
        echo $result;
    }
    
    public function getLastPost()
    {
        $posts = new posts();
        $result = $posts->lastPost();
        echo $result;
    }

    public function toggleLike($params)
    {
        $inter = new inter;
        $inter->toggleLike($params);
        $ri = $inter
            ->count('postId')
            ->where([['postId', $params[2]]])
            ->get();
        $ri = self::youLiked($ri);
        echo $ri;
    }
    private static function youLiked($ri = null)
    {

        if ($_SESSION['sv']) {
            $inter = new inter;
            $ri = json_decode($ri);
            $ri[0]->liked = json_decode($inter
                ->count()
                ->where([
                    ['postId', $ri[0]->postId],
                    ['userId', $_SESSION['id']]
                ])
                ->get())[0]->tt > 0 ? true : false;
            return $ri;
        }
    }
}
