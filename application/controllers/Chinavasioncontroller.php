<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chinavasioncontroller extends CI_Controller
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
		$data['metatitle'] = $data['metadescription'] = "Chinavasion Parce Site";

		$this->load->view('header', $data);
		$this->load->view('topmenu');
		$this->load->view('startpage');
		$this->load->view('footer');
	}

	public function errorpage()
	{
		
		$data['metadescription'] = $data['metatitle'] = "Error Page";

		$this->load->view('header', $data);
		$this->load->view('topmenu');
		$this->load->view('404');
		$this->load->view('footer');
	}

	public function faq()
	{
		$data['metatitle'] = "FAQ";
		$data['metadescription'] = "How to use this parcer";

		$this->load->view('header', $data);
		$this->load->view('topmenu');
		$this->load->view('faq');
		$this->load->view('footer');
	}

/******************************************************************************************************************/
/******************************************************************************************************************/
/******************************************************************************************************************/
	
	public function parcecategories()
	{
		$data['metadescription'] = $data['metatitle'] = "Get chinavasion's categories";

		$data['resultparce'] = $this->Functionmodel->parceCategories();
		if($data['resultparce'] === TRUE)
		{
			$data['resultlist'] = $this->Functionmodel->listCategories();
		}
		
		$this->load->view('header', $data);
		$this->load->view('topmenu');
		$this->load->view('categories', $data);
		$this->load->view('footer');
	}

	public function listcategories()
	{
		$data['metadescription'] = $data['metatitle'] = "List chinavasion's categories";

		if($data['resultparce'] = TRUE)
		{
			$data['resultlist'] = $this->Functionmodel->listCategories();
		}
		
		$this->load->view('header', $data);
		$this->load->view('topmenu');
		$this->load->view('categories', $data);
		$this->load->view('footer');
	}

	public function parcecategoryproducts()
	{
		$catid = $this->input->post('catid');
		$data['result'] = $this->Functionmodel->parceCategoryProducts($catid, $start = 0, $dataArray = array());
		$data['result'] = count($data['result']);
		$this->load->view('ajaxsimpleresult',$data);
	}

/******************************************************************************************************************/
/******************************************************************************************************************/
/******************************************************************************************************************/

	public function parcenewproducts()
	{
 		$data['metadescription'] = $data['metatitle'] = "New Products parce";
		$data['newproductsurl'] = "http://rss.chinavasion.com/new_products.xml";
		$data['result'] = $this->Functionmodel->parceNewProductsXml($data['newproductsurl']);

		$this->load->view('header', $data);
		$this->load->view('topmenu');
		$this->load->view('newproduct_parce', $data);
		$this->load->view('footer');	
	}
	
	public function getnewproducts()
	{
 		$data['metadescription'] = $data['metatitle'] = "New Products result page";
		$data['result'] = $this->Functionmodel->getNewProducts();

		$this->load->view('header', $data);
		$this->load->view('topmenu');
		$this->load->view('newproduct_result', $data);
		$this->load->view('footer');	
	}

/******************************************************************************************************************/
/******************************************************************************************************************/
/******************************************************************************************************************/

	public function productdetails($sku)
	{
		$data['metadescription'] = $data['metatitle'] = $sku.' product details';
		$data['result'] = $this->Functionmodel->getProductDetails($sku);

		$this->load->view('header', $data);
		$this->load->view('topmenu');
		$this->load->view('product_details', $data);
		$this->load->view('footer');
	}
	
