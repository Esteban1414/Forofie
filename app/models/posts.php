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
        $result = $this->select(['a.id, a.title', 'date_format(a.created_at,"%d/%m/%Y") as fecha', 'b.name'])
            ->join('user b', 'a.userId=b.id')
            ->where([['a.active', 1]])
            ->orderBy([['a.created_at', 'DESC']])
            ->limit($limit)
            ->get();
        return $result;
    }

    public function lastPost($limit = 1)
    {
        $result = $this->select(['a.id, a.title', 'date_format(a.created_at,"%d/%m/%Y") as fecha','a.body', 'b.name'])
            ->join('user b', 'a.userId=b.id')
            ->where([['a.active', 1]])
            ->orderBy([['a.created_at', 'DESC']])
            ->limit($limit)
            ->get();
        return $result;
    }

    public function getUserPosts($params)
    {
        $idUser = $params[2];
        $result = $this->select(['id, title', 'active', 'date_format(created_at,"%d/%m/%Y") as fecha'])
        ->where([['userId', $idUser]])
        ->orderBy([['created_at', 'DESC']])
        ->get();
        return $result;
    }

    public function saveNewPost($data){
        $this->values = [
            $data['userId'],
            $data['title'],
            $data['body']
        ];
        return $this->create();
    }
    
    public function openPost($id)
    {
        //print_r($id);
        $result = $this->select(['a.id', 'a.title', 'a.body', 'date_format(a.created_at,"%d/%m/%Y") as fecha', 'b.name'])
            ->join('user b', 'a.userId=b.id')
            ->where([['a.active', 1], ['a.id', $id]])
            ->get();
        return $result;
    }
    public function deletePost($id)
    {
        $result = $this->where([['id', $id]])
            ->delete();
        return $result;
    }

    public function saveOrUpdatePost($attributes, $values)
    {
        return $this->updateOrCreate($attributes, $values);
    }
}
