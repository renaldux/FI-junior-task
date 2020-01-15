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
     * @return bool|void
     * @throws \Exception
     */
    public function createNewAccount()
    {
        if (!Auth::check()) {
            throw new \Exception('trying to create account when not logged in');
        }
        $this->setAttribute('user_id', Auth::id());
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
     * @param null $user
     * @return int
     * @throws \Exception
     */
    // First account  - bonus 1000 Eur
    private function newAccountBalance($user = null): int
    {
        if (!Auth::check()) {
            throw new \Exception('checking newAccountBalance when not logged in');
        }
        $accountAllreadyExists = self::where('user_id', Auth::id())->first();
        return $accountAllreadyExists ? 0 : (int) env('ACCONT_BONUS_AMOUNT', 100);
    }
}
