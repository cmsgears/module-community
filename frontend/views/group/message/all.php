<?php
use \Yii;
use yii\helpers\Html; 
use yii\helpers\Url;  
use yii\widgets\LinkPager;
use cmsgears\widgets\nav\BasicNav; 
use cmsgears\core\common\utilities\CodeGenUtil;
use cmsgears\core\common\utilities\DateUtil;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | All Messages';
$siteUrl		= $coreProperties->getSiteUrl();
$user			= Yii::$app->user->getIdentity(); 

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

	[ 'label' => 'Create Message', 'url' => ['/'], 'options' => [ 'class' => 'btn-create-message' ] ]
];  

include_once"create.php";
include_once"update.php";
include_once"delete.php";
include_once"template-create-message.php";
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
		<h3 class="title-main"> Group Messages </h3>
	</div>  
	<div class="grid-content">
	<?php if( count( $models ) == 0 ) { ?>	
		<span class="success"> No messages to display. </span> 	
	<?php } else { ?>
		<div class="grid-rows account"> 
			<div class="block-data" id="block-messages">
			<?php 
			
				foreach( $models as $message ) {
					
					$id				= $message->id;
					$messageUser	= $message->member->user; 
					$content		= $message->content;
					 					
				?>
				<div class="grid-row" id="grid-row-<?= $id ?>">						
					<div class="grid-row-data clearfix"> 
						<div class="col12x2">
							<?= DateUtil::getDateTime( $message->createdAt ) ?>
						</div>				
						<div class="col12x3">
							<?= $messageUser->username ?>
						</div>
						<div class="col12x5">
							<?php if( $content != null ) {
								
								echo '<span>'. $content .'</span>';	
							} else {
								
								echo '<span class="warning"> Blank Message </span> ';
								
							} ?>	
						</div>
						<?php if( $messageUser->id == $user->id || $message->group->createdBy == $user->id ) { ?>
						<div class="col12x2 clearfix"> 
							<div class="col1 wrap-action-icons">										 
								<span>
									<a class="fa fa-edit btn-update-message align-left" title="Update Message"></a> 
									<span class="hidden">grid-row-<?= $id ?></span>  
									<span class="hidden"> <?= Url::toRoute( '/cmgcmn/apix/group/message/update?id='.$id ) ?></span>
									<span class="hidden"><?= $content ?></span>
								</span>	
								<span>
									<a class="fa fa-remove btn-delete-message align-left" title="Delete Message"></a> 
									<span class="hidden">grid-row-<?=$id?></span> 
									<span class="hidden"> <?= Url::toRoute( '/cmgcmn/apix/group/message/delete?id='.$id ) ?></span>
								</span>
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