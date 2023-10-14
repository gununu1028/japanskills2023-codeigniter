<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    // テーブルを指定
    protected $table = 'users';
    // 主キーを指定
    protected $primaryKey = 'id';
    // 変更を許可するカラムを指定
    protected $allowedFields = ['name', 'password', 'active_status'];
    // 作成日時、更新日時を指定
    protected $useTimestamps = true;
}
