<?php use yii\helpers\Url; ?>
<div class="popup" id="popup-invite-members">
	<div class="popup-data small">		 
		<i class="fa fa-times-circle popup-close"></i>
		<h6 class="popup-wrap-title"> Invite Members </h6>		 
		<div id="frm-invite-members" class="data-form request-ajax" cmt-controller="member" cmt-action="invite" action="<?= Url::toRoute( 'apix/group/member/invite' ) ?>" method="post">			
			<div id="wrap-users">				
				<input type="text" data="0" name="username[0]" placeholder="Username or Email">
			</div>	 
			<label><i class="fa fa-plus action-inline no-margin" title="Create New Account" id="create-transaction-account">Add More User </i></label> 
			<a class="btn cmt-submit" cmt-request="frm-invite-members"> Invite </a>
			<div class="max-area-cover spinner"><div class="valign-center fa fa-3x fa-refresh fa-spin"></div></div>
		</div>	
	</div>
</div> 