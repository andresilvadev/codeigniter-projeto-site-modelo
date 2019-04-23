<?php
// Proteje o arquivo do acesso direto
defined('BASEPATH') OR exit('No direct script access allowed');

class Restrict extends CI_Controller
{

	/**
	 * Restrict constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
	}


	/**
	 * Se existir sessão direciona para area restrita
	 * senão para o formulário de login
	 */
	public function index()
	{
		if ($this->session->userdata("user_id")) {
			// Carregamento de scripts
			$data = array(
				"scripts" => array(
					"util.js",
					"restrict.js"
				)
			);
			$this->template->show("restrict", $data);

		} else {
			$data = array(
				"scripts" => array(
					"util.js",
					"login.js"
				)
			);
			$this->template->show("login", $data);
		}

	}

	/**
	 * Destroi a sessão do usuário
	 */
	public function logoff()
	{
		$this->session->sess_destroy();
		header("Location: " . base_url() . "restrict");
	}

	/**
	 * Realiza o login do usuário via ajax
	 */
	public function ajax_login()
	{
		// Segurança, impede de chamar esse método na url
		if(! $this->input->is_ajax_request())
		{
			exit("Nenhum acesso de script direto é permitido!");
		}

		$json = array();
		$json["status"] = 1;
		$json["error_list"] = array();

		$username = $this->input->post("username");
		$password = $this->input->post("password");

		if (empty($username)) {
			$json["status"] = 0;
			$json["error_list"]["#username"] = "Usuário não pode ser vazio!";
		} else {
			$this->load->model('users_model');
			$result = $this->users_model->get_user_data($username);

			if($result) {
				$user_id = $result->id;
				$user_password = $result->password;

				if(password_verify($password, $user_password)) {
					$this->session->set_userdata("user_id", $user_id);
				} else {
					$json["status"] = 0;
				}
			} else {
				$json["status"] = 0;
			}
			if ($json["status"] == 0) {
				$json["error_list"]["#btn_login"] = "Usuário  e/ou senha incorreta!";
			}
		}

		echo json_encode($json);

	}

	public function ajax_import_image()
	{
		if(! $this->input->is_ajax_request()) // Segurança, impede de chamar esse método na url
		{
			exit("Nenhum acesso de script direto é permitido!");
		}

		$config["upload_path"] = "public/upload";
		$config["allowed_types"] = "gif|png|jpg|jpeg";
		$config["overwrite"] = true;  // caso o arquivo já existe ele vai subescrever o arquivo

		$this->load->library('upload', $config);

		$json = array();
		$json["status"] = 1;

		if(!$this->upload->do_upload("image_file")) {
			$json["status"] = 0;
			$json["error"] = $this->upload->display_errors("","");
		} else {
			if ($this->upload->data()["file_size"] <= 1024) {
				$file_name =  $this->upload->data()["file_name"];
				$json["img_path"] = base_url() . "public/upload/" . $file_name;
			} else {
				$json["status"] = 0;
				$json["error"] = "Arquivo não deve ser maior que 1 MB";
			}
		}

		echo json_encode($json);
	}

	public function ajax_save_course()
	{
		if(! $this->input->is_ajax_request()) // Segurança, impede de chamar esse método na url
		{
			exit("Nenhum acesso de script direto é permitido!");
		}

		$json = array();
		$json["status"] = 1;
		$json["error_list"] = array();

		$this->load->model("courses_model");

		$data = $this->input->post();

		if (empty($data["course_name"])) {
			$json["error_list"]["#course_name"] = "Nome do curso é obrigatório!";
		} else {
			if ($this->courses_model->is_duplicated("course_name", $data["course_name"], $data["course_id"])) {
				$json["error_list"]["#course_name"] = "Nome do curso já existente!";
			}
		}

		$data["course_duration"] = floatval($data["course_duration"]); // Transforme em fload a string que vem do formulário

		if (empty($data["course_duration"])) {
			$json["error_list"]["#course_duration"] = "Duração do curso é obrigatório!";
		} else {
			if (!($data["course_duration"] > 0 && $data["course_duration"] < 100)) {
				$json["error_list"]["#course_duration"] = "O curso deve ser maior que 0 (h) e menor que 100 (h)";
			}
		}

		if (!empty($json["error_list"])) {
			$json["status"] = 0;
		} else {

			if (!empty($data["course_img"])){

				$file_name = basename($data["course_img"]);
				$old_path = getcwd() . "/public/upload/" . $file_name ;
				$new_path = getcwd() . "/public/images/courses/" . $file_name;
				rename($old_path, $new_path);

				$data["course_img"] = "/public/images/courses/" . $file_name;
			}

			if(empty($data["course_id"])) {
				$this->courses_model->insert($data);
			} else {
				$course_id = $data["course_id"];

				unset($data["course_id"]); // Remove o course_id do array

				$this->courses_model->update($data);
			}
		}

		echo json_encode($json);

	}


	/**
	 * Cria um hash de uma senha
	 * @param $password
	 */
	public function criaHashPassword($password)
	{
		$password = "secret";
		echo password_hash($password, PASSWORD_DEFAULT); // $2y$10$gs.qemVIg7bFjYIG72xt5efbXyRf1XQBFFRZo4ecUxYNV.lsky7Eu
	}

	/**
	 * Consulta um usuário no sistema
	 * @param $login
	 */
	public function consultaUsuarioNoBanco($login)
	{
		$login = "andre";
		$this->load->model('users_model');
		$user = $this->users_model->get_user_data($login);
		print_r($user);
	}

}
