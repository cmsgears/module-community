<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Delete Group Member';

$gid			= $group->id;
$user 			= $model->user;

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-group';
$this->params['sidebar-child'] 	= 'group';
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Delete Group Member</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-group-message-delete', 'options' => ['class' => 'frm-split' ] ] );?>

		<label>Username</label><label><?= $user->username ?></label>
		<label>Name</label><label><?= $user->getName() ?></label>
		<label>Email</label><label><?= $user->email ?></label>
		<label>Role</label><label><?= $model->role->name ?></label>
		
		<?= $form->field( $model, 'groupId' )->hiddenInput()->label( false ) ?>
		<?= $form->field( $model, 'status' )->dropDownList( $statusMap, [ 'disabled'=>'true' ] ) ?>

		<div class="box-filler"></div>

		<?=Html::a( "Back", [ '/cmgcmn/group/members?id=' . $gid ], ['class' => 'btn' ] );?>
		<input type="submit" value="Delete" />

		<?php ActiveForm::end(); ?>
	</div>
</section>