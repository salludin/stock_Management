<?php
/* Purchase preview
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $system_setting = $this->Xin_model->read_setting_info(1);?>
<?php
	// get info
	$result2 = $supplier = $this->Suppliers_model->read_supplier_information($supplier_id); 
	if(!is_null($result2)) {
		// get company
		//$company = $this->Suppliers_model->read_supplier_information($supplier_id);
		$client_name = $result2[0]->supplier_name;
		$client_contact_number = $result2[0]->contact_number;
		$client_website_url = $result2[0]->website_url;
		$client_address_1 = $result2[0]->address_1;
		$client_address_2 = $result2[0]->address_2;
		$client_email = $result2[0]->email;
		$client_city = $result2[0]->city;
		$client_zipcode = $result2[0]->zipcode;
		$client_country = $this->Xin_model->read_country_info($result2[0]->country);
	} else {
		$client_name = '--';
	}
	
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1"> &nbsp; <small class="pull-right">
      <div class="btn-group pull-right" role="group" style="margin-top:2px; margin-right: 10px;">
        <button type="button" id="print-invoice" class="btn btn-vk btn-sm print-invoice"><i class="fa fa-print" aria-hidden="true"></i> <?php echo $this->lang->line('xin_print');?></button>
      </div>
      </small> </div>
    <div class="col-md-10 col-md-offset-1">
      <div class="invoice  <?php echo $get_animate;?>" style="margin:0px 10px;">
        <div id="print_invoice_hr"> 
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header"> <i class="fa fa-globe"></i> <?php echo $company_name;?> <small class="pull-right"><?php echo $this->lang->line('xin_e_details_date');?>: <?php echo date('d-m-Y');?></small></h2>
            </div>
            <!-- /.col --> 
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col"> Lokasi Penyimpanan
              <address>
              <strong><?php echo $company_name;?></strong><br>
              <?php echo $company_address;?><br>
              <?php echo $company_zipcode;?>, <?php echo $company_city;?><br>
              <?php echo $company_country;?><br />
              <?php echo $this->lang->line('xin_phone');?>: <?php echo $company_phone;?><br />
              <?php echo $this->lang->line('dashboard_email');?>: <?php echo $company_email;?>
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col"> Vendor Produksi
              <address>
              <strong><?php echo $client_name;?></strong><br>
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col"> <b><?php echo $this->lang->line('xin_acc_purchase');?> #<?php echo $prefix.' '.$purchase_number;?></b><br>
              <b><?php echo $this->lang->line('xin_e_details_date');?>:</b> <?php echo $this->Xin_model->set_date_format($purchase_date);?><br>
            </div>
            <!-- /.col --> 
          </div>
          <!-- /.row --> 
          
          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-stripedd">
                <thead style="background: #dce9f9;">
                  <tr>
                    <th class="py-3"> # </th>
                    <th class="py-3"> <?php echo $this->lang->line('xin_acc_item');?> </th>
                    
                    <th class="py-3"> <?php echo $this->lang->line('xin_acc_item_qtyhrs');?> </th>
                    
                  </tr>
                </thead>
                <tbody>
                  <?php
				$ar_sc = explode('- ',$system_setting[0]->default_currency_symbol);
				$sc_show = $ar_sc[1];
				?>
                  <?php $prod = array(); $i=1; foreach($this->Purchase_model->get_purchase_items($purchase_id) as $_item):?>
                  <tr>
                    <td class="py-3"><div class="font-weight-semibold"><?php echo $i;?></div></td>
                    <td class="py-3" style="width:"><div class="font-weight-semibold"><?php echo $_item->item_name;?></div></td>
                    
                    <td class="py-3"><?php echo $_item->item_qty;?></td>
                    
                  </tr>
                  <?php endforeach;?>
                </tbody>
              </table>
            </div>
            <!-- /.col --> 
          </div>
          <!-- /.row -->
          
          <div class="row"> 
            <!-- /.col -->
            <div class="col-xs-7">
              <?php if($purchase_note!=''):?>
              <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;"> <?php echo $purchase_note;?> </p>
              <?php endif;?>
            </div>
            <!-- /.col --> 
          </div>
          <!-- /.row --> 
        </div>
      </div>
    </div>
  </div>
</div>
