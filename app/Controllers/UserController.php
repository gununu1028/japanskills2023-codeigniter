<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\UserTokenModel;

class UserController extends BaseController
{
    private $userModel;
    private $userTokenModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->userTokenModel = new UserTokenModel();
    }

    public function getUserShow()
    {
        // 認証チェック
        $user = $this->authenticatedUser();
        if (!$user) {
            $responseJson = [
                'success' => false,
            ];
            return $this->response
                ->setStatusCode(400)
                ->setJSON($responseJson);
        }

        // ユーザー情報をJSONで返す
        $responseJson = [
            'success' => true,
            'name' => $user['name'],
            'memo' => $user['memo'],
            'created_at' => $user['created_at'],
        ];
        return $this->response->setStatusCode(200)->setJSON($responseJson);
    }

    public function putUserUpdate()
    {
        // 認証チェック
        $user = $this->authenticatedUser();
        if (!$user) {
            $responseJson = [
                'success' => false,
            ];
            return $this->response->setStatusCode(400)->setJSON($responseJson);
        }

        // リクエストされたJSONを受け取る
        $jsonData = $this->request->getJSON();

        $data = [];
        if (isset($jsonData->name)) {
            $data['name'] = $jsonData->name;
        }
        if (isset($jsonData->memo)) {
            $data['memo'] = $jsonData->memo;
        }

        if (!empty($data)) {
            $this->userModel->update($user['id'], $data);
        }

        $updatedUser = $this->userModel->where('id', $user['id'])->first();

        // ユーザー情報をJSONで返す
        $responseJson = [
            'success' => true,
            'name' => $updatedUser['name'],
            'memo' => $updatedUser['memo'],
            'created_at' => $updatedUser['created_at'],
        ];
        return $this->response->setStatusCode(200)->setJSON($responseJson);
    }

    public function deleteUser()
    {
        // 認証チェック
        $user = $this->authenticatedUser();
        if (!$user) {
            $responseJson = [
                'success' => false,
            ];
            return $this->response->setStatusCode(400)->setJSON($responseJson);
        }

        $this->userModel->delete($user['id']);

        $responseJson = [
            'success' => true,
        ];
        return $this->response->setStatusCode(200)->setJSON($responseJson);
    }

    // ユーザーの認証などを行う
    // 認証できればuserのレコードを返す
    // 認証できないときはnullを返す
    private function authenticatedUser()
    {
        // Bearer認証
        $authHeader = $this->request->getHeaderLine('Authorization');

        log_message('info', 'authenticatedUserを実行');
        log_message('info', $authHeader);

        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        } else {
            return null;
        }

        // トークンの確認
        $userId = $this->userTokenModel->verifyToken($token);
        if (!$userId) {
            return null;
        }

        // ユーザーが利用可能であることを確認
        $user = $this->userModel->where('id', $userId)->first();
        if (!$user['active_status']) {
            return null;
        }

        return $user;
    }
}
