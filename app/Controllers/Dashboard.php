<?php

namespace App\Controllers;

use App\Models\DashboardModel;

class Dashboard extends BaseController
{
    public $dashboardModel;

    public function __construct()
    {
        $this->dashboardModel = new DashboardModel();
    }


    public function index()
    {
        if (!session()->has('logged_user')) {
            return redirect()->to(base_url() . 'login');
        }
        $unnid = session()->get('logged_user');

        // $userdata = 
        // print_r($userdata);
        $data['userdata'] = $this->dashboardModel->getLoggedUserData($unnid);
        return view('dashboard_view', $data);
    }

    public function logout()
    {
        if (session()->has('logged_info')) {
            $la_id = session()->get('logged_info');
            $this->dashboardModel->updateLogoutTime($la_id);
        }

        session()->remove('logged_user');
        session()->destroy();
        return redirect()->to(base_url() . 'login');
    }

    public function login_activity()
    {

        $data['userdata'] = $this->dashboardModel->getLoggedUserData(session()->get('logged_user'));
        $data['login_info'] = $this->dashboardModel->getLoginUserInfo(session()->get('logged_user'));
        return view('login_activity_view', $data);
    }
}