/******************************************************************************************************************/
/******************************************************************************************************************/
/******************************************************************************************************************/

	public function uploadstock()
	{
		$data['metadescription'] = $data['metatitle'] = "Import Our Products Stock";
		
		if(isset($_POST['submit']))
		{
			$config['upload_path'] = './upload/';
			$config['allowed_types'] = 'csv';
			$config['file_name'] = 'ee_stock_update';
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
				$data['result'] = $this->Functionmodel->getStockDataFromCsv($success['upload_data']['full_path']);
			}

			$this->load->view('header', $data);
			$this->load->view('topmenu');
			$this->load->view('upload_stock', $data);
			$this->load->view('footer');
		}
		else
		{
			$this->load->view('header', $data);
			$this->load->view('topmenu');
			$this->load->view('upload_stock');
			$this->load->view('footer');				
		}
	}


	public function downloadstock()
	{
		$data['metadescription'] = $data['metatitle'] = "Download Products Stock Data";

		$data['file_name'] = $this->Functionmodel->setUpdateStockToCsv();

		$this->load->view('header', $data);
		$this->load->view('topmenu');
		$this->load->view('download_stock');
		$this->load->view('footer');
	}
/************************************************************************************************************/
	// public function importcsv()
	// {
 // 		$data['metadescription'] = $data['metatitle'] = "Import Our Products";
	// 	$data['result'] = $this->Functionmodel->setOurProducts();

	// 	if(isset($_POST['submit']))
	// 	{
	// 		$data['result'] = $this->Functionmodel->importCsv($this->input->post('filecsv'));

	// 		$this->load->view('header', $data);
	// 		$this->load->view('topmenu');
	// 		$this->load->view('ourproduct_result', $data);
	// 		$this->load->view('footer');
	// 	}
	// 	else
	// 	{
	// 		$this->load->view('header', $data);
	// 		$this->load->view('topmenu');
	// 		$this->load->view('ourproduct_form');
	// 		$this->load->view('footer');				
	// 	}	
	// }
/************************************************************************************************************/
/************************************************************************************************************/
/************************************************************************************************************/	
	// public function downloadxml()
	// {
 // 		$data['metatitle'] = "Error Page";
	// 	$data['metadescription'] = "Error Page";
 // 		$data['result'] = $this->Functionmodel->downloadXml();

	// 	$this->load->view('header', $data);
	// 	$this->load->view('topmenu');
	// 	$this->load->view('downloadxml', $data);
	// 	$this->load->view('footer');	
	// }

	// public function parsexml()
	// {
 // 		$data['result'] = $this->Functionmodel->parseXml();

	// 	$this->load->view('header');
	// 	$this->load->view('topmenu');
	// 	$this->load->view('parsexml', $data);
	// 	$this->load->view('footer');	
	// }


	// public function results($date='')
	// {
	// 	$data['metatitle'] = "XXXXX";
	// 	$data['metadescription'] = "XXXXXXXXXx";

	// 	if (empty($date))
	// 	{
	// 		$data['result'] = $this->Functionmodel->parseResultsGetDateList();
	// 		$data['type'] = 'onlydates';

	// 		$this->load->view('header', $data);
	// 		$this->load->view('topmenu');
	// 		$this->load->view('resultsxml', $data);
	// 		$this->load->view('footer');	
	// 	}
	// 	else
	// 	{
	// 		$data['result'] = $this->Functionmodel->parseResultsLincs($date);
	// 		$data['type'] = 'onlylinks';

	// 		$this->load->view('header', $data);
	// 		$this->load->view('topmenu');
	// 		$this->load->view('resultsxml', $data);
	// 		$this->load->view('footer');	
	// 	}
	// }

	// public function deletexmls()
	// {
 //        $this->Functionmodel->deleteXmls();
 //        redirect('index', 'refresh');
	// }

/******************************************************************************************************************/
/******************************************************************************************************************/
/******************************************************************************************************************/

	public function parseimg()
	{
		$data['metatitle'] = "Parce additional images";
		$data['metadescription'] = "get gallery images";

		if(isset($_POST['submit']))
		{
			$data['result'] = $this->Functionmodel->parseImages($this->input->post('produckulr'));

			$this->load->view('header', $data);
			$this->load->view('topmenu');
			$this->load->view('gallery_result', $data);
			$this->load->view('footer');
		}
		else
		{
			$this->load->view('header', $data);
			$this->load->view('topmenu');
			$this->load->view('gallery_addlink');
			$this->load->view('footer');				
		}
	}

/******************************************************************************************************************/
/******************************************************************************************************************/
/******************************************************************************************************************/

}
?>