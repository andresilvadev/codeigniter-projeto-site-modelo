<?php
// Proteje o arquivo do acesso direto
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{

	public function index()
	{

		$this->load->model("courses_model");
		$courses = $this->courses_model->show_courses();
		// Para cada curso da lista se não houver imagem então adiciona um no-image.jpg
		for ($i=0; $i < sizeof($courses); $i++) { 
			$img = $courses[$i]['course_img'];
			if(empty($img)) {				
				$courses[$i]['course_img'] = '/public/images/no-image.jpg';
				// echo "com imagem " . $courses[$i]['course_img'];
			}
		}
		

		$this->load->model("team_model");
		$team = $this->team_model->show_team();
		// Para cada curso da lista se não houver imagem então adiciona um no-image.jpg
		for ($i=0; $i < sizeof($team); $i++) { 
			$img = $team[$i]['member_photo'];
			if(empty($img)) {				
				$team[$i]['member_photo'] = '/public/images/no-image.jpg';
				// echo "com imagem " . $courses[$i]['course_img'];
			}
		}

		$data = array(
			"scripts" => array(
				"owl.carousel.min.js",
				"cbpAnimatedHeader.js",
				"theme-scripts.js",
			),
			"courses" => $courses,
			"team" => $team
		);
		$this->template->show("home", $data);
	}
}
