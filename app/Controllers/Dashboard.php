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
        $data = [];

        // Check if user is logged in
        if (!(session()->has('logged_user') || session()->has('google_user'))) {
            return redirect()->to(base_url() . 'login');
        }

        // Check if user is logged in via Google or traditional login
        if (session()->has('google_user')) {
            $data['googleUserData'] = session()->get('google_user');
        } else {
            $unnid = session()->get('logged_user');
            $data['userdata'] = $this->dashboardModel->getLoggedUserData($unnid);
        }

        return view('dashboard_view', $data);
    }

    public function logout()
    {
        if (session()->has('logged_info')) {
            $la_id = session()->get('logged_info');
            $this->dashboardModel->updateLogoutTime($la_id);
        }

        session()->remove('logged_user');
        session()->remove('google_user');
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
