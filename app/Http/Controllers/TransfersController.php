<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;
use App\Transfer;
use Illuminate\Support\Facades\Auth;

class TransfersController extends Controller
{
    public function getTransfers(){
        $transfers = Transfer::where('user_id', Auth::id())->orderBy('created_at', 'DESC')->get();
        return view('mytransfers')->with('transfers',$transfers);
    }
}
