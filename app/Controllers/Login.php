<?php

namespace App\Controllers;

class Login  extends BaseController
{
    public function __construct(){
        helper('form');
    }
    public function index(): string
    {
        return view('login_view');
    }
}
