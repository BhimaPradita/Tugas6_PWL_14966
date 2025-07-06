<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\DiskonModel;

abstract class BaseController extends Controller
{
    protected $request;

    protected $helpers = [];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // ✅ Ambil diskon hari ini dari database jika belum diset
        if (!session()->has('diskon_hari_ini')) {
            $diskonModel = new DiskonModel();
            $hariIni = date('Y-m-d');

            $diskon = $diskonModel->where('tanggal', $hariIni)->first();
            if ($diskon) {
                session()->set('diskon_hari_ini', $diskon['nominal']);
            }
        }
    }
}
