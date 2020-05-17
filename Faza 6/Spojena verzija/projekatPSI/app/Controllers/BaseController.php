<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;

class BaseController extends Controller {

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['form', 'url', 'html'];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		//$this->session = \Config\Services::session();
                
                $this->session = session();
	}

        protected function prikaz($page, $data) {            
            $data['controller']='BaseController';
            $korisnik = $this->session->get('korisnik');
  
            //prikaz headera
            if (null != $korisnik) {
                if ($korisnik->isAdmin) {
                  echo view('sablon/header_admin');
                } else {
                  echo view('sablon/header_korisnik');  
                }
            } else {
                  echo view('sablon/header_gost');
            }
            
            //prikaz sadrzaja stranice
            echo view("$page", $data);
            
            //prikaz footera
            echo view('sablon/footer');
        }
}
