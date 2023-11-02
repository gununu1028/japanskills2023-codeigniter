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

    public function postLogin()
    {
        // リクエストされたJSONを受け取る
        $jsonData = $this->request->getJSON();
        $name = $jsonData->name;
        $password = $jsonData->password;

        // パスワードチェック
        $user = $this->userModel->verifyPassword($name, $password);

        // 該当するuserがなければ、認証失敗
        if (!$user) {
            $responseJson = [
                'success' => false,
            ];
            return $this->response->setStatusCode(400)->setJSON($responseJson);
        }

        // userが利用不可であれば、認証失敗
        if (!$user['active_status']) {
            $responseJson = [
                'success' => false,
            ];
            return $this->response->setStatusCode(400)->setJSON($responseJson);
        }

        // トークンを発行
        $token = $this->userTokenModel->issueToken($user['id']);

        // JSONを返す
        $responseJson = [
            'success' => true,
            'token' => $token,
        ];
        return $this->response->setStatusCode(200)->setJSON($responseJson);
    }
}
