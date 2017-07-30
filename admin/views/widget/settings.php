<?php
// Yii Imports
use yii\widgets\ActiveForm;
use yii\helpers\Html;

// CMG Imports
use cmsgears\files\widgets\ImageUploader;

$coreProperties = $this->context->getCoreProperties();
$this->title	= 'Widget Settings | ' . $coreProperties->getSiteTitle();
$template		= $model->template;
?>
<div class="box box-cud">
	<div class="box-wrap-header">
		<div class="header">Widget Settings</div>
	</div>
	<div class="box-wrap-content clearfix">

		<div class="box-content">
			<div class="header">Widget Details</div>
			<div class="info">
				<table>
					<tr><td>Name</td><td><?= $model->name ?></td></tr>
					<tr><td>Description</td><td><?= $model->description ?></td></tr>
					<tr><td>Template</td><td><?php if( isset( $template ) ) echo $template->name; ?></td></tr>
					<tr><td>Class Path</td><td><?= $meta->classPath ?></td></tr>
				</table>
			</div>
		</div>

		<div class="filler-space"></div>

		<div class="box-content frm-split-40-60 clearfix">
			<div class="header"><?= $model->name ?> Settings</div>
			<?php if( isset( $template ) ) { ?>
				<?= Yii::$app->templateManager->renderViewAdmin( $template, [ 'model' => $meta ], [ 'page' => false ] ) ?>
			<?php } else { ?>
				<p>Template is not defined for this widget.</p>
			<?php } ?>
		</div>
	</div>
</div>