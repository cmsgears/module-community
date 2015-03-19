<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Delete Group Message';

$gid			= $group->getId();
$user 			= $model->owner;
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Delete Group Message</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-group-message-delete', 'options' => ['class' => 'frm-split' ] ] );?>

		<label>Username</label><label><?= $user->getUsername() ?></label>
		<label>Name</label><label><?= $user->getName() ?></label>	
		<label>Email</label><label><?= $user->getEmail() ?></label>

    	<?= $form->field( $model, 'message_content' )->textarea( [ 'disabled'=>'true' ] ) ?>

		<div class="box-filler"></div>

		<?=Html::a( "Back", [ '/cmgcommunity/group/messages/?id=' . $gid ], ['class' => 'btn' ] );?>
		<input type="submit" value="Delete" />

		<?php ActiveForm::end(); ?>
	</div>
</section>

<script type="text/javascript">
	initSidebar( "sidebar-group", -1 );
	initFileUploader();
</script>