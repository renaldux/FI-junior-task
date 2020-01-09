<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     * @throws \Exception
     */
    public function index()
    {
        //check if account exists, if not - crate
        $account = new Account();
        if (!$account->where('user_id', Auth::id())->first()) {
            //account does not exist, creating new
            $account->createNewAccount();
        }
        return view('dashboard');
    }
}
