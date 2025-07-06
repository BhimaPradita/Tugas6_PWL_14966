<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class ProfileController extends BaseController
{
    protected $transaction;
    protected $transactionDetail;

    public function __construct()
    {
        $this->transaction = new TransactionModel();
        $this->transactionDetail = new TransactionDetailModel();
    }

    public function index()
    {
        $username = session()->get('username');

        $buy = $this->transaction->where('username', $username)->findAll();

        $product = [];
        foreach ($buy as $b) {
            $product[$b['id']] = $this->transactionDetail
                ->select('transaction_detail.*, product.nama, product.foto, product.harga')
                ->join('product', 'product.id = transaction_detail.product_id')
                ->where('transaction_id', $b['id'])
                ->findAll();
        }

        return view('v_profile', [
            'username' => $username,
            'buy' => $buy,
            'product' => $product
        ]);
    }
}
