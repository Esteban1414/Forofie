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
            sha1($data['passwd']),
        ];
        return $this->create();
    }
    
    public function updateUser($data)
    {
        $user = new user;

        $stmt = $user->where([['id', $data['userId']]])->get();

        $result = json_decode($stmt);

        if (empty($result)) {
            echo json_encode(["r" => 'false']);
            return;
        }

        if ($result[0]->passwd !== sha1($data['old_passwd'])) {
            echo json_encode(['r' => 'false']);
            return;
        }

        $updateData = [
            ['name', $data['name']],
            ['email', $data['email']],
        ];

        if (!empty($data['passwd'])) {
            $updateData[['passwd', sha1($data['passwd'])]];
        }

        return $user->where([['id', $data['userId']]])->update($updateData);

    }
}
