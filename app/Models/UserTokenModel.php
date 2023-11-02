<?php

namespace App\Models;

use CodeIgniter\Model;

class UserTokenModel extends Model
{
    protected $table = 'user_token';
    protected $allowedFields = ['user_id', 'token', 'expires_at'];

    // トークンを発行
    public function issueToken($userId)
    {
        $token = bin2hex(random_bytes(16));
        $data = [
            'user_id' => $userId,
            'token'   => $token,
            'expires_at' => date('Y-m-d H:i:s', strtotime('+2 hour'))
        ];
        $this->save($data);
        return $token;
    }
}
