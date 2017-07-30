<?php
// Yii Imports
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title	= 'Delete Sidebar | ' . $coreProperties->getSiteTitle();
?>
<div class="box box-cud">
	<div class="box-wrap-header">
		<div class="header">Delete Sidebar</div>
	</div>
	<div class="box-wrap-content frm-split-40-60">
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-sidebar' ] );?>

		<?= $form->field( $model, 'name' )->textInput( [ 'readonly' => 'true' ] ) ?>
		<?= $form->field( $model, 'description' )->textarea( [ 'readonly' => 'true' ] ) ?>
		<?= $form->field( $model, 'active' )->checkbox( [ 'disabled'=>'true' ] ) ?>

		<div class="box-content clearfix">
			<div class="header">Link Widgets</div>
			<?php foreach ( $sidebarWidgets as $key => $sidebarWidget ) { ?>
				<span class="box-half">
					<?= $form->field( $sidebarWidget, "[$key]widget" )->checkbox( [ 'label' => $sidebarWidget->name, 'disabled' => true ] ) ?>
					<?= $form->field( $sidebarWidget, "[$key]widgetId" )->hiddenInput()->label( false ) ?>
					<div class="frm-split-40-60 clearfix">
						<?= $form->field( $sidebarWidget, "[$key]htmlOptions" )->textInput( [ 'placeholder' => 'html options', 'readonly' => true ] ) ?>
						<?= $form->field( $sidebarWidget, "[$key]order" )->textInput( [ 'placeholder' => 'order', 'readonly' => true ] ) ?>
					</div>
				</span>
			<?php } ?>
		</div>

		<div class="clear filler-height"></div>

		<div class="align align-center">
			<?=Html::a( 'Cancel', [ 'all' ], [ 'class' => 'btn btn-medium' ] );?>
			<input class="element-medium" type="submit" value="Delete" />
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>