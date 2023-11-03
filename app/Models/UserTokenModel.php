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

    // ここから追記
    // トークンの確認
    public function verifyToken($tokenText)
    {
        $now = date('Y-m-d H:i:s');
        $whereArray = [
            'token' => $tokenText,
            'expires_at >' => $now
        ];
        $userToken = $this->where($whereArray)->first();
        if ($userToken) {
            return $userToken['user_id'];
        } else {
            return null;
        }
    }

    // トークンの削除
    public function deleteToken($userId)
    {
        $this->where('user_id', $userId)->delete();
    }
    // ここまで追記
}
