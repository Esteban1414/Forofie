<?php

namespace app\models;
class user extends Model
{
       
    protected $fillable = [
        'name',
        'email',
        'passwd'
    ];
    protected $values = [];
    

    public function __construct()
    {
        parent::__construct();
        $this->table = $this->connect();
    }

    public function registerUser($data)
    {
        $this->values = [
            $data["name"],
            $data["email"],
            $data["passwd"], /* encriptar */
        ];
        return $this->create();
    }
}
