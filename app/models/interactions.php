<?php

namespace app\models;

class interactions extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->table = $this->connect();
        $this->fillable = [
            'userId',
            'postId',
            'tipo'
        ];
    }

    public function toggleLike($params){
        $postId = $params[2];
        $userId = $params[3];

    }

}