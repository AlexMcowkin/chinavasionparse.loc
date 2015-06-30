<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LoginoutController extends CI_Controller {

	function logout()
	{
		$this->session->unset_userdata('zaloginen');
		redirect(base_url().'loginout', 'refresh');
	}
	function index()
	{
		if(isset($_POST['submitlogin']))
		{
			$this->form_validation->set_rules('mailLogin', 'Логин', 'trim|required|valid_email');
			$this->form_validation->set_rules('pwdLogin', 'Пароль', 'trim|required|callback_check_database|min_length[5]');
			if($this->form_validation->run() == FALSE)
			{
				$data['site_title'] = 'Login';
				$this->load->view('header');
				$this->load->view('topmenu');
				$this->load->view('login_form', $data);
				$this->load->view('footer');
			}
			else
			{
				redirect(base_url().'adminka', 'refresh');
			}
		}
		else
		{
			$data['site_title'] = 'Login';
			$this->load->view('header');
			$this->load->view('topmenu');
			$this->load->view('login_form', $data);
			$this->load->view('footer');
		}
	}
	function check_database($password)
	{
		$email = $this->input->post('mailLogin');
		$result = $this->Loginoutmodel->checkuser($email, $password);
		if($result)
		{
			$this->session->set_userdata('zaloginen', 'yes');
			return true;
		}
		else
		{
			$this->form_validation->set_message('check_database', 'Инвалидные данные: <strong>МЫЛО</strong> / <strong>ПАРОЛЬ</strong> не есть верные!!!');
			return false;
		}
	}
}