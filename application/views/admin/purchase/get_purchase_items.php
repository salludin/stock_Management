<script type="text/javascript">
$(document).ready(function(){		
    $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	    });
</script>

<div class="row item-row">
  <hr>
  <div class="form-group mb-1 col-sm-12 col-md-5">
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
  <div class="form-group mb-1 col-sm-12 col-md-5">
    <label for="qty_hrs" class="cursor-pointer"><?php echo $this->lang->line('xin_acc_item_qtyhrs');?></label>
    <br>
    <input type="text" class="form-control qty_hrs" name="qty_hrs[]" id="qty_hrs" value="1">
  </div>
  <div class="form-group col-sm-12 col-md-2 text-xs-center mt-2">
    <label for="profession">&nbsp;</label>
    <br>
    <button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light remove-invoice-item" data-repeater-delete=""> <span class="fa fa-trash"></span></button>
  </div>
</div>
