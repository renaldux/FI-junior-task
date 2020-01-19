<?php


namespace App\Services\Contracts;


interface MoneyTransferDataInterface
{
    /**
     * @param array $data
     * @throws \Exception
     * @return MoneyTransferDataInterface
     */
    public function setDataArray(Array $data):MoneyTransferDataInterface ;


    /**
     * @throws \Exception
     * @return string
     */
    public function getPayerAccount(): string;

    /**
     * @throws \Exception
     * @return string
     */
    public function getRecipientAccount(): string;

    /**
     * @throws \Exception
     * @return int
     */
    public function getAmount(): int;
}
