<?php 
$session = $this->session->userdata('username');
$user_info = $this->Xin_model->read_user_info($session['user_id']);
if($user_info[0]->profile_photo!='' && $user_info[0]->profile_photo!='no file') {
	$lde_file = base_url().'uploads/users/'.$user_info[0]->profile_photo;
} else { 
	if($user_info[0]->gender=='Male') {  
		$lde_file = base_url().'uploads/users/default_male.jpg'; 
	} else {  
		$lde_file = base_url().'uploads/users/default_female.jpg';
	}
}
?>

<div class="box-widget widget-user-2"> 
  <!-- Add the bg color to the header using any of the bg-* classes -->
  <div class="widget-user-header">
    <div class="widget-user-image"> <img src="<?php echo $lde_file;?>" alt="" class="img-circle ui-w-50 rounded-circle"> </div>
    <h4 class="widget-user-username welcome-hrsale-user"><?php echo $this->lang->line('xin_acc_wback');?>, <?php echo $user_info[0]->first_name.' '.$user_info[0]->last_name?>!</h4>
    <h5 class="widget-user-desc welcome-hrsale-user-text"><?php echo $this->lang->line('xin_acc_today_is');?> <?php echo date('l, j F Y');?></h5>
  </div>
</div>
<hr class="container-m--x mt-0 mb-4">

<hr />

<hr />

