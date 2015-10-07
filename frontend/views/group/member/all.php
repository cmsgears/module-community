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
				
				foreach( $models as $member ) {

					$id			= $member->id;   
					$memberUser	= $member->user; 
					 					
				?>				
					
					<div class="grid-row" id="grid-row-<?=$id?>">						
						<div class="grid-row-data clearfix">
							<div class="col12x4 clearfix">
								<span class="label-header col1"><?=$memberUser->username?></span>
								<span class="data-account-name col1"><?= CodeGenUtil::getImageThumbTag( $user->avatar, [ 'class' => 'avatar', 'image' => 'avatar' ] ) ?></span> 
							</div> 
							<?php if( $member->status == $statusBlocked && $member->group->createdBy == $user->id ) { ?>  	
							<div class="col12x4 clearfix">
								<span class="label-header col1">Status</span>
								<span class="label-header col1"> <?= $member->getStatusStr() ?> </span> 
							</div>	
							<?php } ?>				 
							<div class="col12x4 clearfix"> 
								<div class="col1 wrap-action-icons">
									<span title="View Group Members"><?= Html::a( "", ["/cmgcmn/group/member/all?id=$id"], ['class'=>'fa fa-users'] )  ?></span>
									
								</div>	
							</div>
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