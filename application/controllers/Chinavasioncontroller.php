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

		$this->load->view('common/header', $data);
		$this->load->view('common/topmenu');
		$this->load->view('common/startpage');
		$this->load->view('common/footer');
	}

	public function errorpage()
	{
		
		$data['metadescription'] = $data['metatitle'] = "Error Page";

		$this->load->view('common/header', $data);
		$this->load->view('common/topmenu');
		$this->load->view('common/404');
		$this->load->view('common/footer');
	}

	public function faq()
	{
		$data['metatitle'] = "FAQ";
		$data['metadescription'] = "How to use this parcer";

		$this->load->view('common/header', $data);
		$this->load->view('common/topmenu');
		$this->load->view('common/faq');
		$this->load->view('common/footer');
	}

/******************************************************************************************************************/
/******************************************************************************************************************/
/******************************************************************************************************************/
	
	public function parcecategories()
	{
		$data['metadescription'] = $data['metatitle'] = "Get chinavasion's categories";

		$data['resultparce'] = $this->Chinavasionmodel->parceCategories();
		if($data['resultparce'] === TRUE)
		{
			$data['resultlist'] = $this->Chinavasionmodel->listCategories();
		}
		
		$this->load->view('common/header', $data);
		$this->load->view('common/topmenu');
		$this->load->view('categories', $data);
		$this->load->view('common/footer');
	}

	public function listcategories()
	{
		$data['metadescription'] = $data['metatitle'] = "List chinavasion's categories";

		if($data['resultparce'] = TRUE)
		{
			$data['resultlist'] = $this->Chinavasionmodel->listCategories();
		}
		
		$this->load->view('common/header', $data);
		$this->load->view('common/topmenu');
		$this->load->view('categories', $data);
		$this->load->view('common/footer');
	}

	public function parcecategoryproducts()
	{
		$catid = $this->input->post('catid');
		$data['result'] = $this->Chinavasionmodel->parceCategoryProducts($catid, $start = 0, $dataArray = array());
		$data['result'] = count($data['result']);
		$this->load->view('common/ajaxsimpleresult',$data);
	}

/******************************************************************************************************************/
/******************************************************************************************************************/
/******************************************************************************************************************/

	public function parcenewproducts()
	{
 		$data['metadescription'] = $data['metatitle'] = "New Products parce";
		$data['newproductsurl'] = "http://rss.chinavasion.com/new_products.xml";
		$data['result'] = $this->Chinavasionmodel->parceNewProductsXml($data['newproductsurl']);

		$this->load->view('common/header', $data);
		$this->load->view('common/topmenu');
		$this->load->view('newproduct_parce', $data);
		$this->load->view('common/footer');	
	}
	
	public function getnewproducts()
	{
 		$data['metadescription'] = $data['metatitle'] = "New Products result page";
		$data['result'] = $this->Chinavasionmodel->getNewProducts();

		$this->load->view('common/header', $data);
		$this->load->view('common/topmenu');
		$this->load->view('newproduct_result', $data);
		$this->load->view('common/footer');	
	}

/******************************************************************************************************************/
/******************************************************************************************************************/
/******************************************************************************************************************/

	public function productdetails($sku)
	{
		$data['metadescription'] = $data['metatitle'] = $sku.' product details';
		$data['result'] = $this->Chinavasionmodel->getProductDetails($sku);

		$this->load->view('common/header', $data);
		$this->load->view('common/topmenu');
		$this->load->view('product_details', $data);
		$this->load->view('common/footer');
	}
	
/************************************************************************************************************/
	// public function importcsv()
	// {
 // 		$data['metadescription'] = $data['metatitle'] = "Import Our Products";
	// 	$data['result'] = $this->Chinavasionmodel->setOurProducts();

	// 	if(isset($_POST['submit']))
	// 	{
	// 		$data['result'] = $this->Chinavasionmodel->importCsv($this->input->post('filecsv'));

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
 // 		$data['result'] = $this->Chinavasionmodel->downloadXml();

	// 	$this->load->view('header', $data);
	// 	$this->load->view('topmenu');
	// 	$this->load->view('downloadxml', $data);
	// 	$this->load->view('footer');	
	// }

	// public function parsexml()
	// {
 // 		$data['result'] = $this->Chinavasionmodel->parseXml();

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
	// 		$data['result'] = $this->Chinavasionmodel->parseResultsGetDateList();
	// 		$data['type'] = 'onlydates';

	// 		$this->load->view('header', $data);
	// 		$this->load->view('topmenu');
	// 		$this->load->view('resultsxml', $data);
	// 		$this->load->view('footer');	
	// 	}
	// 	else
	// 	{
	// 		$data['result'] = $this->Chinavasionmodel->parseResultsLincs($date);
	// 		$data['type'] = 'onlylinks';

	// 		$this->load->view('header', $data);
	// 		$this->load->view('topmenu');
	// 		$this->load->view('resultsxml', $data);
	// 		$this->load->view('footer');	
	// 	}
	// }

	// public function deletexmls()
	// {
 //        $this->Chinavasionmodel->deleteXmls();
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
			$data['result'] = $this->Chinavasionmodel->parseImages($this->input->post('produckulr'));

			$this->load->view('common/header', $data);
			$this->load->view('common/topmenu');
			$this->load->view('gallery_result', $data);
			$this->load->view('common/footer');
		}
		else
		{
			$this->load->view('common/header', $data);
			$this->load->view('common/topmenu');
			$this->load->view('gallery_addlink');
			$this->load->view('common/footer');				
		}
	}

/******************************************************************************************************************/
}
?>