<?php use yii\helpers\Url; ?>
<div class="popup" id="popup-confirm-delete-group"> 
	<div id="frm-delete-group" class="frm-split-40-60 popup-data small box-confirm request-ajax" cmt-controller="group" cmt-action="delete" method="post">		
		<span class="hidden" id="grid_row_id"></span>
		<div class="wrap-warning" id="data-form-id">			
			<h1 class="title-main"> Are you sure you want delete this group? </h1>
			<p class="warning"> All the messages and members will be deleted associated with this goal. </p>
		</div>		
		 <a class="btn cmt-submit btn-dark" cmt-request="frm-delete-group"> Confirm Delete </a>
		 <a class="btn cancel"> Cancel </a> 
		<div class="max-area-cover spinner"><div class="valign-center fa fa-3x fa-refresh fa-spin"></div></div>
	</div>
</div>
 	