<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LoginoutController extends CI_Controller {

	function logout()
	{
		$this->session->unset_userdata('zaloginen');
		redirect(base_url().'login', 'refresh');
	}

	function index()
	{
		if(isset($_POST['submitlogin']))
		{
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');

			$this->form_validation->set_rules('mailLogin', 'Логин', 'trim|required|valid_email');
			$this->form_validation->set_rules('pwdLogin', 'Пароль', 'trim|required|callback_check_database|min_length[5]');
			if($this->form_validation->run() == FALSE)
			{
				$data['metatitle'] = $data['metadescription'] = "Chinavasion Parce Site";

				$this->load->view('common/header', $data);
				$this->load->view('common/login_form', $data);
				$this->load->view('common/footer');
			}
			else
			{
				redirect(base_url(), 'refresh');
			}
		}
		else
		{
			$data['metatitle'] = $data['metadescription'] = "Chinavasion Parce Site";

			$this->load->view('common/header', $data);
			$this->load->view('common/login_form', $data);
			$this->load->view('common/footer');
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
			$this->form_validation->set_message('check_database', 'wrong <strong>EMAIL</strong> / <strong>PASSWORD</strong> !!!');
			return false;
		}
	}
}