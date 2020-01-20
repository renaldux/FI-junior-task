<?php


namespace App\Services;


use App\Account;
use App\Services\Contracts\MoneyTransferDataInterface;
use App\Services\Contracts\MoneyTransferInterface;
use App\Transfer;
use Illuminate\Support\Facades\DB;

class MoneyTransferService implements MoneyTransferInterface
{

    /**
     * @param MoneyTransferDataInterface $data
     * @return bool
     * @throws \Exception
     */
    public function transferMoney(MoneyTransferDataInterface $data):bool
    {
        DB::transaction(function () use ($data) {
            // change balance MY ACCOUNT
            Account::where('account_no', $data->getPayerAccount())
                ->decrement('balance', $data->getAmount());

            // change balance RECIPIENT's ACCOUNT
            Account::where('account_no', $data->getRecipientAccount())
                ->increment('balance', $data->getAmount());

            $transfer = new Transfer([
                'user_id' => $data->getPayerId(),
                'payer_account_no' => $data->getPayerAccount(),
                'recipient_account_no' => $data->getRecipientAccount(),
                'amount' => $data->getAmount()
            ]);
            $transfer->save();
        });
        return true;
    }


    /**
     * @param Account $payerAccount
     * @param MoneyTransferDataInterface $data
     * @throws \Exception
     */
    private function checkPayerAccount(Account $payerAccount, MoneyTransferDataInterface $data)
    {
        if (empty($payerAccount)) {
            throw new \Exception('Wrong payer account number');
        }

        if ($payerAccount->balance < $data->getAmount()) {
            throw new \Exception('Not sufficient balance');
        }
    }

    /**
     * @param MoneyTransferDataInterface $data
     * @return Account
     * @throws \Exception
     */
    private function getPayerAccount(MoneyTransferDataInterface $data): Account
    {
        return Account::where([
            'user_id' => $data->getPayerId(),
            'account_no' => $data->getPayerAccount()
        ])->first();
    }
}
