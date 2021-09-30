<?php
 /**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the HRSALE License
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.hrsale.com/license.txt
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to hrsalesoft@gmail.com so we can send you a copy immediately.
 *
 * @author   HRSALE
 * @author-email  hrsalesoft@gmail.com
 * @copyright  Copyright © hrsale.com. All Rights Reserved
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Purchase extends MY_Controller
{

   /*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	public function __construct()
     {
          parent::__construct();
          //load the login model
          $this->load->model('Purchase_model');
		  $this->load->model('Xin_model');
		  $this->load->model("Products_model");
		  $this->load->model("Tax_model");
		  $this->load->model("Invoices_model");
		  $this->load->model('Quotes_model');
		  $this->load->model("Customers_model");
		  $this->load->model("Suppliers_model");
		  $this->load->model("Transactions_model");
		  $this->load->model("Warehouses_model");
     }
	 
	// quotes page
	public function index() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_acc_purchases').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_purchases');
		$data['all_taxes'] = $this->Tax_model->get_all_taxes();
		$data['path_url'] = 'hrsale_purchases';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('11',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/purchase/purchase_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	// create quote page
	public function create() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_acc_purchase').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_acc_purchase');
		$data['all_taxes'] = $this->Tax_model->get_all_taxes();
		$data['all_suppliers'] = $this->Suppliers_model->get_suppliers();
		$data['all_items'] = $this->Xin_model->get_items();
		$data['all_payment_methods'] = $this->Xin_model->get_payment_method();
		$data['path_url'] = 'create_hrsale_purchase';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('10',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/purchase/create_purchase", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	
	
	// get_quote_items
	 public function get_purchase_items() {

		$data['title'] = $this->Xin_model->site_title();
		
		$data = array(
			'all_items' => $this->Xin_model->get_items()
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/purchase/get_purchase_items", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	
	// edit quote page
	public function edit() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		
		$purchase_id = $this->uri->segment(4);
		$purchase_info = $this->Purchase_model->read_purchase_info($purchase_id);
		if(is_null($purchase_info)){
			redirect('admin/purchase');
		}
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(!in_array('11',$role_resources_ids)) { //edit
			redirect('admin/purchase');
		}
		// get project
		$supplier = $this->Suppliers_model->read_supplier_information($purchase_info[0]->supplier_id); 
		// get country
	//	$country = $this->Xin_model->read_country_info($supplier[0]->country_id);
		// get company info
		$company = $this->Xin_model->read_company_setting_info(1);
		// get company > country info
		$ccountry = $this->Xin_model->read_country_info($company[0]->country);
		$data = array(
			'title' => $this->lang->line('xin_acc_edit_purchase').' #'.$purchase_info[0]->purchase_id,
			'breadcrumbs' => $this->lang->line('xin_acc_edit_purchase'),
			'path_url' => 'create_hrsale_purchase',
			'purchase_id' => $purchase_info[0]->purchase_id,
			'prefix' => $purchase_info[0]->prefix,
			'purchase_number' => $purchase_info[0]->purchase_number,
			'supplier_id' => $purchase_info[0]->supplier_id,
			'purchase_date' => $purchase_info[0]->purchase_date,
			'sub_total_amount' => $purchase_info[0]->sub_total_amount,
			'discount_type' => $purchase_info[0]->discount_type,
			'discount_figure' => $purchase_info[0]->discount_figure,
			'total_tax' => $purchase_info[0]->total_tax,
			'total_discount' => $purchase_info[0]->total_discount,
			'grand_total' => $purchase_info[0]->grand_total,
			'purchase_note' => $purchase_info[0]->purchase_note,
			'all_items' => $this->Xin_model->get_items(),
			'all_taxes' => $this->Tax_model->get_all_taxes(),
			'all_suppliers' => $this->Suppliers_model->get_suppliers(),
		//	'all_taxes' => $this->Products_model->get_taxes()
			);
			$role_resources_ids = $this->Xin_model->user_role_resource();
		//if(in_array('3',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/purchase/edit_purchase", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load			
		//} else {
		//	redirect('admin/dashboard/');
		//}			  
     }
	 
	 public function mark_as(){
		
		$id = $this->uri->segment(4);
		$txt = $this->uri->segment(5);
		////
		$data = array(
			'status' => $txt,
		);
		$result = $this->Quotes_model->update_quote_record($data,$id);
		redirect('admin/quotes/view/'.$id);
	}
	
	// view Quote page
	public function view() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		
		$purchase_id = $this->uri->segment(4);
		$purchase_info = $this->Purchase_model->read_purchase_info($purchase_id);
		if(is_null($purchase_info)){
			redirect('admin/purchase');
		}
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(!in_array('11',$role_resources_ids)) { //edit
			redirect('admin/purchase');
		}
		// get project
		$supplier = $this->Suppliers_model->read_supplier_information($purchase_info[0]->supplier_id); 
		// get country
	//	$country = $this->Xin_model->read_country_info($supplier[0]->country_id);
		// get company info
		$company = $this->Xin_model->read_company_setting_info(1);
		// get company > country info
		$ccountry = $this->Xin_model->read_country_info($company[0]->country);
		
		$data = array(
			'title' => $this->lang->line('xin_acc_view_purchase').' #'.$purchase_info[0]->purchase_id,
			'breadcrumbs' => $this->lang->line('xin_acc_view_purchase'),
			'path_url' => 'create_hrsale_purchase',
			'purchase_id' => $purchase_info[0]->purchase_id,
			
			'supplier_id' => $supplier[0]->supplier_id,
			'purchase_date' => $purchase_info[0]->purchase_date,
			
			'purchase_note' => $purchase_info[0]->purchase_note,
			'status' => $purchase_info[0]->status,
			'company_name' => $company[0]->company_name,
			'company_address' => $company[0]->address_1,
			'company_zipcode' => $company[0]->zipcode,
			'company_city' => $company[0]->city,
			'company_phone' => $company[0]->phone,
			'company_email' => $company[0]->company_email,
			'company_country' => $ccountry[0]->country_name,
			'all_items' => $this->Xin_model->get_items(),
			'all_taxes' => $this->Tax_model->get_all_taxes(),
			'all_suppliers' => $this->Suppliers_model->get_suppliers(),
		//	'product_for_purchase_invoice' => $this->Products_model->product_for_purchase_invoice(),
		//	'all_taxes' => $this->Products_model->get_taxes()
			);
			$role_resources_ids = $this->Xin_model->user_role_resource();
			//if(in_array('3',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/purchase/purchase_view", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load			
		//} else {
		//	redirect('admin/dashboard/');
		//}		  
     }
	 
	 // view Quote page
	public function preview() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		
		$purchase_id = $this->uri->segment(4);
		$purchase_info = $this->Purchase_model->read_purchase_info($purchase_id);
		if(is_null($purchase_info)){
			redirect('admin/purchase');
		}
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(!in_array('11',$role_resources_ids)) { //edit
			redirect('admin/purchase');
		}
		// get project
		$supplier = $this->Suppliers_model->read_supplier_information($purchase_info[0]->supplier_id); 
		// get country
	//	$country = $this->Xin_model->read_country_info($supplier[0]->country_id);
		// get company info
		$company = $this->Xin_model->read_company_setting_info(1);
		// get company > country info
		$ccountry = $this->Xin_model->read_country_info($company[0]->country);
		
		$data = array(
			'title' => $this->lang->line('xin_acc_view_purchase').' #'.$purchase_info[0]->purchase_id,
			'breadcrumbs' => $this->lang->line('xin_acc_view_purchase'),
			'path_url' => 'create_hrsale_purchase',
			'purchase_id' => $purchase_info[0]->purchase_id,
			'prefix' => $purchase_info[0]->prefix,
			'purchase_number' => $purchase_info[0]->purchase_number,
			'supplier_id' => $supplier[0]->supplier_id,
			'purchase_date' => $purchase_info[0]->purchase_date,
			'sub_total_amount' => $purchase_info[0]->sub_total_amount,
			'discount_type' => $purchase_info[0]->discount_type,
			'discount_figure' => $purchase_info[0]->discount_figure,
			'total_tax' => $purchase_info[0]->total_tax,
			'total_discount' => $purchase_info[0]->total_discount,
			'grand_total' => $purchase_info[0]->grand_total,
			'purchase_note' => $purchase_info[0]->purchase_note,
			'status' => $purchase_info[0]->status,
			'company_name' => $company[0]->company_name,
			'company_address' => $company[0]->address_1,
			'company_zipcode' => $company[0]->zipcode,
			'company_city' => $company[0]->city,
			'company_phone' => $company[0]->phone,
			'company_email' => $company[0]->company_email,
			'company_country' => $ccountry[0]->country_name,
			'all_items' => $this->Xin_model->get_items(),
			'all_taxes' => $this->Tax_model->get_all_taxes(),
			'all_suppliers' => $this->Suppliers_model->get_suppliers(),
		//	'product_for_purchase_invoice' => $this->Products_model->product_for_purchase_invoice(),
		//	'all_taxes' => $this->Products_model->get_taxes()
			);
			$role_resources_ids = $this->Xin_model->user_role_resource();
			//if(in_array('3',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/purchase/preview_purchase", $data, TRUE);
			$this->load->view('admin/layout/pre_layout_main', $data); //page load			
		//} else {
		//	redirect('admin/dashboard/');
		//}		  
     }
	 	 
	public function purchase_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/purchase/purchase_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$purchase = $this->Purchase_model->get_list_items();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data = array();

          foreach($purchase->result() as $r) {
			  $products = $this->Products_model->read_product_information($r->item_id);
			  $warehouses = $this->Warehouses_model->read_warehouse_info($products[0]->warehouse_id);
			  $datapurchase = $this->Purchase_model->read_purchase_info($r->purchase_id);
			  // get grand_total
			 
			  // get customer
			  $supplier = $this->Suppliers_model->read_supplier_information($r->supplier_id); 
				if(!is_null($supplier)){
					$cname = $supplier[0]->supplier_name;
				} else {
					$cname = '--';	
				}
			  $purchase_date = '<i class="far fa-calendar-alt position-left"></i> '.$this->Xin_model->set_date_format($datapurchase[0]->purchase_date);
			  //invoice_number
			  $purchase_number = '';
			  
			  $edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><a href="'.site_url().'admin/purchase/edit/'.$r->purchase_id.'/"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"><span class="fa fa-pencil"></span></button></a></span>';
			$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->purchase_id . '"><span class="fa fa-trash"></span></button></span>';
			$view = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><a href="'.site_url().'admin/purchase/view/'.$r->purchase_id.'/"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light""><span class="fa fa-arrow-circle-right"></span></button></a></span>';
			$combhr = $edit.$view.$delete;
               $data[] = array(
               		$purchase_date,
                    $cname,
                    $r->item_name,
                    $warehouses[0]->warehouse_name,
                    $r->item_qty,
                    $products[0]->product_description,
                    $combhr,
               );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $purchase->num_rows(),
                 "recordsFiltered" => $purchase->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	
	// Validate and add info in database
	public function create_new_purchase() {
	
		if($this->input->post('add_type')=='purchase_create') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */	
		
		if($this->input->post('supplier_id')==='') {
       		$Return['error'] = $this->lang->line('xin_acc_supplier_field');
		} else if($this->input->post('purchase_date')==='') {
       		$Return['error'] = $this->lang->line('xin_transfers_error_date');
		}
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$j=0; foreach($this->input->post('item_name') as $items){
				$item_name = $this->input->post('item_name');
				$iname = $item_name[$j];
				// item qty
				$qty = $this->input->post('qty_hrs');
				$qtyhrs = $qty[$j];
				// item price
				
				if($iname==='') {
					$Return['error'] = $this->lang->line('xin_acc_itemp_field');
				} else if($qty==='') {
					$Return['error'] = $this->lang->line('xin_acc_qtyhrs_field');
				}
				$j++;
		}
		if($Return['error']!=''){
       		$this->output($Return);
    	}
				
		
	
		$data = array(
		'supplier_id' => $this->input->post('supplier_id'),
		
		'purchase_date' => $this->input->post('purchase_date'),
		
		
		'purchase_note' => $this->input->post('purchase_note'),
		'status' => '1',
		'created_at' => date('d-m-Y H:i:s')
		);
		$result = $this->Purchase_model->add_purchase_record($data);


		if ($result) {
			$key=0;
			foreach($this->input->post('item_name') as $items){

				/* get items info */
				// item name
				//$iname = $items['item_name']; 
				$item_name = $this->input->post('item_name');
				$iname = $item_name[$key]; 
				// item qty
				$qty = $this->input->post('qty_hrs');
				$qtyhrs = $qty[$key]; 
				// item price
				
				// item tax_id
				
				// item tax_rate
				
				// item sub_total
				
				// add values  
				$pmodel = $this->Products_model->read_product_information($iname);
				$data2 = array(
				'purchase_id' => $result,
				'supplier_id' => $this->input->post('supplier_id'),
				'item_id' => $iname,
				'item_name' => $pmodel[0]->product_name,
				'item_qty' => $qtyhrs,
				'created_at' => date('d-m-Y H:i:s')
				);
				$result_item = $this->Purchase_model->add_purchase_items_record($data2);
				// add products > 
				$add_product_qty = $pmodel[0]->product_qty + $qtyhrs;
				$idata = array(
					'product_qty' => $add_product_qty,
				);
				$iresult = $this->Products_model->update_record($idata,$iname);
				
			$key++;
		}
		$tdata = array(
		'transaction_type' => 'purchases',
		'dr_cr' => 'cr',
		'transaction_date' => $this->input->post('purchase_date'),
		'payer_payee_id' => $this->input->post('supplier_id'),
		'payment_method_id' => 'cash',
		'description' => $this->input->post('purchase_note'),
		'reference' => 'Purchase Products',
		'invoice_id' => $result,
		'created_at' => date('Y-m-d H:i:s')
		);
		$tresult = $this->Transactions_model->add_transactions($tdata);
		
		$Return['result'] = $this->lang->line('xin_acc_purchase_created');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and add info in database
	public function update_purchase() {
	
		if($this->input->post('add_type')=='purchase_create') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = $this->uri->segment(4);		
		
		if($this->input->post('purchase_number')==='') {
       		$Return['error'] = $this->lang->line('xin_acc_purchase_no_field');
		} else if($this->input->post('purchase_date')==='') {
       		$Return['error'] = $this->lang->line('xin_transfers_error_date');
		}
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		////
		$data = array(
		'purchase_number' => $this->input->post('purchase_number'),
		'purchase_date' => $this->input->post('purchase_date'),
		'prefix' => $this->input->post('prefix'),
		'purchase_note' => $this->input->post('purchase_note'),
		);
		$result = $this->Purchase_model->update_purchase_record($data,$id);
		$Return['result'] = $this->lang->line('xin_acc_purchase_updated');
		$this->output($Return);
		exit;
		}
	}
	
	// delete a purchase record
	public function delete_item() {
		
		if($this->uri->segment(5) == 'isajax') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			
			$result = $this->Purchase_model->delete_purchase_items_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_acc_purchase_item_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
	
	// delete a purchase record
	public function delete() {
		
		if($this->input->post('is_ajax') == '2') {
			/* Define return | here result is used to return user data and error for error message */
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$id = $this->uri->segment(4);
			
			$result = $this->Purchase_model->delete_record($id);
			$del_data = delete_transaction_purchase_data($id);
			if(isset($id)) {
				//set inventory back
				$purchase_info = $this->Purchase_model->get_purchase_items($id);
				foreach($purchase_info as $pinfo){
					$product_info = $this->Products_model->read_product_information($pinfo->item_id);
					// current qty
					$product_qty = $product_info[0]->product_qty;
					// purchased qty
					$item_qty = $pinfo->item_qty;
					// new qty
					$new_qty = $product_qty - $item_qty;
					$new_product_data = array(
						'product_qty' => $new_qty,
					);
					$this->Products_model->update_record($new_product_data,$pinfo->item_id);
				}
				$result_item = $this->Purchase_model->delete_purchase_items($id);
				$Return['result'] = $this->lang->line('xin_acc_purchase_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			$this->output($Return);
		}
	}
} 
?>