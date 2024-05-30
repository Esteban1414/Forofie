<?php

namespace app\models;

class comments extends Model
{

    protected $table;
    protected $fillable = [
        'postId',
        'userId',
        'body',
    ];
    public $values = [];

    public function __construct()
    {
        parent::__construct();
        $this->table = $this->connect();
    }

    public function getComments($pid)
    {
        $result = $this->select(['a.id', 'a.body', 'date_format(a.created_at,"%d/%m/%Y") as fecha', 'b.name'])
            ->join('user b', 'a.userId=b.id')
            ->where([['a.active', 1], ['a.postId', $pid]])
            ->get();
        return $result;
    }

    public function newComment($data)
    {
        $this->values = [
            $data['pid'],
            $data['uid'],
            $data['body'],
        ];
        return $this->create();
    }
}
