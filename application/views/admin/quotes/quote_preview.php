<?php
/* Quote preview
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $system_setting = $this->Xin_model->read_setting_info(1);?>
<?php
	// get info
	$result2 = $this->Customers_model->read_customer_info($customer_id);
	if(!is_null($result2)) {
		// get company
		$company = $this->Xin_model->read_company_info($result2[0]->company_id);
		if(!is_null($company)){
			$comp_name = $company[0]->name;
		} else {
			$comp_name = '--';	
		}
		$client_name = $result2[0]->name.' ('.$comp_name.')';
		$client_contact_number = $result2[0]->contact_number;
		$client_company_name = $comp_name;
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
            <div class="col-sm-4 invoice-col"> <?php echo $this->lang->line('xin_acc_from');?>
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
            <div class="col-sm-4 invoice-col"> <?php echo $this->lang->line('xin_acc_to');?>
              <address>
              <strong><?php echo $client_name;?></strong><br>
              <?php echo $client_company_name;?><br>
              <?php echo $client_address_1.' '.$client_address_2;?><br>
              <?php echo $client_city.', '.$client_country[0]->country_name;?><br>
              <?php echo $this->lang->line('xin_phone');?>: <?php echo $client_contact_number;?><br>
              <?php echo $this->lang->line('dashboard_email');?>: <?php echo $client_email;?>
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col"> <b>Nomor Pengiriman : <?php echo $prefix.' '.$quote_number;?></b><br>
              <br>
              <b>Tanggal Pengiriman:</b> <?php echo $this->Xin_model->set_date_format($quote_date);?><br>
              <b>Tanggal Diterima:</b><?php if($quote_due_date !== ''){ ?> <?php echo $this->Xin_model->set_date_format($quote_due_date);?> <?php } ?><br>
          <b>Penerima:</b> <?php echo $receipt_name;?><br>
              <div class="invoice-status">
                <?php
				if($status == 0){
					$_status = '<span class="label label-info">'.$this->lang->line('xin_quote_draft').'</span>';
				} else if($status == 1) {
					$_status = '<span class="label bg-purple">'.$this->lang->line('xin_quote_delivered').'</span>';
				} else if($status == 2) {
					$_status = '<span class="label label-warning">'.$this->lang->line('xin_quote_on_hold').'</span>';
				} else if($status == 3) {
					$_status = '<span class="label label-success">'.$this->lang->line('xin_accepted').'</span>';
				} else if($status == 4) {
					$_status = '<span class="label bg-maroon">'.$this->lang->line('xin_quote_lost').'</span>';
				} else {
					$_status = '<span class="label label-danger">'.$this->lang->line('xin_quote_dead').'</span>';
				}
				echo $_status;
				?>
              </div>
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
                    <th class="py-3"> Jumlah </th>
                  </tr>
                </thead>
                <tbody>
                  <?php
				$ar_sc = explode('- ',$system_setting[0]->default_currency_symbol);
				$sc_show = $ar_sc[1];
				?>
                  <?php $prod = array(); $i=0; foreach($this->Quotes_model->get_quote_items($quote_id) as $_item): $i++ ?>
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
              <?php if($quote_note!=''):?>
              <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;"> <?php echo $quote_note;?> </p>
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
