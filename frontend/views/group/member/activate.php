<?php use yii\helpers\Url; ?>
<div class="popup" id="popup-confirm-activate-member"> 
	<div id="frm-activate-member" class="frm-split-40-60 popup-data small box-confirm request-ajax" cmt-controller="member" cmt-action="activate" action="" method="post">		
		<div class="wrap-warning" id="data-form-id">			
			<h1 class="title-main"> Are you sure you want to activate this member? </h1> 
		</div>	
		<input type='hidden' class="active_member_grid" name="id">
		 <a class="btn cmt-submit btn-dark" cmt-request="frm-activate-member"> Confirm </a>
		 <a class="btn cancel"> Cancel </a> 
		<div class="max-area-cover spinner"><div class="valign-center fa fa-3x fa-refresh fa-spin"></div></div>
	</div>
</div>
 	