<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chinavasioncontroller extends CI_Controller
{
	// function __construct()
	// {
	// 	parent::__construct();
	// 	if($this->session->userdata('zaloginen')){}
	// 	else
	// 	{
	// 		redirect('loginout', 'refresh');
	// 	}
	// }
	public function index()
	{
		$this->load->view('header');
		$this->load->view('topmenu');
		$this->load->view('content');
		$this->load->view('footer');
	}
	public function errorpage()
	{
		$this->load->view('header');
		$this->load->view('topmenu');
		$this->load->view('404');
		$this->load->view('footer');
	}
	
	public function downloadxml()
	{
 		$data['result'] = $this->Functionmodel->downloadXml();

		$this->load->view('header');
		$this->load->view('topmenu');
		$this->load->view('downloadxml', $data);
		$this->load->view('footer');	
	}

	public function parsexml()
	{
 		$data['result'] = $this->Functionmodel->parseXml();

		$this->load->view('header');
		$this->load->view('topmenu');
		$this->load->view('parsexml', $data);
		$this->load->view('footer');	
	}


	public function results($date='')
	{
		if (empty($date))
		{
			$data['result'] = $this->Functionmodel->parseResultsGetDateList();
			$data['type'] = 'onlydates';

			$this->load->view('header');
			$this->load->view('topmenu');
			$this->load->view('resultsxml', $data);
			$this->load->view('footer');	
		}
		else
		{
			$data['result'] = $this->Functionmodel->parseResultsLincs($date);
			$data['type'] = 'onlylinks';

			$this->load->view('header');
			$this->load->view('topmenu');
			$this->load->view('resultsxml', $data);
			$this->load->view('footer');	
		}
	}

	public function deletexmls()
	{
        $this->Functionmodel->deleteXmls();
        redirect('index', 'refresh');
	}

	public function parseimg()
	{
		if(isset($_POST['submit']))
		{
			$data['result'] = $this->Functionmodel->parseImages($this->input->post('produckulr'));

			$this->load->view('header');
			$this->load->view('topmenu');
			$this->load->view('parseimg', $data);
			$this->load->view('footer');
		}
		else
		{
			$this->load->view('header');
			$this->load->view('topmenu');
			$this->load->view('formimg');
			$this->load->view('footer');				
		}
		
	}

}
?>