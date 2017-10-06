<?php use yii\helpers\Url; ?>
<div class="popup" id="popup-update-message">
	<div class="popup-data small">		 
		<i class="fa fa-times-circle popup-close"></i>
		<h6 class="popup-wrap-title"> Update Message </h6>		 
		<div id="frm-update-message" class="data-form request-ajax" cmt-controller="message" cmt-action="update" action="" method="post">
			<label> Message </label>
			<textarea type="text" id="message-content" name="Message[content]"></textarea>
			<input type="hidden" id="grid-row" name="grid">
			<div class="row clearfix">
				<div class="col12x6">
					<a class="btn width-100 btn-cancel"> Cancel </a>
				</div>
				<div class="col12x6">	
					<a class="btn width-100 cmt-submit" cmt-request="frm-update-message"> Update </a>
				</div>	
			</div>	 
			<div class="max-area-cover spinner"><div class="valign-center fa fa-3x fa-refresh fa-spin"></div></div>
		</div>	
	</div>
</div>	