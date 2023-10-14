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
            // セッションに管理者情報をセット
            session()->set('admin', $admin);
            session()->setFlashdata('success', 'ログインしました。');
            return redirect()->to('/admin/dashboard');
        } else {
            // エラーメッセージを表示
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

        // 1. バリデーション
        $rules = [
            'name' => [
                'rules'  => 'required|is_unique[users.name]',
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

        if (!$this->validate($rules)) {
            // エラー情報をフラッシュデータとしてセット
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        // 2. パスワードのハッシュ化
        $hashedPassword = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

        // 3. ユーザーの保存
        $data = [
            'name' => $this->request->getPost('name'),
            'password' => $hashedPassword,
            'active_status' => true
        ];

        if ($this->userModel->save($data)) {
            // 成功した場合のリダイレクトやメッセージ表示
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

    public function getUserEdit($id)
    {
        // 認証チェック
        if (!session()->has('admin')) {
            return redirect()->to('/admin/login');
        }

        $data['user'] = $this->userModel->find($id);
        return view('admin/user_edit', $data);
    }

    public function putUserUpdate($id)
    {
        // 認証チェック
        if (!session()->has('admin')) {
            return redirect()->to('/admin/login');
        }

        $name = $this->request->getPost('name');
        $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        $this->userModel->update($id, ['name' => $name, 'password' => $password]);
        session()->setFlashdata('success', 'ユーザー情報を更新しました。');
        return redirect()->to('/admin/user/' . $id);
    }

    public function deleteUser($id)
    {
        // 認証チェック
        if (!session()->has('admin')) {
            return redirect()->to('/admin/login');
        }

        $this->userModel->delete($id);
        session()->setFlashdata('success', 'ユーザーを削除しました。');
        return redirect()->to('/admin/user');
    }

    public function patchUserActiveStatus($id)
    {
        // 認証チェック
        if (!session()->has('admin')) {
            return redirect()->to('/admin/login');
        }

        $user = $this->userModel->find($id);
        $this->userModel->update($id, ['active_status' => !$user['active_status']]);

        session()->setFlashdata('success', 'ユーザーを更新しました。');
        return redirect()->to('/admin/user/' . $id);
    }
}
