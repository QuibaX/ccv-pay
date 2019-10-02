<?php

namespace QuibaX\CCVPay\Objects;

class Transaction {

    /**
     * @param $obj
     * @return Transaction
     */
    public static function getByObject($obj) {
        $transaction = new self();

        foreach($obj as $key => $value) {
            if(property_exists($transaction, $key)) {
                $transaction->$key = $value;
            }
        }

        return $transaction;
    }

    public $method;
    public $reference;
    public $currency;
    public $methodTransactionId;
    public $paidout;
    public $created;
    public $status;
    public $details;
    public $brand;
    public $amount;
    public $language;
    public $lastUpdate;
    public $payUrl;
    public $entryMode;
    public $returnUrl;
    public $cancelUrl;
    public $type;
    public $merchantOrderReference;

    public function isPaid() {
        return $this->status === 'success';
    }

    public function isFailed() {
        return $this->status === 'failed';
    }

    public function isPending() {
        return $this->status === 'pending';
    }
}
