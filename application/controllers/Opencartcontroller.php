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

		$data['downloadcsv'] = $this->Opencartmodel->getCsvNewPrices();

		$this->load->view('common/header', $data);
		$this->load->view('common/topmenu');
		$this->load->view('opencart/new_prices');
		$this->load->view('common/footer');
	}

	public function checknew()
	{
		$data['metadescription'] = $data['metatitle'] = "Check New Products";

		$data['result'] = $this->Opencartmodel->getNewProducts();
	
		if(is_array($data['result']))
		{
			$newArray = '';
			foreach ($data['result'] as $value)
			{
				$newArray .= $value[2].",";
			}
			
			$newArray = trim($newArray, ",");
			$folder = 'new/';

			$this->Opencartmodel->csvProdSeoUrlAlias($new='yes',$newArray,$folder);
			$this->Opencartmodel->csvProdStore($new='yes',$newArray,$folder);
			$this->Opencartmodel->csvProdLayout($new='yes',$newArray,$folder);
			$this->Opencartmodel->csvProdTexts($new='yes',$newArray,$folder);
			$this->Opencartmodel->csvProdCommonData($new='yes',$newArray,$folder);
			$this->Opencartmodel->csvProdImgs($new='yes',$newArray,$folder);
			$this->Opencartmodel->csvProdCat($new='yes',$newArray,$folder);	
		}
		

		$this->load->view('common/header', $data);
		$this->load->view('common/topmenu');
		$this->load->view('opencart/new_products');
		$this->load->view('common/footer');
	}
	
/******************************************************************************************************************/
/************************************ IMPORT: NEW CATEGORIES ******************************************************/
/******************************************************************************************************************/
	public function csvcatseo()
	{
		$data['metadescription'] = $data['metatitle'] = "Get Catgegories Seo Url Aliases";

		$data['result'] = $this->Opencartmodel->csvCatSeoUrlAlias();

		$this->load->view('common/header', $data);
		$this->load->view('common/topmenu');
		$this->load->view('opencart/csv_category');
		$this->load->view('common/footer');
	}

	public function csvcatstore()
	{
		$data['metadescription'] = $data['metatitle'] = "Get Catgegories To Store";

		$data['result'] = $this->Opencartmodel->csvCatStore();

		$this->load->view('common/header', $data);
		$this->load->view('common/topmenu');
		$this->load->view('opencart/csv_category');
		$this->load->view('common/footer');
	}

	public function csvcatlayout()
	{
		$data['metadescription'] = $data['metatitle'] = "Get Catgegories To Layout";

		$data['result'] = $this->Opencartmodel->csvCatLayout();

		$this->load->view('common/header', $data);
		$this->load->view('common/topmenu');
		$this->load->view('opencart/csv_category');
		$this->load->view('common/footer');
	}

	public function csvcattext()
	{
		$data['metadescription'] = $data['metatitle'] = "Get Catgegories Texts";

		$data['result'] = $this->Opencartmodel->csvCatTexts();

		$this->load->view('common/header', $data);
		$this->load->view('common/topmenu');
		$this->load->view('opencart/csv_category');
		$this->load->view('common/footer');
	}

	public function csvcatcommon()
	{
		$data['metadescription'] = $data['metatitle'] = "Get Catgegories Common Data";

		$data['result'] = $this->Opencartmodel->csvCatCommonData();

		$this->load->view('common/header', $data);
		$this->load->view('common/topmenu');
		$this->load->view('opencart/csv_category');
		$this->load->view('common/footer');
	}

	public function csvcatpath()
	{
		$data['metadescription'] = $data['metatitle'] = "Get Catgegories Hierarchy";

		$data['result'] = $this->Opencartmodel->csvCatHierarchy();

		$this->load->view('common/header', $data);
		$this->load->view('common/topmenu');
		$this->load->view('opencart/csv_category');
		$this->load->view('common/footer');
	}

/******************************************************************************************************************/
/************************************ IMPORT: NEW PRODUCTS ********************************************************/
/******************************************************************************************************************/
	
	public function csvprodseo()
	{
		$data['metadescription'] = $data['metatitle'] = "Get Products Seo Url Aliases";

		$data['result'] = $this->Opencartmodel->csvProdSeoUrlAlias();

		$this->load->view('common/header', $data);
		$this->load->view('common/topmenu');
		$this->load->view('opencart/cv_product');
		$this->load->view('common/footer');
	}

	public function csvprodstore()
	{
		$data['metadescription'] = $data['metatitle'] = "Get Products To Store";

		$data['result'] = $this->Opencartmodel->csvProdStore();

		$this->load->view('common/header', $data);
		$this->load->view('common/topmenu');
		$this->load->view('opencart/cv_product');
		$this->load->view('common/footer');
	}

	public function csvprodlayout()
	{
		$data['metadescription'] = $data['metatitle'] = "Get Products To Layout";

		$data['result'] = $this->Opencartmodel->csvProdLayout();

		$this->load->view('common/header', $data);
		$this->load->view('common/topmenu');
		$this->load->view('opencart/cv_product');
		$this->load->view('common/footer');
	}

	public function csvprodtext()
	{
		$data['metadescription'] = $data['metatitle'] = "Get Products Texts";

		$data['result'] = $this->Opencartmodel->csvProdTexts();

		$this->load->view('common/header', $data);
		$this->load->view('common/topmenu');
		$this->load->view('opencart/cv_product');
		$this->load->view('common/footer');
	}

	public function csvprodcommon()
	{
		$data['metadescription'] = $data['metatitle'] = "Get Products Common Data";

		$data['result'] = $this->Opencartmodel->csvProdCommonData();

		$this->load->view('common/header', $data);
		$this->load->view('common/topmenu');
		$this->load->view('opencart/cv_product');
		$this->load->view('common/footer');
	}

	public function csvprodimg()
	{
		$data['metadescription'] = $data['metatitle'] = "Get Products Images";

		$data['result'] = $this->Opencartmodel->csvProdImgs();

		$this->load->view('common/header', $data);
		$this->load->view('common/topmenu');
		$this->load->view('opencart/cv_product');
		$this->load->view('common/footer');
	}

	public function csvprodcat()
	{
		$data['metadescription'] = $data['metatitle'] = "Get Products Categories";

		$data['result'] = $this->Opencartmodel->csvProdCat();

		$this->load->view('common/header', $data);
		$this->load->view('common/topmenu');
		$this->load->view('opencart/cv_product');
		$this->load->view('common/footer');
	}

/******************************************************************************************************************/
}
?>