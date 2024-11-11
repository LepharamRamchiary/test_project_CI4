<?php

namespace App\Controllers;

use App\Models\LoginModel;
use Google\Client;
use Google\Service\Oauth2;
use Google\Service\Oauth2\Userinfo;


class Login  extends BaseController
{
    public $loginModel;
    public $session;
    public function __construct()
    {
        helper('form');
        $this->loginModel = new LoginModel();
        // $session = \Config\Services::session();
        $this->session = session();
    }
    public function index()
    {
        $data = [];
        // if ($this->request->getMethod() == 'POST') {
        //     $rules = [
        //         'email' => 'required|valid_email',
        //         'password' => 'required',
        //     ];

        //     if ($this->validate($rules)) {
        //         $email = $this->request->getVar('email');
        //         $password = $this->request->getVar('password');

        //         $userdata = $this->loginModel->verifyEmail($email);

        //         if ($userdata) {
        //             if (password_verify($password, $userdata['password'])) {
        //                 if ($userdata['status'] == 'active') {
        //                     $login_info = [
        //                         'uniid' => $userdata['uniid'],
        //                         'agent' => $this->getUserAgentInfo(),
        //                         'ip' => $this->request->getIPAddress(),
        //                         'login_time' => date('Y-m-d h:i:s'),
        //                     ];

        //                     $la_id = $this->loginModel->saveLoginInfo($login_info);

        //                     if($la_id){
        //                         $this->session->set('logged_info', $la_id);
        //                     }

        //                     $this->session->set('logged_user', $userdata['uniid']);
        //                     return redirect()->to(base_url() . 'dashboard');
        //                 } else {
        //                     $this->session->setTempdata('error', 'Your account is not active. Please contact admin or Activeted your account.', 3);
        //                     return redirect()->to(current_url());
        //                 }
        //             } else {
        //                 $this->session->setTempdata('error', 'Wrong password entered from email.', 3);
        //                 return redirect()->to(current_url());
        //             }
        //         } else {
        //             $this->session->setTempdata('error', 'Sorry! Email does not exist.', 3);
        //             return redirect()->to(current_url());
        //         }
        //     } else {
        //         $data['validation'] = $this->validator;
        //     }
        // }
        require_once APPPATH . "libraries/vendor/autoload.php";



        $google_client = new Client();
        $google_client->setClientID('');
        $google_client->setClientSecret('');
        $google_client->setRedirectUri(base_url() . 'login');
        $google_client->addScope('email');
        $google_client->addScope('profile');

        if ($this->request->getVar('code')) {
            $token = $google_client->fetchAccessTokenWithAuthCode($this->request->getVar('code'));
            if (!$token['error']) {
                $google_client->setAccessToken($token['access_token']);
                $this->session->set('access_token', $token['access_token']);
                // to get the profile data 
                $google_service = new Oauth2($google_client);
            }
        }

        return view('login_view', $data);
    }

    public function getUserAgentInfo()
    {
        $agent = $this->request->getUserAgent();

        if ($agent->isBrowser()) {
            $currentAgent = $agent->getBrowser();
        } else if ($agent->isRobot()) {
            $currentAgent = $agent->getRobot();
        } else if ($agent->isMobile()) {
            $currentAgent = $agent->getMobile();
        } else {
            $currentAgent = 'Unidentified User Agent';
        }
        return $currentAgent;
    }
}
