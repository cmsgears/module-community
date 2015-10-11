<?php use yii\helpers\Url; ?>
<div class="popup" id="popup-invite-members">
	<div class="popup-data small">		 
		<i class="fa fa-times-circle popup-close"></i>
		<h6 class="popup-wrap-title"> Invite Members </h6>		 
		<div id="frm-invite-members" class="data-form request-ajax" cmt-controller="member" cmt-action="invite" action="<?= Url::toRoute( 'apix/group/member/invite' ) ?>" method="post">			
			<div id="wrap-users">								
				<input type="hidden" name="group_id" value="<?= $group->id ?>">
				<input type="text" data="0" name="User[0][username]" placeholder="Username or Email"> 
			</div>	 
			<label><i class="fa fa-plus action-inline no-margin" id="btn-add-row">Add More User </i></label> 
			<div class="row clearfix">
				<div class="col12x6">
					<a class="btn width-100 btn-cancel"> Cancel </a>
				</div>
				<div class="col12x6">	
					<a class="btn width-100 cmt-submit" cmt-request="frm-invite-members"> Invite </a>
				</div>	
			</div>	
			<div class="max-area-cover spinner"><div class="valign-center fa fa-3x fa-refresh fa-spin"></div></div>
		</div>	
	</div>
</div> 
<?php include_once"template-create-row.php" ?>