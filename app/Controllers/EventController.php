<?php

namespace App\Controllers;

use App\Models\EventModel;

class EventController extends BaseController
{
    private $eventModel;

    public function __construct()
    {
        helper('form');
        $this->eventModel = new EventModel();
    }

    public function getEventList()
    {
        // 認証チェック
        if (!session()->has('admin')) {
            return redirect()->to('/admin/login');
        }
        $event_list = $this->eventModel->findAll();
        return view('admin/event/list', ['event_list' => $event_list]);
    }

    public function getEventNew()
    {
        // 認証チェック
        if (!session()->has('admin')) {
            return redirect()->to('/admin/login');
        }
        return view('admin/event/new');
    }

    public function postEventCreate()
    {
        // 認証チェック
        if (!session()->has('admin')) {
            return redirect()->to('/admin/login');
        }
        $data = [
            'name' => $this->request->getPost('name'),
            'place' => $this->request->getPost('place'),
            'event_date' => $this->request->getPost('event_date')
        ];
        $this->eventModel->insert($data);
        session()->setFlashdata('success', 'イベント情報が登録されました。');
        return redirect()->to(uri: '/admin/event/');
    }
}
