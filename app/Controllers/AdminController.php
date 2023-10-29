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

    // ここから追記
    public function getUserList()
    {
        // 認証チェック
        if (!session()->has('admin')) {
            return redirect()->to('/admin/login');
        }

        $users = $this->userModel->findAll();
        return view('admin/user_list', ['users' => $users]);
    }

    public function getUserNew()
    {
        // 認証チェック
        if (!session()->has('admin')) {
            return redirect()->to('/admin/login');
        }

        return view('admin/user_new');
    }

    public function postUserCreate()
    {
        // 認証チェック
        if (!session()->has('admin')) {
            return redirect()->to('/admin/login');
        }

        // バリデーションチェック
        if (!$this->validate($this->userModel->getRules())) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        $password = $this->request->getPost('password');
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $data = [
            'name' => $this->request->getPost('name'),
            'password' => $hashedPassword,
            'active_status' => true
        ];

        if ($this->userModel->save($data)) {
            session()->setFlashdata('success', 'ユーザーが正常に作成されました。');
            return redirect()->to('/admin/user');
        }
    }

    public function getUserShow($id)
    {
        // 認証チェック
        if (!session()->has('admin')) {
            return redirect()->to('/admin/login');
        }

        $data['user'] = $this->userModel->find($id);
        return view('admin/user_show', $data);
    }
    // ここまで追記

}
