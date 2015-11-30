<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Opencartcontroller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		
		if($this->session->userdata('zaloginen')){}
		else
		{
			redirect(base_url().'login', 'refresh');
		}
	}

	public function index()
	{
		redirect(base_url(), 'refresh');
	}
/******************************************************************************************************************/
/******************************************* S T O C K ************************************************************/
/******************************************************************************************************************/
	
	public function uploadstock()
	{
		$data['metadescription'] = $data['metatitle'] = "Import Products Stock";
		
		if(isset($_POST['submit']))
		{
			$config['upload_path'] = './upload/opencart/';
			$config['allowed_types'] = 'csv';
			$config['file_name'] = 'ee_stock_import';
			$config['overwrite'] = TRUE;
			$config['max_size']	= '1000';
	
			$this->load->library('upload', $config);
			
			if(!$this->upload->do_upload())
			{
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('error', $error);
				$data['result'] = '';
				$data['filename'] = '';
			}
			else
			{
				$success = array('upload_data' => $this->upload->data());
				$this->session->set_flashdata('success', $success);
				$data['filename'] = $success['upload_data']['file_name'];
				$data['result'] = $this->Opencartmodel->getStockDataFromCsv($success['upload_data']['full_path']);
			}

			$this->load->view('common/header', $data);
			$this->load->view('common/topmenu');
			$this->load->view('opencart/upload_stock', $data);
			$this->load->view('common/footer');
		}
		else
		{
			$this->load->view('common/header', $data);
			$this->load->view('common/topmenu');
			$this->load->view('opencart/upload_stock');
			$this->load->view('common/footer');				
		}
	}

	public function downloadstock()
	{
		$data['metadescription'] = $data['metatitle'] = "Download Products Stock Data";

		$data['file_name'] = $this->Opencartmodel->setUpdateStockToCsv();

		$this->load->view('common/header', $data);
		$this->load->view('common/topmenu');
		$this->load->view('opencart/download_stock');
		$this->load->view('common/footer');
	}

	public function checkprices()
	{
		$data['metadescription'] = $data['metatitle'] = "Check New Prices";

		$data['result'] = $this->Opencartmodel->getNewPrices();

		$this->load->view('common/header', $data);
		$this->load->view('common/topmenu');
		$this->load->view('opencart/new_prices');
		$this->load->view('common/footer');
	}
/******************************************************************************************************************/
/******************************************************************************************************************/
/******************************************************************************************************************/
	


/******************************************************************************************************************/
}
?>