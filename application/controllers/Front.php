<?php defined('BASEPATH') || exit('No direct script access allowed');

class Front extends Front_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('Auth');
	}

	function index()
	{
		$this->login();
	}

	function login()
	{
		if ($this->auth->is_logged_in()) {

			redirect($this->previous_page);
		}

		$this->data['view']       = 'login';
		$this->data['param']       = '';

		$this->form_validation->set_rules('npm', 'NPM', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');


		if ($this->form_validation->run() == TRUE) {
			$username = $this->input->post('npm');
			$password = $this->input->post('password');


			if ($this->auth->login($username, $password)) {
				// $this->session->set_userdata('userId', 'oke');
				redirect($this->requested_page);
			} else {
				$this->load->view('template/default', $this->data);
			}
		} else {
			if ($this->auth->is_logged_in()) {

				$this->data['view']       = 'home';
				$this->data['param']       = '';
				$this->load->view('template/default', $this->data);
			} else {

				$this->load->view('template/default', $this->data);
			}
		}
	}



	function logout()
	{
		$this->auth->logout();
		redirect('Home');
	}
}
