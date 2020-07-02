<?php

namespace App\Http\Controllers\Admin;

class HomeController
{
    public function index()
    {
        return redirect()->route('admin.loan-applications.index');
    }
}
