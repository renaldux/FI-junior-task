<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Account extends Model
{
    protected $table = 'accounts';

    public $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->account_no) {
                $model->account_no = $model->generateUniqueAccountNo();
            }
        });
    }

    /**
     * @throws \Exception
     */
    public function createNewAccount()
    {
        if (!Auth::check()) {
            return;
        }
        $this->setAttribute('user_id', Auth::user()->id);
        $this->setAttribute('balance', $this->newAccountBalance());
        $this->setAttribute('account_no', $this->generateUniqueAccountNo());
        return $this->save();
    }

    /**-
     * @param int $len
     * @param int $attempts
     * @return string
     * @throws \Exception
     */
    private function generateUniqueAccountNo($len = 5, $attempts = 0): string
    {
        if ($attempts > 1000) {
            throw new \Exception('unable to generate unique account number');
        }
        $bankAccount = 'LT';
        while (strlen($bankAccount) <= $len) {
            $bankAccount .= rand(0, 9);
        }
        //check if unique
        if (self::where('account_no', $bankAccount)->first()) {
            return self::generateUniqueAccountNo($len, $attempts ++);
        }
        return $bankAccount;
    }

    /**
     * Checks if account exists and returns amount for account to be created
     * @return int
     */
    // First account  - bonus 1000 Eur
    private function newAccountBalance(): int
    {
        $accountAllreadyExists = self::where('user_id', Auth::id())->first();
        return $accountAllreadyExists ? 0 : (int) env('ACCONT_BONUS_AMOUNT', 100);
    }
}
