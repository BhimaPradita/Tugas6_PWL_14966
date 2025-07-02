<?php

namespace App\Controllers;

class TransaksiController extends BaseController
{
    protected $cart;
    protected $client;
    protected $apiKey;

    function __construct()
    {
        helper('number');
        helper('form');
        $this->cart = \Config\Services::cart();
        $this->client = new \GuzzleHttp\Client();
        $this->apiKey = getenv('COST_KEY');

        if (!$this->apiKey) {
            throw new \Exception("API KEY Raja Ongkir tidak ditemukan di .env (COST_KEY)");
        }

    }

    public function index()
    {
        $data['items'] = $this->cart->contents();
        $data['total'] = $this->cart->total();
        return view('v_keranjang', $data);
    }

    public function cekKey()
    {
        return $this->response->setJSON([
            'apiKey' => $this->apiKey
        ]);
    }

    public function cart_add()
    {
        $this->cart->insert(array(
            'id'        => $this->request->getPost('id'),
            'qty'       => 1,
            'price'     => $this->request->getPost('harga'),
            'name'      => $this->request->getPost('nama'),
            'options'   => array('foto' => $this->request->getPost('foto'))
        ));
        session()->setflashdata('success', 'Produk berhasil ditambahkan ke keranjang. (<a href="' . base_url() . 'keranjang">Lihat</a>)');
        return redirect()->to(base_url('/'));
    }

    public function cart_clear()
    {
        $this->cart->destroy();
        session()->setflashdata('success', 'Keranjang Berhasil Dikosongkan');
        return redirect()->to(base_url('keranjang'));
    }

    public function cart_edit()
    {
        $i = 1;
        foreach ($this->cart->contents() as $value) {
            $this->cart->update(array(
                'rowid' => $value['rowid'],
                'qty'   => $this->request->getPost('qty' . $i++)
            ));
        }

        session()->setflashdata('success', 'Keranjang Berhasil Diedit');
        return redirect()->to(base_url('keranjang'));
    }

    public function cart_delete($rowid)
    {
        $this->cart->remove($rowid);
        session()->setflashdata('success', 'Keranjang Berhasil Dihapus');
        return redirect()->to(base_url('keranjang'));
    }

    public function checkout()
    {
        $data['items'] = $this->cart->contents();
        $data['total'] = $this->cart->total();

        return view('v_checkout', $data);
    }

    public function getLocation()
    {
        try {
            // Ambil keyword dari URL
            $search = $this->request->getGet('search');

            // Lakukan request ke API Raja Ongkir
            $response = $this->client->request(
                'GET', 
                'https://rajaongkir.komerce.id/api/v1/destination/domestic-destination?search=' . $search . '&limit=50', 
                [
                    'headers' => [
                        'accept' => 'application/json',
                        'key' => $this->apiKey,
                    ],
                ]
            );

            // Decode responsenya
            $body = json_decode($response->getBody(), true);

            // Validasi hasil response
            if (isset($body['data']) && is_array($body['data'])) {
                return $this->response->setJSON($body['data']);
            } else {
                return $this->response->setStatusCode(500)->setJSON([
                    'error' => 'Response tidak sesuai atau tidak ada data.'
                ]);
            }
        } catch (\Throwable $e) {
            // Tangani jika terjadi error jaringan, parsing, dll
            return $this->response->setStatusCode(500)->setJSON([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function getCost()
    { 
            //ID lokasi yang dikirimkan dari halaman checkout
        $destination = $this->request->getGet('destination');

            //parameter daerah asal pengiriman, berat produk, dan kurir dibuat statis
        //valuenya => 64999 : PEDURUNGAN TENGAH , 1000 gram, dan JNE
        $response = $this->client->request(
            'POST', 
            'https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
                'multipart' => [
                    [
                        'name' => 'origin',
                        'contents' => '64999'
                    ],
                    [
                        'name' => 'destination',
                        'contents' => $destination
                    ],
                    [
                        'name' => 'weight',
                        'contents' => '1000'
                    ],
                    [
                        'name' => 'courier',
                        'contents' => 'jne'
                    ]
                ],
                'headers' => [
                    'accept' => 'application/json',
                    'key' => $this->apiKey,
                ],
            ]
        );

        $body = json_decode($response->getBody(), true); 
        return $this->response->setJSON($body['data']);
}
}
