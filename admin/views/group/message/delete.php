<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Delete Group Message';

$gid			= $group->id;
$user 			= $model->member->user;
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Delete Group Message</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-group-message-delete', 'options' => ['class' => 'frm-split' ] ] );?>

		<label>Username</label><label><?= $user->username ?></label>
		<label>Name</label><label><?= $user->name ?></label>	
		<label>Email</label><label><?= $user->email ?></label>

    	<?= $form->field( $model, 'content' )->textarea( [ 'readonly'=>'true' ] ) ?>

		<div class="box-filler"></div>

		<?=Html::a( "Back", [ '/cmgcmn/group/messages/?id=' . $gid ], ['class' => 'btn' ] );?>
		<input type="submit" value="Delete" />

		<?php ActiveForm::end(); ?>
	</div>
</section>

<script type="text/javascript">
	initSidebar( "sidebar-group", 3 );
	initFileUploader();
</script>