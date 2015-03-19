<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Delete Group Member';

$gid			= $group->getId();
$user 			= $model->user;
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Delete Group Member</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-group-message-delete', 'options' => ['class' => 'frm-split' ] ] );?>

		<label>Username</label><label><?= $user->getUsername() ?></label>
		<label>Name</label><label><?= $user->getName() ?></label>	
		<label>Email</label><label><?= $user->getEmail() ?></label>
		<label>Role</label><label><?= $model->role->getName() ?></label>
		<label>Status</label><label><?= $model->getStatusStr() ?></label>

		<div class="box-filler"></div>

		<?=Html::a( "Back", [ '/cmgcommunity/group/members/?id=' . $gid ], ['class' => 'btn' ] );?>
		<input type="submit" value="Delete" />

		<?php ActiveForm::end(); ?>
	</div>
</section>

<script type="text/javascript">
	initSidebar( "sidebar-group", -1 );
	initFileUploader();
</script>