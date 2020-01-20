<?php

namespace App\Http\Controllers;

use App\Http\Requests\MoneyTransferRequest;
use App\Services\Contracts\MoneyTransferDataInterface;
use App\Services\Contracts\MoneyTransferInterface;
use App\Services\MoneyTransferService;
use Illuminate\Http\RedirectResponse;
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
     * @param MoneyTransferRequest $request
     * @return RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function submitTransfer(MoneyTransferRequest $request)
    {
        try {
            $data = $request->validated() + ['payerId' => Auth::id()];
            $transferData = resolve(MoneyTransferDataInterface::class)->setDataArray($data);
            resolve(MoneyTransferInterface::class)->transferMoney($transferData);
        } catch (\Exception $e) {
            Log::error($e->getTraceAsString());
            return redirect()->route('transfer')->withErrors([$e->getMessage()])->withInput();
        }

        return redirect()->route('myTransfers');
    }
}
