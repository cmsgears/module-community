<?php
// Yii Imports
use yii\helpers\Html;

// CMG Imports
use cmsgears\core\common\widgets\ActiveForm;
use cmsgears\files\widgets\AvatarUploader;
use cmsgears\icons\widgets\IconChooser;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= 'Add Group Member | ' . $coreProperties->getSiteTitle();
$returnUrl		= $this->context->returnUrl;

$userName	= isset( $model->user ) ? $model->user->name : null;
$groupName	= isset( $model->group ) ? $model->group->name : null;
?>
<div class="box-crud-wrap row">
	<div class="box-crud-wrap-main">
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-member', 'enableClientValidation' => false, 'options' => [ 'class' => 'form' ] ] ); ?>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Basic Details</div>
			</div>
			<div class="box-content-wrap frm-split-40-60">
				<div class="box-content">
					<div class="row">
						<div class="col col5x2">
							<?= Yii::$app->formDesigner->getAutoSuggest( $form, $model, 'userId', [
								'placeholder' => 'Search User', 'icon' => 'cmti cmti-search',
								'app' => 'core', 'controller' => 'user',
								'value' => $userName, 'url' => 'core/user/auto-search'
							])?>
						</div>
						<div class="col col5 align align-center">
							OR
						</div>
						<div class="col col5x2">
							<?= Yii::$app->formDesigner->getIconCheckbox( $form, $model, 'registerUser', [ 'class' => 'cmt-checkbox cmt-choice cmt-field-group', 'group-target' => 'render-user' ], 'cmti cmti-checkbox' ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $model, 'roleId' )->dropDownList( $roleMap, [ 'class' => 'cmt-select' ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'status' )->dropDownList( $statusMap, [ 'class' => 'cmt-select' ] ) ?>
						</div>
					</div>
					<div class="row">
						<?php if( empty( $group ) ) { ?>
							<div class="col col2">
								<?= Yii::$app->formDesigner->getAutoSuggest( $form, $model, 'groupId', [ 'placeholder' => 'Group', 'icon' => 'cmti cmti-search', 'value' => $groupName, 'url' => 'community/group/auto-search' ] ) ?>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium render-user"></div>
		<div class="box box-crud render-user">
			<div class="box-header">
				<div class="box-header-title">User Details</div>
			</div>
			<div class="box-content-wrap frm-split-40-60">
				<div class="box-content">
					<div class="row">
						<div class="col col2">
							<?= $form->field( $user, 'email' ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $user, 'username' ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col4">
							<?= $form->field( $user, 'title' ) ?>
						</div>
						<div class="col col4">
							<?= $form->field( $user, 'firstName' ) ?>
						</div>
						<div class="col col4">
							<?= $form->field( $user, 'middleName' ) ?>
						</div>
						<div class="col col4">
							<?= $form->field( $user, 'lastName' ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col3">
							<?= $form->field( $user, 'mobile' ) ?>
						</div>
						<div class="col col3">
							<?= $form->field( $user, 'phone' ) ?>
						</div>
						<div class="col col3">
							<?= $form->field( $member, 'roleId' )->dropDownList( $siteRoleMap, [ 'class' => 'cmt-select' ] ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $user, 'status' )->dropDownList( $statusMap, [ 'class' => 'cmt-select' ] ) ?>
						</div>
						<div class="col col2">
							<?= Yii::$app->formDesigner->getIconInput( $form, $user, 'dob', [ 'right' => true, 'icon' => 'cmti cmti-calendar', 'options' => [ 'class' => 'datepicker' ] ] ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= IconChooser::widget( [ 'model' => $user, 'options' => [ 'class' => 'icon-picker-wrap' ] ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $user, 'description' )->textarea() ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium render-user"></div>
		<div class="box box-crud render-user">
			<div class="box-header">
				<div class="box-header-title">User Files</div>
			</div>
			<div class="box-content">
				<div class="box-content">
					<div class="row padding padding-small-v">
						<div class="col col12x4">
							<label>Avatar</label>
							<?= AvatarUploader::widget( [ 'model' => $avatar ] ) ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium"></div>
		<div class="align align-right">
			<?= Html::a( 'Cancel', $returnUrl, [ 'class' => 'btn btn-medium' ] ); ?>
			<input class="frm-element-medium" type="submit" value="Create" />
		</div>
		<div class="filler-height filler-height-medium"></div>
		<?php ActiveForm::end(); ?>
	</div>
</div>
