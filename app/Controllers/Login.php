<?php

namespace App\Controllers;

use App\Models\LoginModel;
use Config\Database;
use Google\Client;
use Google\Service\Oauth2;

class Login  extends BaseController
{
    public $loginModel;
    public $session;

    public function __construct()
    {
        helper('form');
        $this->loginModel = new LoginModel();
        $this->session = session();
    }

    public function index()
    {
        $data = [];
        require_once APPPATH . "libraries/vendor/autoload.php";

        // Login with tred
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
                            $login_info = [
                                'uniid' => $userdata['uniid'],
                                'agent' => $this->getUserAgentInfo(),
                                'ip' => $this->request->getIPAddress(),
                                'login_time' => date('Y-m-d h:i:s'),
                            ];

                            $la_id = $this->loginModel->saveLoginInfo($login_info);

                            if ($la_id) {
                                $this->session->set('logged_info', $la_id);
                            }

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


        // login with google
        $google_client = new Client();
        $google_client->setClientID('YOUR_ClintID');
        $google_client->setClientSecret('YOUR_Secret');
        $google_client->setRedirectUri(base_url() . 'login');
        $google_client->addScope('email');
        $google_client->addScope('profile');

        if ($this->request->getVar('code')) {
            $token = $google_client->fetchAccessTokenWithAuthCode($this->request->getVar('code'));
            if (!isset($token['error'])) {
                $google_client->setAccessToken($token['access_token']);
                $this->session->set('access_token', $token['access_token']);
                $google_service = new Oauth2($google_client);
                $data['googleUserData'] = $google_service->userinfo->get();

                $userData = [
                    'id' => $data['googleUserData']->getId(),
                    'email' => $data['googleUserData']->getEmail(),
                    'name' => $data['googleUserData']->getName(),
                    'picture' => $data['googleUserData']->getPicture(),
                ];

                // Check if Google user exists in the database
                if ($this->loginModel->google_user_exists($userData['id'])) {
                    // Update user data if exists
                    $dataUser = [
                        'first_name' => explode(' ', $userData['name'])[0] ?? '',
                        'last_name' => explode(' ', $userData['name'])[1] ?? '',
                        'email' => $userData['email'],
                        'profile_pic' => $userData['picture'],
                    ];
                    $this->loginModel->updateUser($userData['id'], $dataUser);
                } else {
                    // Insert new user if not found
                    $dataUser = [
                        'oauth_id' => $userData['id'],
                        'first_name' => explode(' ', $userData['name'])[0] ?? '',
                        'last_name' => explode(' ', $userData['name'])[1] ?? '',
                        'email' => $userData['email'],
                        'profile_pic' => $userData['picture'],
                    ];
                    $this->loginModel->insertUser($dataUser);
                }

                // Store user info in session
                $this->session->set('google_user', $dataUser);

                return redirect()->to(base_url() . 'dashboard');
            }
        }

        // Generate Google login URL
        $data['loginButton'] = $google_client->createAuthUrl();

        // If access token exists, hide the Google login button
        if ($this->session->get('access_token')) {
            $data['loginButton'] = '';
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
