<?php
use \Yii;
use yii\helpers\Html; 
use yii\helpers\Url;  
use yii\widgets\LinkPager;
use cmsgears\widgets\nav\BasicNav; 
use cmsgears\core\common\utilities\CodeGenUtil;
use cmsgears\core\common\utilities\DateUtil; 

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | All Members';
$siteUrl		= $coreProperties->getSiteUrl();
 

// Data
$pagination		= $dataProvider->getPagination();
$models			= $dataProvider->getModels();

// Searching
$searchTerms	= Yii::$app->request->getQueryParam("search");

// Sorting
$sortOrder		= Yii::$app->request->getQueryParam("sort");

if( !isset( $sortOrder ) ) {

	$sortOrder	= '';
}

// Quick Links 
$quickLinkItems = [

	[ 'label' => 'Invite Members', 'url' => ['/'], 'options' => [ 'class' => 'btn-invite-members' ] ]
]; 

include_once"invite.php";
include_once"deactivate.php"; 
include_once"block.php"; 
include_once"activate.php"; 
include_once"template-activate-row.php";
include_once"template-deactivate-row.php";
include_once"template-block-row.php";
include_once"template-update-role.php";
include_once"template-add-member.php";
include_once"delete.php"; 
?>
<div class="quick-links left">
	<?php	
        echo BasicNav::widget([
            'options' => [ 'class' => 'nav-main align-left'],
            'items' => $quickLinkItems          
        ]);
	?>
</div> 
<section class="grid-data grid-basic max-cols"> 
	<div class="grid-title">
		<h3 class="title-main"> Group Members </h3>
	</div>  
	
	<span class='box-icon-sort'>
		<span sort-order='status' class="icon-sort <?php if( strcmp( $sortOrder, 'status') == 0 ) echo 'icon-up-active'; else echo 'fa fa-arrow-up';?>"></span>
		<span sort-order='-status' class="icon-sort <?php if( strcmp( $sortOrder, '-status') == 0 ) echo 'icon-down-active'; else echo 'fa fa-arrow-down';?>"></span>
	</span>
	<div class="grid-content">
	<?php if( count( $models ) == 0 ) { ?>  		
	<?php } else { ?>
		<div class="grid-rows account"> 
			<div class="block-data" id="block-members">
			<?php
				$slugBase	= $siteUrl;
				
				foreach( $models as $member ) {

					$id			= $member->id;   
					$memberUser	= $member->user; 
					 					
				?>				
					
					<div class="grid-row" id="grid-row-<?=$id?>">						
						<div class="grid-row-data clearfix">
							<div class="col12x4 clearfix">
								<span class="label-header col1"><?=$memberUser->username?></span>
								<span class="data-account-name col1"> 
									<?php
									
										if( isset( $memberUser->avatar ) ) {
									  
											echo CodeGenUtil::getImageThumbTag( $user->avatar, [ 'class' => 'avatar', 'image' => 'avatar' ] );
										}
										else {
											
											echo '<img src='. Yii::getAlias('@images').'/avatar.png'.'>';
										}?>  
								</span> 
							</div> 
							<?php if( $member->group->createdBy == $user->id ) { ?>
								<div class="col12x4 clearfix">
									<span class="label-header col1">Role</span>
									<span class="col12x8" id="role-name-<?=$id?>">
										<?=$member->role->name?>
									</span>	
									<div class="col12x8 wrap-role-list hidden"> 
										<select class="bm-select hidden" name="GroupMember[roleId]">	
											<?= CodeGenUtil::generateSelectOptionsIdName( $roleList, "{$member->roleId}" ); ?>
										</select>
										<span class="hidden">role-name-<?=$id?></span>	
										<span class="hidden"> <?= Url::toRoute( [ '/cmgcmn/apix/group/member/update-role?id='.$id ] ) ?> </span>									
									</div>	 				 
								</div>	 
								<div class="col12x4 clearfix"> 
									<div class="col1 wrap-action-icons">
										<?php if( $member->status == $statusNew ) { ?>
											<a class="fa fa-unlock-alt btn-member-activate block-active" title="Approve Member"></a>
											<span class="hidden"><?= Url::toRoute( [ '/cmgcmn/apix/group/member/activate?id='.$id ] ) ?></span>	
											<span class="hidden"><?= 'grid-row-'.$id ?></span>	
											<a class="fa fa-lock btn-member-block" title="Block Member"></a>		
											<span class="hidden"><?= Url::toRoute( [ '/cmgcmn/apix/group/member/deactivate?id='.$id ] ) ?></span>	
											<span class="hidden"><?= 'grid-row-'.$id ?></span>																		
										<?php } else ?>
										<?php if( $member->status == $statusBlocked ) { ?>
											<a class="fa fa-unlock-alt btn-member-activate" title="Activate Member"></a>
											<span class="hidden"><?= Url::toRoute( [ '/cmgcmn/apix/group/member/activate?id='.$id ] ) ?></span>	
											<span class="hidden"><?= 'grid-row-'.$id ?></span>																		
										<?php } else { ?>
										<?php if( $member->status == $statusActive ) { ?>
											<a class="fa fa-lock btn-member-deactivate" title="Deactivate Member"></a>		
											<span class="hidden"><?= Url::toRoute( [ '/cmgcmn/apix/group/member/deactivate?id='.$id ] ) ?></span>	
											<span class="hidden"><?= 'grid-row-'.$id ?></span>									
										<?php } } ?>
										<span><a data="role-name-<?=$id?>" class="fa fa-edit btn-update-role align-left" title="Update Role"></a></span>
										<?php if( $member->userId != $user->id ) { ?>
										<span>
											<a class="fa fa-remove btn-delete-member align-left" title="Delete Member"></a>
											<span class="hidden">grid-row-<?=$id?></span>
											<span class="hidden"> <?= Url::toRoute( [ '/cmgcmn/apix/group/member/delete?id='.$id ] ) ?></span>
										</span>	
										<?php } ?>
									</div>									
								</div>
							<?php } ?>			
						</div>
					</div>
	<?php 	} ?>
		</div>
		</div>
	<?php } ?>
	</div> 
	<div class="grid-footer">
		<div class="text"> <?=CodeGenUtil::getPaginationDetail( $dataProvider ) ?> </div>
		<?= LinkPager::widget( [ 'pagination' => $pagination ] ); ?>
	</div>
</section> 

<!--- Update Role Form -------------------------------- -->

<div id="frm-update-member-role" class="frm-split-40-60 data-form request-ajax hidden" cmt-controller="member" cmt-action="role-update" action="" method="post">
	<input type="hidden" name="GroupMember[roleId]" id="member_role_id">
	<input type="hidden" name="row_id" id="member_row_id">
	<a class="btn cmt-submit" cmt-request="frm-update-member-role"></a>
<div class="max-area-cover spinner"><div class="valign-center fa fa-3x fa-refresh fa-spin"></div></div>