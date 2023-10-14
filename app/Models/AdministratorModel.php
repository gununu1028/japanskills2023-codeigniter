<?php
namespace App\Models;

use CodeIgniter\Model;

class AdministratorModel extends Model
{
    protected $table = 'administrators';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'password'];
    protected $returnType = 'array';

    // パスワードの確認
    public function verifyPassword($name, $password) {
        $admin = $this->where('name', $name)->first();
        if($admin && password_verify($password, $admin['password'])) {
            return $admin;
        }
        return null;
    }
}
