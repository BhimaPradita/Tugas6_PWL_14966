<?php

namespace App\Controllers;

use App\Models\ProductModel;
use Config\Services;

class Home extends BaseController
{
    protected $product;

    public function __construct()
    {
        helper(['form', 'number']);
        $this->product = new ProductModel();
    }

    public function index()
    {
        $product = $this->product->findAll();

        // Cek diskon dari session
        $diskon = session()->get('diskon_hari_ini') ?? 0;

        // Hitung harga setelah diskon
        foreach ($product as &$item) {
            $item['harga_awal'] = $item['harga'];
            $item['harga_diskon'] = max(0, $item['harga'] - $diskon);
        }

        return view('v_home', [
            'product' => $product,
            'diskon' => $diskon
        ]);
    }

    public function beli()
    {
        $request = service('request');
        $session = session();

        $id = $request->getPost('id');
        $nama = $request->getPost('nama');
        $harga = (int)$request->getPost('harga');
        $foto = $request->getPost('foto');
        $harga_awal = (int)$request->getPost('harga_awal');

        $cart = $session->get('cart') ?? [];

        // Tambahkan item ke cart
        $cart[] = [
            'id' => $id,
            'nama' => $nama,
            'qty' => 1,
            'harga' => $harga,
            'harga_awal' => $harga_awal,
            'foto' => $foto,
        ];

        $session->set('cart', $cart);
        return redirect()->to('/keranjang')->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }
}
