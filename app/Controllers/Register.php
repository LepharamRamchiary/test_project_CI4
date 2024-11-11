<?php

namespace App\Controllers;

use App\Models\RegisterModel;

class Register  extends BaseController
{
    public $registerModel;
    public $session;
    public $email;
    public function __construct()
    {
        helper(['form', 'date']);
        $this->registerModel = new RegisterModel();
        $this->session = \Config\Services::session();
        $this->email = \Config\Services::email();
    }
    public function index()
    {
        $data = [];
        $data['validation'] = null;
        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'username' => 'required|min_length[3]|max_length[20]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'phone' => 'required|exact_length[10]|is_unique[users.phone]|numeric',
                'password' => 'required|min_length[6]|max_length[16]|alpha_numeric',
                'conf_password' => 'required|matches[password]',
            ];

            if ($this->validate($rules)) {
                $uniid = md5(str_shuffle('abcdefghijklmnopqrstuvwxyz' . time()));
                $userdata = [
                    'username' => $this->request->getVar('username', FILTER_SANITIZE_STRING),
                    'email' => $this->request->getVar('email'),
                    'phone' => $this->request->getVar('phone'),
                    'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                    'uniid' => $uniid,
                    'activation_date' => date('Y-m-d H:i:s'),
                ];

                if ($this->registerModel->createUser($userdata)) {
                    $to = $this->request->getVar('email');
                    $subject = 'Account Activation - FinCo';
                    $message = 'Hi ' . $this->request->getVar('username', FILTER_SANITIZE_STRING) . ',<br><br>Thanks your account create successfully' . '<br><br>Please click the link below to activate your account.<br><br>' . '<a href="' . base_url() . 'register/activate/' . $uniid . '" target="_blank">Activate Now</a>';

                    $this->email->setTo($to);
                    $this->email->setFrom('lepharamchiary123@gmail.com', 'Info');
                    $this->email->setSubject($subject);
                    $this->email->setMessage($message);
                    if ($this->email->send()) {
                        $this->session->setTempdata('success', 'Account Created Successfully. Please check your email for activation link.', 3);
                        return redirect()->to(current_url());
                    } else {
                        $this->session->setTempdata('error', 'Account Created Successfully. Unable to send activation link. Contact Admin', 3);
                        return redirect()->to(current_url());
                    }
                } else {
                    $this->session->setTempdata('error', 'Sorry! Unable to create your account.', 3);
                    return redirect()->to(current_url());
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('register_view', $data);
    }

    public function activate($uniid = null)
    {

        $data = [];
        if (!empty($uniid)) {
            $userdata = $this->registerModel->verifyUniid($uniid);
            // print_r($data);
            // exit;

            if ($userdata) {
                if ($this->verifyExpiryTime($userdata->activation_date)) {
                   if($userdata->status == 'inactive'){
                      $status = $this->registerModel->updateStatus($uniid);
                      if($status){
                          $data['success'] = 'Your account is actived successfully.';
                      }else{
                          $data['error'] = 'Sorry! Unable to activate your account.';
                      }
                   }else{
                    $data['success'] = 'Your account is already actived.';
                   }
                } else {
                    $data['error'] = 'Sorry! Activation link was expired.';
                }
            } else {
                $data['error'] = 'Sorry! We are unable to find your account.';
            }
        } else {
            $data['error'] = 'Sorry! Unable to activate your account.';
        }

        return view('activate_view', $data);
    }

    public function verifyExpiryTime($resTime)
    {
        $currTime = now();
        $regtime = strtotime($resTime);
        $diffTime = $currTime - $regtime;

        if (3600 > $diffTime) {
            return true;
        } else {
            return false;
        }
    }
}
