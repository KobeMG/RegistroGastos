<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * ApiBaseController para endpoints de API
 * No carga datos de sesión ni categorías como BaseController
 */
abstract class ApiBaseController extends Controller
{
    protected $session;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        helper(['form', 'url']);
        parent::initController($request, $response, $logger);
        $this->session = service('session');
    }
}
