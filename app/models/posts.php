<?php

namespace app\models;

class posts extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->table = $this->connect();
        $this->fillable = [
            'userId',
            'title',
            'body'
        ];
    }

    public function getAllPosts($limit = 5)
    {
        // $result = $this->all()->get();
        $result = $this->select(['a.title', 'date_format(a.created_at,"%d/%m/%Y") as fecha', 'b.name'])
            ->join('user b', 'a.userId=b.id')
            ->where([['a.active', 1]])
            ->orderBy([['a.created_at', 'DESC']])
            ->limit($limit)
            ->get();
        return $result;
    }

    public function lastPost($limit = 1){
        $result = $this->select(['a.id, a.title', 'date_format(a.created_at,"%d/%m/%Y") as fecha', 'b.name'])
            ->join('user b', 'a.userId=b.id')
            ->where([['a.active', 1]])
            ->orderBy([['a.created_at', 'DESC']])
            ->limit($limit)
            ->get();
        return $result;
    }
}
