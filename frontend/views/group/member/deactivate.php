<?php use yii\helpers\Url; ?>
<div class="popup" id="popup-confirm-deactivate-member"> 
	<div id="frm-deactivate-member" class="frm-split-40-60 popup-data small box-confirm request-ajax" cmt-controller="member" cmt-action="deactivate" action="" method="post">		
		<div class="wrap-warning" id="data-form-id">			
			<h1 class="title-main"> Are you sure you want to deactivate this member? </h1>
			<p class="warning"> This member is no longer to access this group. </p>
		</div>	
		<input type='hidden' class="block_member_grid" name="id">
		<a class="btn cmt-submit btn-dark" cmt-request="frm-deactivate-member"> Confirm </a>
		<a class="btn cancel"> Cancel </a> 
		<div class="max-area-cover spinner"><div class="valign-center fa fa-3x fa-refresh fa-spin"></div></div>
	</div>
</div>
 	