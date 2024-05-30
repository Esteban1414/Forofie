<?php

namespace app\controllers;

use app\models\posts;
use app\models\interactions as inter;
use app\models\comments as comments;

class PostsController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getPosts($pid = null)
    {
      
        $posts = new posts();
        if ($pid == null) {
            $result = $posts->getAllPosts();
            echo $result;
                } else {
            $rp = $posts->openPost($pid[2]); //de Router $params = $this->uri que tiene 3 elementos para este caso: 0=>Posts, 1=>getPosts, 2=>id
            $comments = new comments();
            $rc = $comments->count('postId')->where([['postId', $pid[2]]])->get();
            $inter = new inter();
            $ri = $inter->count('postId')->where([['postId', $pid[2]]])->get();
            // if($_SESSION['sv']){
            //     $ri = json_decode($ri);
            //     $ri[0]->liked = json_decode($inter->count()->where([['postId',$pid[2]],['userId',$_SESSION['id']]])->get())[0]->tt > 0 ? true : false;
            //     $ri = json_encode($ri);
            // }
            $ri = self::youLiked($ri);
            echo json_encode(array_merge(json_decode($rp), json_decode($ri), json_decode($rc)));
        }
    }
    
    public function getLastPost()
    {
        $posts = new posts();
        $rp = json_decode($posts->lastPost());
        if (count($rp) > 0) {
            $comments = new comments();
            $rc = $comments->count('postId')->where([['postId', $rp[0]->id]])->get();

            $inter = new inter();
            $ri = $inter->count('postId')->where([['postId', $rp[0]->id]])->get();
            $ri = self::youLiked($ri);
            echo json_encode(array_merge($rp, array_merge($ri), json_decode($rc)));
        } else {
            echo json_encode(["r" => false]);
        }
    }

   public function toggleLike($args)
    {
        $inter = new inter();
        list(,, $pid, $uid) = $args;
        $inter->toggleLike($pid, $uid);
        $ri = $inter->count('postId')->where([['postId', $pid]])->get();
        $ri = self::youLiked($ri);
        echo json_encode($ri);
    }

    private static function youLiked($ri)
    {
session_start();
        if ($_SESSION['sv']) {
            $inter = new inter;
            $ri = json_decode($ri);
            $ri[0]->liked = json_decode($inter
                ->count('postId')
                ->where([
                    ['postId', $ri[0]->postId],
                    ['userId', $_SESSION['id']]
                ])
                ->get())[0]->tt > 0 ? true : false;
            return $ri;
        }
        session_write_close();
    }
    /** Comentarios */

    public function getComments($args)
    {
        $coments = new comments();
        $pid = $args[2];
        echo $coments->getComments($pid);
    }

    public function saveComment($args)
    {
        $comments = new comments();
        $data     = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        $result   = $comments->newComment($data);
        $rc       = $comments->count('postId')->where([['postId', $data['pid']]])->get();
        echo $rc;
    }
    
}
