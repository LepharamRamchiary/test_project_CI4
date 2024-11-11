<?php

namespace App\Controllers;

use App\Models\LoginModel;

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
        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'email' => 'required|valid_email',
                'password' => 'required',
            ];

            if ($this->validate($rules)) {
                $email = $this->request->getVar('email');
                $password = $this->request->getVar('password');

                $userdata = $this->loginModel->verifyEmail($email);

                if ($userdata) {
                    if (password_verify($password, $userdata['password'])) {
                        if ($userdata['status'] == 'active') {
                            $this->session->set('logged_user', $userdata['uniid']);
                            return redirect()->to(base_url() . 'dashboard');
                        } else {
                            $this->session->setTempdata('error', 'Your account is not active. Please contact admin or Activeted your account.', 3);
                            return redirect()->to(current_url());
                        }
                    } else {
                        $this->session->setTempdata('error', 'Wrong password entered from email.', 3);
                        return redirect()->to(current_url());
                    }
                } else {
                    $this->session->setTempdata('error', 'Sorry! Email does not exist.', 3);
                    return redirect()->to(current_url());
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('login_view', $data);
    }
}
