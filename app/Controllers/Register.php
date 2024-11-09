<?php

namespace App\Controllers;

class Register  extends BaseController
{
    public function __construct(){
        helper('form');
    }
    public function index(): string
    {
        return view('register_view');
    }
}
