<?php

namespace App\Services;

use App\Services\Contracts\MoneyTransferDataInterface;

/**
 * Stores data for transfer
 * Class MoneyTransferDataService
 * @package App\Services
 */
class MoneyTransferDataService implements MoneyTransferDataInterface
{
    /** @var string  */
    private $payerAccount = null;
    /** @var string  */
    private $recipientAccount = null;
    /** @var int  */
    private $amount = null;

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function setDataArray(array $data): MoneyTransferDataInterface
    {
        if (empty($data['payerAccount']) ||
            empty($data['recipientAccount']) ||
            empty($data['amount']) ||
            ! is_numeric($data['amount']) ||
            $data <= 0
        ) {
            throw new \Exception('required data not defined');
        }
        $this->payerAccount = $data['payerAccount'];
        $this->recipientAccount = $data['recipientAccount'];
        $this->amount = (int) $data['amount'];

        return $this;
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function getPayerAccount(): string
    {
        if (empty($this->payerAccount)) {
            throw new \Exception('payer account not defined');
        }
        return $this->payerAccount;
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function getRecipientAccount(): string
    {
        if (empty($this->recipientAccount)) {
            throw new \Exception('recipient account not defined');
        }
        return $this->recipientAccount;
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function getAmount(): int
    {
        if (empty($this->amount)) {
            throw new \Exception('amount not defined');
        }
        return $this->amount;
    }
}
