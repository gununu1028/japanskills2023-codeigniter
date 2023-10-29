<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\UserTokenModel;

class AuthController extends BaseController
{
    private $userModel;
    private $userTokenModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->userTokenModel = new UserTokenModel();
    }

    public function postSignup()
    {
        // リクエストされたJSONを受け取る
        $jsonData = $this->request->getJSON();
        $name = $jsonData->name;
        $password = $jsonData->password;
        // パスワードを暗号化
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'name' => $name,
            'password' => $hashedPassword,
            'active_status' => true
        ];

        // バリデーションチェック
        if (!$this->validate($this->userModel->getRules())) {
            $responseJson = [
                'success' => false,
            ];
            return $this->response->setStatusCode(400)->setJSON($responseJson);
        }

        // userを作成
        $this->userModel->save($data);

        // 作成したuserを取得
        $user = $this->userModel->where('name', $name)->first();

        // userのトークンを発行
        $token = $this->userTokenModel->issueToken($user['id']);

        // ユーザー情報をJSONで返す
        $responseJson = [
            'success' => true,
            'token' => $token,
        ];
        return $this->response->setStatusCode(200)->setJSON($responseJson);
    }

    public function postLogin()
    {
        $jsonData = $this->request->getJSON();
        $name = $jsonData->name;
        $password = $jsonData->password;

        $user = $this->userModel->verifyPassword($name, $password);

        if (!$user) {
            $responseJson = [
                'success' => false,
            ];
            return $this->response->setStatusCode(400)->setJSON($responseJson);
        }

        if (!$user['active_status']) {
            $responseJson = [
                'success' => false,
            ];
            return $this->response->setStatusCode(400)->setJSON($responseJson);
        }

        $token = $this->userTokenModel->issueToken($user['id']);
        $responseJson = [
            'success' => true,
            'token' => $token,
        ];
        return $this->response->setStatusCode(200)->setJSON($responseJson);
    }

    public function postLogout()
    {
        $authHeader = $this->request->getHeaderLine('Authorization');
        $token = null;
        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $userId = $this->userTokenModel->verifyToken($token);
        if (!$userId) {
            $responseJson = [
                'success' => false,
            ];
            return $this->response->setStatusCode(400)->setJSON($responseJson);
        }

        $this->userTokenModel->deleteToken($userId);

        $responseJson = [
            'success' => true,
        ];
        return $this->response->setStatusCode(200)->setJSON($responseJson);
    }
}
