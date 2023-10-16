<?php

namespace App\Controllers;

use App\Models\AdministratorModel;
use App\Models\UserModel;

class AdminController extends BaseController
{
    private $administratorModel;
    private $userModel;

    public function __construct()
    {
        helper('form');
        $this->administratorModel = new AdministratorModel();
        $this->userModel = new UserModel();
    }

    public function getLogin()
    {
        return view('admin/login');
    }

    public function postLogin()
    {
        $name = $this->request->getPost('name');
        $password = $this->request->getPost('password');

        $admin = $this->administratorModel->verifyPassword($name, $password);
        if ($admin) {
            session()->set('admin', $admin);
            session()->setFlashdata('success', 'ログインしました。');
            return redirect()->to('/admin/dashboard');
        } else {
            session()->setFlashdata('error', 'ユーザー名またはパスワードが正しくありません。');
        }
        return view('admin/login');
    }

    public function getDashboard()
    {
        // 認証チェック
        if (!session()->has('admin')) {
            return redirect()->to('/admin/login');
        }
        return view('admin/dashboard');
    }
}
