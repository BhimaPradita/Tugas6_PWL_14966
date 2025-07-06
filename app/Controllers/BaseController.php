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

        // Cek apakah ada diskon untuk hari ini di database
        $diskonModel = new \App\Models\DiskonModel();
        $hariIni = date('Y-m-d');
        $diskonHariIni = $diskonModel->where('tanggal', $hariIni)->first();

        if ($diskonHariIni) {
            session()->set('diskon_hari_ini', $diskonHariIni['nominal']);
        } else {
            session()->remove('diskon_hari_ini');
        }
    }
}
