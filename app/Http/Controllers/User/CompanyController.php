<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


class CompanyController extends Controller
{
    public function index(Request $request)
    {
       //
    }
    public function aboutUs(){
    return view('user.company.about-us');
    }

}