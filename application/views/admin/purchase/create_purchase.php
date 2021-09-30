<?php
// Create purchase Page

$system_setting = $this->Xin_model->read_setting_info(1);
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div class="row <?php echo $get_animate;?>">
  <div class="col-md-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> Barang masuk </h3>
      </div>
      <div class="box-body" aria-expanded="true" style="">
        <div class="row m-b-1">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'create_purchase', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'form');?>
            <?php $hidden = array('user_id' => 0);?>
            <?php echo form_open('admin/purchase/create_new_purchase', $attributes, $hidden);?>
            <div class="bg-white">
              <div class="box-block">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="supplier_id">Vendor Produksi</label>
                      <?php $suppliers = $all_suppliers->result();?>
                      <select class="form-control" name="supplier_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select');?>">
                        <option value=""></option>
                        <?php foreach($suppliers as $supplier) {?>
                        <option value="<?php echo $supplier->supplier_id?>"><?php echo $supplier->supplier_name?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="purchase_date">Tanggal Terima Barang</label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_e_details_date');?>" readonly="readonly" name="purchase_date" type="text" value="">
                    </div>
                  </div>
                  <div class="col-md-4">
                                <label for="item_name">BRAND</label>
                                <br>
                                <select class="form-control item_name" name="item_name[]" id="item_name" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select');?>">
                                  <option value=""></option>
                                  <?php foreach($all_items as $_item) {
                                  $categories = $this->Products_model->read_category_info($_item->category_id) ?>
                                  <option value="<?php echo $_item->product_id?>" item-price="<?php echo $_item->purchase_price?>"><?php echo $_item->product_name?> | <?php echo $categories[0]->name ?> </option>
                                  <?php } ?>
                                </select>
                              </div>
                  <div class="col-md-2">
                                <label for="qty_hrs" class="cursor-pointer"><?php echo $this->lang->line('xin_acc_item_qtyhrs');?></label>
                                <br>
                                <input type="text" class="form-control qty_hrs" name="qty_hrs[]" id="qty_hrs" value="1">
                              </div>
                  
                </div>
                <div id="item-list"></div>
                <div class="row overflow-hidden1">
                        <div class="col-xs-12">
                          <button type="button" data-repeater-create="" class="btn btn-primary" id="add-invoice-item"> <i class="fa fa-plus"></i> Tambah Brand</button>
                        </div>
                      </div>
                <hr>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      
                      <?php
						$ar_sc = explode('- ',$system_setting[0]->default_currency_symbol);
						$sc_show = $ar_sc[1];
						?>
                      <input type="hidden" class="items-sub-total" name="items_sub_total" value="0" />
                      <input type="hidden" class="items-tax-total" name="items_tax_total" value="0" />
                    
                      <div class="form-group col-xs-12 mb-2 file-repeaters"> </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <label for="purchase_note"><?php echo $this->lang->line('xin_acc_purchase_note');?></label>
                          <textarea name="purchase_note" class="form-control"></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="invoice-footer">
                  <div class="row">
                    <div class="col-md-7 col-sm-12"> &nbsp; </div>
                    <div class="col-md-5 col-sm-12 text-xs-center">
                      <button type="submit" name="invoice_submit" class="btn btn-primary pull-right my-1" style="margin-right: 5px;"><i class="fa fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_acc_submit');?></button>
                    </div>
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
