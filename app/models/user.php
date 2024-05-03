<?php

namespace app\models;
class user extends Model
{    

    public function __construct()
    {
        parent::__construct();
        $this->table = $this->connect();
        $this->fillable = [
            'name',
            'email',
            'passwd'
        ];
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
