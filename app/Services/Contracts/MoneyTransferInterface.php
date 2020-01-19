<?php


namespace App\Services\Contracts;


interface MoneyTransferInterface
{
    /**
     * @param MoneyTransferDataInterface $data
     * @return bool
     * @throws \Exception
     */
    public function transferMoney(MoneyTransferDataInterface $data):bool ;
}
