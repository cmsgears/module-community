<?php use yii\helpers\Url; ?>
<div class="popup" id="popup-confirm-join-group"> 
	<div id="frm-join-group" class="frm-split-40-60 popup-data small box-confirm request-ajax" cmt-controller="member" cmt-action="join" action="" method="post">		
		<div class="wrap-warning" id="data-form-id">			
			<h1 class="title-main"> Are you sure you want to join this group? </h1> 
		</div>	
		<input type="hidden" class="join_member_grid" name="grid">
		<input type="hidden" class="group_id" name="group"> 
		<a class="btn cmt-submit btn-dark" cmt-request="frm-join-group"> Confirm </a>
		<a class="btn cancel"> Cancel </a> 
		<div class="max-area-cover spinner"><div class="valign-center fa fa-3x fa-refresh fa-spin"></div></div>
	</div>
</div>
<?php include_once'template-join-group.php' ?>
 	