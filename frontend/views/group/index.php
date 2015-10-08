<?php
use \Yii;
use yii\helpers\Html; 
use yii\helpers\Url;  
use yii\widgets\LinkPager;
use cmsgears\widgets\nav\BasicNav; 
use cmsgears\core\common\utilities\CodeGenUtil;
use cmsgears\core\common\utilities\DateUtil;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | All Groups';
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

	[ 'label' => 'Create New Group', 'url' => ['group/create'], 'options' => [ 'class' => 'btn-create-group' ] ]
]; 

include_once"delete.php";
include_once"join.php";
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
		<h3 class="title-main"> Groups </h3>
	</div>  
	<div class="grid-content">
	<?php if( count( $models ) == 0 ) { ?>		
		<div class="grid-rows account hidden" id="grid-primary">
			<div class="grid-rows-header clearfix">				
				<div class="col12x2">
					<h6 class="title">Avatar</h6>
				</div>  
				<div class="col12x2">
					<h6 class="title">Name</h6>
				</div>  
				<div class="col12x2">
					<h6 class="title">Status</h6>
				</div> 
				<div class="col12x2">
					<h6 class="title">Group SEO</h6>
				</div> 
				<div class="col12x2">
					<h6 class="title">Created on</h6>
				</div> 
				<div class="col12x2">
					<h6 class="title">Updated on</h6>
				</div> 
				<div class="col12x2">
					<h6 class="title">Actions</h6>
				</div> 
			</div>
		</div>	
		<div class="block-data hidden block-data-primary"></div>	
		<p> <span class="success"> Welcome <?= $user->firstName.' '.$user->lastName ?>. Click <u class="link btn-create-account"> here </u> to create your first account. </span> </p>
	<?php } else { ?>
		<div class="grid-rows account"> 
			<div class="block-data">
			<?php
				$slugBase	= $siteUrl;
				
				foreach( $models as $group ) {
							
					if( $group->createdBy == $user->id || $group->status == $statusActive ) {	
					
					$id				= $group->id;   
					$editUrl		= Html::a( $group->name, [ "/cmgcmn/group/update?id=$id" ] );
					$slug			= $group->slug;
					$slugUrl		= "<a href='" . $slugBase . "group/$slug'>$slug</a>";
					$content		= $group->content;
					$members		= $group->members;
					$memberCount	= 0;
					$memberStatus	= -1;
					
					foreach( $members as $member ) {
						 
						$memberCount++;	
						
						if( $user->id == $member->userId ) {
							
							$memberStatus	= $member->status;
						}			 
					}					
				?>				
					
					<div class="grid-row" id="grid-row-<?=$id?>">						
						<div class="grid-row-data clearfix">
							<div class="col12x4 clearfix">
								<span class="label-header col1"><?=$group->name?></span>
								<span class="data-account-name col1"><?= CodeGenUtil::getImageThumbTag( $group->avatar, [ 'class' => 'avatar', 'image' => 'avatar' ] ) ?></span> 
							</div>  	
							<div class="col12x4 clearfix">
								<span class="label-header col1">Members</span> 
								<span title="View Group Members"><?= Html::a( $memberCount, ["/cmgcmn/group/member/all?id=$id"], ['class'=>'link'] )  ?></span>
							</div>							 
							<div class="col12x4 clearfix"> 
								<div class="col1 wrap-action-icons">	
									<?php if($group->createdBy != $user->id) { ?>
										<span>
											
											<?php if( $memberStatus == -1 ) { ?>
												<a class="fa fa-plus-square btn-join-group" title="Join Group"></a> 
												<span class="hidden"><?= Url::toRoute( [ '/cmgcmn/apix/group/member/join?id='.$user->id ] ) ?></span>
											<?php } ?>
											<?php if( $memberStatus == $memberStatusNew ) { ?>
												<a class="fa fa-exclamation" title="Request Pending"></a>  
											<?php } ?>
											<?php if( $memberStatus == $memberStatusBlocked) { ?>
												<a class="fa fa-ban" title="Request Blocked"></a>  
											<?php } ?>
											
											<span class="hidden"><?= 'grid-row-'.$id ?></span>
											<span class="hidden"><?= $id ?></span>
										</span>
										
									<?php } ?>								
									<span title="View Group Messages"><?= Html::a( "", ["/cmgcmn/group/message/all?id=$id"], ['class'=>'fa fa-envelope'] )  ?></span>
									<span title="Update Group"><?= Html::a( "", ["/cmgcmn/group/update?id=$id"], ['class'=>'fa fa-edit'] )  ?></span>
									<span> 
										<a class="fa fa-remove btn-delete-group" title="Delete Group"></a>
										<span id="action-url" class="hidden"><?= Url::toRoute( 'apix/group/delete?id='.$id ) ?></span>										 		
										<span data="grid-row-<?= $id ?>"></span>	 
									</span>									
								</div>	
							</div>
						</div>
					</div>
	<?php 	} } ?>
		</div>
		</div>
	<?php } ?>
	</div> 
	<div class="grid-footer">
		<div class="text"> <?=CodeGenUtil::getPaginationDetail( $dataProvider ) ?> </div>
		<?= LinkPager::widget( [ 'pagination' => $pagination ] ); ?>
	</div>
</section> 