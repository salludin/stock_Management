<?php
// Edit Purchase Page

$system_setting = $this->Xin_model->read_setting_info(1);
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div class="row <?php echo $get_animate;?>">
  <div class="col-md-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> <?php echo $this->lang->line('xin_acc_edit_purchase');?> #<?php echo $purchase_number;?> </h3>
      </div>
      <div class="box-body" aria-expanded="true" style="">
        <div class="row m-b-1">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'create_invoice', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'form');?>
            <?php $hidden = array('user_id' => 0);?>
            <?php echo form_open('admin/purchase/update_purchase/'.$purchase_id, $attributes, $hidden);?>
            <div class="bg-white">
              <div class="box-block">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="purchase_number"><?php echo $this->lang->line('xin_acc_purchase_no');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_acc_purchase_no');?>" name="purchase_number" type="text" value="<?php echo $purchase_number;?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="project"><?php echo $this->lang->line('left_supplier');?></label>
                      <?php $suppliers = $all_suppliers->result();?>
                      <?php foreach($suppliers as $supplier) {?>
                      <?php if($supplier->supplier_id==$supplier_id):?>
                      <?php $sname = $supplier->supplier_name?>
                      <input type="text" class="form-control" readonly="readonly" value="<?php echo $sname;?>" />
                      <?php endif;?>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="purchase_date"><?php echo $this->lang->line('xin_e_details_date');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_e_details_date');?>"  name="purchase_date" type="text" value="<?php echo $purchase_date;?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="prefix"><?php echo $this->lang->line('xin_inv_prefix');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_inv_prefix');?>" name="prefix" type="text" value="<?php echo $prefix;?>">
                    </div>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="hrsale-item-values">
                        <div data-repeater-list="items">
                          <div data-repeater-item="">
                            <?php $prod = array(); foreach($this->Purchase_model->get_purchase_items($purchase_id) as $_item):?>
                            <div class="row item-row">
                              <div class="form-group mb-1 col-sm-12 col-md-3">
                                <label for="item_name"><?php echo $this->lang->line('xin_acc_item');?></label>
                                <br>
                                <?php foreach($all_items as $_iitem) {?>
                                <?php if($_iitem->product_name==$_item->item_name):?>
                                <?php $product_name = $_iitem->product_name?>
                                <?php endif;?>
                                <?php } ?>
                                <input type="text" readonly="readonly" class="form-control" value="<?php echo $product_name;?>" />
                              </div>
                              <div class="form-group mb-1 col-sm-12 col-md-2">
                                <label for="tax_type"><?php echo $this->lang->line('xin_invoice_tax_type');?></label>
                                <br>
                                <?php foreach($all_taxes as $_tax){?>
                                <?php
                                if($_tax->type=='percentage') {
                               		$_tax_type = $_tax->rate.'%';
                                } else {
                                	$_tax_type = $this->Xin_model->currency_sign($_tax->rate);
                                }
                                ?>
                                <?php if($_item->item_tax_type==$_tax->tax_id):?>
                                <?php $taxtype = $_tax->name.' ('.$_tax_type.')';?>
                                <?php endif;?>
                                <?php } ?>
                                <input type="text" readonly="readonly" class="form-control" value="<?php echo $taxtype;?>" />
                              </div>
                              <div class="form-group mb-1 col-sm-12 col-md-1">
                                <label for="tax_type"><?php echo $this->lang->line('xin_acc_tax_rate');?></label>
                                <br>
                                <input type="text" readonly="readonly" class="form-control" value="<?php echo $_item->item_tax_rate;?>" />
                              </div>
                              <div class="form-group mb-1 col-sm-12 col-md-1">
                                <label for="qty_hrs" class="cursor-pointer"><?php echo $this->lang->line('xin_acc_item_qtyhrs');?></label>
                                <br>
                                <input type="text" class="form-control" value="<?php echo $_item->item_qty;?>" readonly="readonly">
                              </div>
                              <div class="skin skin-flat form-group mb-1 col-sm-12 col-md-2">
                                <label for="unit_price"><?php echo $this->lang->line('xin_acc_unit_price');?></label>
                                <br>
                                <input class="form-control" type="text" value="<?php echo $_item->item_unit_price;?>" readonly="readonly"/>
                              </div>
                              <div class="form-group mb-1 col-sm-12 col-md-2">
                                <label for="profession"><?php echo $this->lang->line('xin_acc_subtotal');?></label>
                                <input type="text" class="form-control" readonly="readonly" value="<?php echo $_item->item_sub_total;?>" />
                                <!-- <br>-->
                                <p style="display:none" class="form-control-static"><span class="amount-html">0</span></p>
                              </div>
                              <div class="form-group col-sm-12 col-md-1 text-xs-center mt-2">
                                <label for="profession">&nbsp;</label>
                                <br>
                              </div>
                            </div>
                            <?php endforeach;?>
                          </div>
                        </div>
                      </div>
                      <?php
						$ar_sc = explode('- ',$system_setting[0]->default_currency_symbol);
						$sc_show = $ar_sc[1];
						?>
                      <input type="hidden" class="items-sub-total" name="items_sub_total" value="<?php echo $sub_total_amount;?>" />
                      <input type="hidden" class="items-tax-total" name="items_tax_total" value="<?php echo $total_tax;?>" />
                      <div class="row">
                        <div class="col-md-7 col-sm-12 text-xs-center text-md-left">&nbsp; </div>
                        <div class="col-md-5 col-sm-12">
                          <div class="table-responsive">
                            <table class="table">
                              <tbody>
                                <tr>
                                  <td><?php echo $this->lang->line('xin_acc_subtotal');?></td>
                                  <td class="text-xs-right"><?php echo $sc_show;?> <span class="sub_total"><?php echo $sub_total_amount;?></span></td>
                                </tr>
                                <tr>
                                  <td><?php echo $this->lang->line('xin_acc_tax_item');?></td>
                                  <td class="text-xs-right"><?php echo $sc_show;?> <span class="tax_total"><?php echo $total_tax;?></span></td>
                                </tr>
                                <tr>
                                  <td colspan="2" style="border-bottom:1px solid #dddddd; padding:0px !important; text-align:left"><table class="table table-bordered">
                                      <tbody>
                                        <tr>
                                          <td width="30%" style="border-bottom:1px solid #dddddd; text-align:left"><strong><?php echo $this->lang->line('xin_acc_discount_type');?></strong></td>
                                          <td style="border-bottom:1px solid #dddddd; text-align:center"><strong><?php echo $this->lang->line('xin_acc_discount');?></strong></td>
                                          <td style="border-bottom:1px solid #dddddd; text-align:left"><strong><?php echo $this->lang->line('xin_acc_discount_amount');?></strong></td>
                                        </tr>
                                        <tr>
                                          <td><div class="form-group">
                                              <?php if($discount_type==1):
										  	$discount_type = $this->lang->line('xin_acc_flat');
										  else:
										  	$discount_type = $this->lang->line('xin_acc_percent');
										  endif;?>
                                              <input type="text" class="form-control" readonly="readonly" value="<?php echo $discount_type;?>" />
                                            </div></td>
                                          <td align="right"><div class="form-group">
                                              <input style="text-align:right" type="text" readonly="readonly" class="form-control" value="<?php echo $discount_figure;?>">
                                            </div></td>
                                          <td align="right"><div class="form-group">
                                              <input type="text" style="text-align:right" readonly="" value="<?php echo $total_discount;?>" class="form-control">
                                            </div></td>
                                        </tr>
                                      </tbody>
                                    </table></td>
                                </tr>
                              <input type="hidden" class="fgrand_total" readonly="readonly" value="<?php echo $grand_total;?>" />
                              <tr>
                                <td><?php echo $this->lang->line('xin_acc_grand_total');?></td>
                                <td class="text-xs-right"><?php echo $sc_show;?> <span class="grand_total"><?php echo $grand_total;?></span></td>
                              </tr>
                                </tbody>
                              
                            </table>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-xs-12 mb-2 file-repeaters"> </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <label for="purchase_note"><?php echo $this->lang->line('xin_acc_purchase_note');?></label>
                          <textarea name="purchase_note" class="form-control"><?php echo $purchase_note;?></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row no-print">
                  <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary pull-right print-invoice" name="invoice_submit" style="margin-right: 5px;"> <i class="fa fa-download"></i> <i class="fa fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_acc_submit');?> </button>
                  </div>
                </div>
              </div>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
      </div>
    </div>
  </div>
</div>
