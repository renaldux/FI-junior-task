<?php

namespace App\Http\Controllers;

use DB;
use App\Account;
use App\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AcountsController extends Controller
    {

        public function __construct()
        {
            $this->middleware('auth');
        }

        /**
         * @param Request $request
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * @throws \Exception
         */
        public function dashboard(Request $request)
        {
            $accounts = Account::where('user_id', Auth::id())->get();
            return view('dashboard', ['accounts' => $accounts]);
        }

        /**
         * @param Request $request
         * @return \Illuminate\Http\RedirectResponse
         */
        public function create(Request $request)
        {
            try {
                $account = new Account();
                $account->createNewAccount();
            } catch (\Exception $e) {
                Log::error($e->getTraceAsString());
                return redirect()->route('dashboard')->withErrors([$e->getMessage()]);
            }
            return redirect()->route('dashboard');
        }


        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function transfer()
        {
            $accounts_info = Account::where('user_id', Auth::id())->get();
            $accounts_numbers = $accounts_info->pluck('account_no');
            return view('transfer', ['accounts' => $accounts_numbers]);
        }
    }


