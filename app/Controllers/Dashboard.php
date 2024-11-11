<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->has('logged_user')) {
            return redirect()->to(base_url() . 'login');
        } 
        return view('dashboard_view');
    }

    public function logout()
    {
        session()->remove('logged_user');
        session()->destroy();
        return redirect()->to(base_url() . 'login');
    }
}
