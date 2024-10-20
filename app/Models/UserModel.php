<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    // テーブルを指定
    protected $table = 'users';

    // パスワードの確認
    public function verifyPassword($email, $password)
    {
        $user = $this->where('email', $email)->first();
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }
}
