<?php
// Proteje o arquivo do acesso direto
defined('BASEPATH') OR exit('No direct script access allowed');

class Restrict extends CI_Controller
{

	public function index()
	{
		$this->template->show("restrict");

	}
}
