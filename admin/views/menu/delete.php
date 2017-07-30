<?php
// Yii Imports
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title	= 'Delete Menu | ' . $coreProperties->getSiteTitle();
?>
<div class="box box-cud">
	<div class="box-wrap-header">
		<div class="header">Delete Menu</div>
	</div>
	<div class="box-wrap-content">
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-menu' ] );?>

		<div class="frm-split frm-split-40-60 clearfix">
			<?= $form->field( $model, 'name' )->textInput( [ 'readonly' => 'true' ] ) ?>
			<?= $form->field( $model, 'description' )->textarea( [ 'readonly' => 'true' ] ) ?>
			<?= $form->field( $model, 'active' )->checkbox( [ 'disabled' => 'true' ] ) ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Link Pages</div>
			<?php foreach ( $pageLinks as $key => $pageLink ) { ?>
				<span class="box-half">
					<?= $form->field( $pageLink, "[$key]link" )->checkbox( [ 'label' => $pageLink->name ] ) ?>
					<?= $form->field( $pageLink, "[$key]pageId" )->hiddenInput()->label( false ) ?>
					<div class="frm-split-40-60 clearfix">
						<?= $form->field( $pageLink, "[$key]htmlOptions" )->textInput( [ "placeholder" => "item options" ] ) ?>
						<?= $form->field( $pageLink, "[$key]urlOptions" )->textInput( [ "placeholder" => "url options" ] ) ?>
						<?= $form->field( $pageLink, "[$key]icon" )->textInput( [ "placeholder" => "icon" ] ) ?>
						<?= $form->field( $pageLink, "[$key]order" )->textInput( [ "placeholder" => "order" ] ) ?>
					</div>
				</span>
			<?php } ?>
		</div>

		<div class="box-content frm-split-40-60 clearfix">
			<div class="header">Additional Links</div>
			<?php foreach ( $links as $key => $link ) { ?>
			<div class="clear link">
				<span class="box-half">
					<?= $form->field( $link, "[$key]address" )->textInput( [ "placeholder" => "link address" ] ) ?>
					<?= $form->field( $link, "[$key]private" )->checkbox() ?>
					<?= $form->field( $link, "[$key]relative" )->checkbox() ?>
				</span>
				<span class="box-half">
					<?= $form->field( $link, "[$key]label" )->textInput( [ "placeholder" => "label" ] ) ?>
					<?= $form->field( $link, "[$key]htmlOptions" )->textInput( [ "placeholder" => "item options" ] ) ?>
					<?= $form->field( $link, "[$key]urlOptions" )->textInput( [ "placeholder" => "url options" ] ) ?>
					<?= $form->field( $link, "[$key]icon" )->textInput( [ "placeholder" => "icon" ] ) ?>
					<?= $form->field( $link, "[$key]order" )->textInput( [ "placeholder" => "order" ] ) ?>
				</span>
			</div>
			<?php  } ?>
		</div>

		<div class="filler-height"></div>

		<div class="align align-center">
			<?=Html::a( 'Cancel',  [ 'all' ], [ 'class' => 'btn btn-medium' ] );?>
			<input class="element-medium" type="submit" value="Delete" />
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>