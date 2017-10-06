<?php use yii\helpers\Url; ?>
<div class="popup" id="popup-create-message">
	<div class="popup-data small">		 
		<i class="fa fa-times-circle popup-close"></i>
		<h6 class="popup-wrap-title"> Create Message </h6>		 
		<div id="frm-create-message" class="data-form request-ajax" cmt-controller="message" cmt-action="create" action="<?= Url::toRoute( '/cmgcmn/apix/group/message/create' ) ?>" method="post">
			<label> Message </label>
			<textarea type="text" name="Message[content]"></textarea>  
			<input type="hidden" name="Message[groupId]" value="<?= $groupId ?>">
			<input type="hidden" name="Message[memberId]" value="<?= $memberId ?>">
			<div class="row clearfix">
				<div class="col12x6">
					<a class="btn width-100 btn-cancel"> Cancel </a>
				</div>
				<div class="col12x6">	
					<a class="btn width-100 cmt-submit" cmt-request="frm-create-message"> Create </a>
				</div>	
			</div>	 
			<div class="max-area-cover spinner"><div class="valign-center fa fa-3x fa-refresh fa-spin"></div></div>
		</div>	
	</div>
</div>	