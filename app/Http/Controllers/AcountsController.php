<?php

namespace App\Http\Controllers;

use App\Account;
use App\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Exception;

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
        public function getMyAccounts(Request $request)
        {
            $accounts = Account::where('user_id', Auth::id())->get();
            if (!$accounts->count()) {
                return redirect()->route('newAccount');
            }
            return view('dashboard', ['accounts' => $accounts]);
        }

        /**
         * @param Request $request
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Exception
         */
        public function newAccount(Request $request)
        {
            $account = new Account();
            $account->createNewAccount();
            return redirect()->route('dashboard');
        }


        /**
         * creates user account
         * @param Request $request
         * @return string
         */
        public function create(Request $request): ?string
        {
            if (!Auth::check()) {
                return 'neesate prisijunges';
            }

            Account::create([
                'user_id' => Auth::user()->id,
                'balance' => env('ACCONT_BONUS_AMOUNT', 1000)
            ]);
        }

        public function myAccounts()
        {
            $accounts_info = Account::where('user_id', Auth::id())->get();
            $accounts_numbers = $accounts_info->pluck('account_no');
            return view('transfer', ['accounts' => $accounts_numbers]);
        }


        public function transferAction(Request $request)
        {
            $this->validate($request, [
                'recipientAccount' => 'required',
                'amount' => 'required'
            ]);

            $my_account = Account::where(['user_id' => Auth::id(), 'account_no' => $request->input('payer_account')])->first();
            if (!$my_account) {
                return redirect()->route('transfer')->withErrors(['Wrong payer account number']);
            }

            if ($my_account['balance'] < $request->input('amount')) {
                return redirect()->route('transfer')->withErrors(['Not sufficient balance']);
            }

            $user_id = Auth::id();
            $current_acount_increment = $request->input('recipientAccount');
            $current_acount_decrement = $request->input('payer_account');
            $amount = $request->input('amount');

            // change balance MY ACCOUNT
            Account::find($user_id)
                ->where('account_no', $current_acount_decrement)
                ->decrement('balance',$request->input('amount'));

            // change balance RECIPIENT's ACCOUNT
            Account::where('account_no', $current_acount_increment)
                ->increment('balance',$request->input('amount'));

            //            Transfer Model instance. Saves transfers data
            $transfer = new Transfer([
                'user_id' => Auth::user()->id,
                'payer_account_no' => $current_acount_decrement,
                'recipient_account_no' => $current_acount_increment,
                'amount' => $amount
            ]);
            $transfer->save();

            return redirect('/dashboard');
        }

    }


