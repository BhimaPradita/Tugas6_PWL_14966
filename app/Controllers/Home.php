<?php

namespace App\Controllers;

use App\Models\ProductModel; 

class Home extends BaseController
{
    public function contact(): string
    {
        return view('v_contact');
    }

    protected $product;

    public function __construct()
    {
        helper("form");
        helper("number");
        $this->product = new ProductModel();
    }

    public function index()
    {
        $product = $this->product->findAll();

        $data['product'] = $product;

        return view('v_home', $data);
    }
}