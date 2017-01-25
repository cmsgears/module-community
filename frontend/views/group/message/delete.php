<?php use yii\helpers\Url; ?>
<div class="popup" id="popup-confirm-delete-message"> 
	<div id="frm-delete-message" class="frm-split-40-60 popup-data small box-confirm request-ajax" cmt-controller="message" cmt-action="delete" method="post">		
		
		<div class="wrap-warning" id="data-form-id">			
			<h1 class="title-main"> Are you sure you want delete this message? </h1> 
		</div>	
		<input type="hidden" name="grid" id="message-grid">	
		 <a class="btn cmt-submit btn-dark" cmt-request="frm-delete-message"> Confirm Delete </a>
		 <a class="btn cancel"> Cancel </a> 
		<div class="max-area-cover spinner"><div class="valign-center fa fa-3x fa-refresh fa-spin"></div></div>
	</div>
</div>
 	