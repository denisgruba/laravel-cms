<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class HelpersController extends Controller
{
    public function getinfo()
	{
		return view('getinfo');
	}
    

}
