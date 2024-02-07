<?php

//client id : 251991612516-sek13hjta9fh1npvupr9ddd5aahcc7a0.apps.googleusercontent.com
//client secret : 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

namespace App\Controllers;

use App\Models\UsersModel;
use Google_Client;

class Login extends BaseController
{
    protected $googleClient;
    protected $users;
    public function __construct()
    {
        session();
        $this->users = new UsersModel();
        $this->googleClient = new Google_Client();

        $this->googleClient->setClientId('251991612516-sek13hjta9fh1npvupr9ddd5aahcc7a0.apps.googleusercontent.com');
        $this->googleClient->setClientSecret('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');
        $this->googleClient->setRedirectUri('http://localhost:8080/login/proses');
        $this->googleClient->addScope('email');
        $this->googleClient->addScope('profile');
    }
    public function index()
    {
        $data['link'] = $this->googleClient->createAuthUrl();
        return view('loginpage', $data);
    }
    public function proses()
    {
        $token = $this->googleClient->fetchAccessTokenWithAuthCode($this->request->getVar('code'));
        if (!isset($token['error'])) {
            $this->googleClient->setAccessToken($token['access_token']);
            $googleService = new \Google_Service_Oauth2($this->googleClient);
            $data = $googleService->userinfo->get();

            $row = [
                'id' => $data['id'],
                'nama_users' => $data['name'],
                'email' => $data['email'],
                'profile' => $data['picture']
            ];
            $this->users->save($row);
            session()->set($row);
            return view('admin/home');
        }
    }
    public function keluar()
    {
        session_destroy();
        return redirect()->to('login');
    }
}
