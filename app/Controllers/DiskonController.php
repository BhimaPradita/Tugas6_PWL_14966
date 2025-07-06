<?php

namespace App\Controllers;

use App\Models\DiskonModel;
use CodeIgniter\Controller;

class DiskonController extends BaseController
{
    public function index()
    {
        $model = new DiskonModel();
        $data['diskon'] = $model->findAll();
        return view('diskon/index', $data);
    }

    public function simpan()
    {
        $tanggal = $this->request->getPost('tanggal');
        $nominal = $this->request->getPost('nominal');

        $model = new \App\Models\DiskonModel();

        $cek = $model->where('tanggal', $tanggal)->first();

        if ($cek) {
            session()->setFlashdata('error', 'Tanggal segitu dah ada diskon coy, masa mau diskon 2 kali ಠ_ಠ');
        } else {
            $model->save([
                'tanggal' => $tanggal,
                'nominal' => $nominal,
            ]);

            if ($tanggal === date('Y-m-d')) {
                session()->set('diskon_hari_ini', $nominal);
            }
            session()->setFlashdata('success', 'Diskon berhasil ditambahkan.');
        }
        return redirect()->to('/diskon');
    }

    public function update($id)
    {
        $tanggal = $this->request->getPost('tanggal');
        $nominal = $this->request->getPost('nominal');

        $model = new DiskonModel();

        // Cek apakah tanggal yang dimasukkan sudah digunakan oleh record lain
        $cek = $model->where('tanggal', $tanggal)->where('id !=', $id)->first();
        if ($cek) {
            return redirect()->to('/diskon')->with('error', 'Diskon untuk tanggal tersebut sudah ada.');
        }

        $model->update($id, [
            'tanggal' => $tanggal,
            'nominal' => $nominal
        ]);

        if ($tanggal === date('Y-m-d')) {
            session()->set('diskon_hari_ini', $nominal);
        }

        return redirect()->to('/diskon')->with('success', 'Diskon berhasil diupdate.');
    }

    public function delete($id)
    {
        $model = new DiskonModel();
        $model->delete($id);

        // Hapus session jika yang dihapus adalah diskon hari ini
        $hariIni = date('Y-m-d');
        $cekHariIni = $model->where('tanggal', $hariIni)->first();
        if (!$cekHariIni) {
            session()->remove('diskon_hari_ini');
        }

        return redirect()->to('/diskon')->with('success', 'Diskon berhasil dihapus.');
    }
}
