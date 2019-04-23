<?php
// Proteje o arquivo do acesso direto
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{

	public function index()
	{
		$this->template->show('home');
	}
}
