<?php
// Proteje o arquivo do acesso direto
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{

	public function index()
	{
		$data = array(
			"scripts" => array(
				"owl.carousel.min.js",
				"cbpAnimatedHeader.js",
				"theme-scripts.js",
			)
		);
		$this->template->show("home", $data);
	}
}
