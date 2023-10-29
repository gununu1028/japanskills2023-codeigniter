<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    // テーブルを指定
    protected $table = 'user';
    // 主キーを指定
    protected $primaryKey = 'id';
    // 変更を許可するカラムを指定
    protected $allowedFields = ['name', 'password', 'active_status', 'memo'];
    // 作成日時、更新日時を指定
    protected $useTimestamps = true;

    // バリデーションルール
    public function getRules($id = null)
    {
        $rules = [
            'name' => [
                'rules'  => "required|is_unique[user.name,id,{$id}]",
                'errors' => [
                    'required' => 'ユーザー名は必須です。',
                    'is_unique' => 'このユーザー名は既に使用されています。'
                ],
            ],
            'password' => [
                'rules'  => 'required|min_length[8]',
                'errors' => [
                    'required' => 'パスワードは必須です。',
                    'min_length' => 'パスワードは8文字以上にしてください。'
                ],
            ],
        ];
        return $rules;
    }

    // パスワードの確認
    public function verifyPassword($name, $password)
    {
        $user = $this->where('name', $name)->first();
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }
}
