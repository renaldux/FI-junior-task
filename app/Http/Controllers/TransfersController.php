<?php

namespace App\Http\Controllers;

use App\Services\Contracts\MoneyTransferDataInterface;
use App\Services\Contracts\MoneyTransferInterface;
use App\Services\MoneyTransferService;
use Illuminate\Http\Request;
use App\Transfer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TransfersController extends Controller
{

    /**
     * @var MoneyTransferService
     */
    private $moneyTransferService = null;
    /**
     * @var MoneyTransferDataInterface
     */
    private $moneyTransferDataService = null;

    /**
     * TransfersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTransfers(){
        $transfers = Transfer::where('user_id', Auth::id())->orderBy('created_at', 'DESC')->get();
        return view('mytransfers')->with('transfers',$transfers);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function submitTransfer(Request $request)
    {
        $this->validate($request, [
            'payerAccount' => 'required|min:6|max:22',
            'recipientAccount' => 'required',
            'amount' => 'required|numeric|min:1'
        ]);

        try {
            $transferData = resolve(MoneyTransferDataInterface::class)->setDataArray($request->all());
            resolve(MoneyTransferInterface::class)->transferMoney($transferData);
        } catch (\Exception $e) {
            Log::error($e->getTraceAsString());
            return redirect()->route('dashboard')->withErrors([$e->getMessage()]);
        }

        return redirect()->route('myTransfers');
    }
}
