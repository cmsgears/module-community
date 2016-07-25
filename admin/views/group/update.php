<?php
// Yii Imports
use yii\widgets\ActiveForm;
use yii\helpers\Html;

// CMG Imports
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\core\common\widgets\Editor;
use cmsgears\files\widgets\AvatarUploader;
use cmsgears\files\widgets\ImageUploader;
use cmsgears\files\widgets\VideoUploader;

use cmsgears\widgets\category\CategoryAutoBox;
use cmsgears\widgets\tag\TagMapper;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= 'Update Group | ' . $coreProperties->getSiteTitle();

Editor::widget( [ 'selector' => '.content-editor', 'loadAssets' => true ] );
?>
<div class="box box-cud">
	<div class="box-wrap-header">
		<div class="header">Update Group</div>
	</div>
	<div class="box-wrap-content frm-split-40-60">
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-group' ] ); ?>

    	<?= $form->field( $model, 'name' ) ?>
    	<?= $form->field( $content, 'templateId' )->dropDownList( $templatesMap ) ?>
		<?= $form->field( $model, 'status' )->dropDownList( $statusMap ) ?>
		<?= $form->field( $model, 'visibility' )->dropDownList( $visibilityMap ) ?>

		<div class="box-content clearfix">
			<div class="header">Group Summary</div>
			<?= $form->field( $content, 'summary' )->textarea( [ 'class' => 'content-editor' ] )->label( false ) ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Group Content</div>
			<?= $form->field( $content, 'content' )->textarea( [ 'class' => 'content-editor' ] )->label( false ) ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Group Avatar</div>
			<?= AvatarUploader::widget( [ 'options' => [ 'id' => 'model-avatar', 'class' => 'file-uploader' ], 'model' => $avatar ]); ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Group Banner</div>
			<?= ImageUploader::widget([
					'options' => [ 'id' => 'model-banner', 'class' => 'file-uploader' ],
					'model' => $banner, 'modelClass' => 'Banner', 'directory' => 'banner'
			]); ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Group Video</div>
			<?= VideoUploader::widget( [ 'options' => [ 'id' => 'model-video', 'class' => 'file-uploader' ], 'model' => $video ]); ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Group SEO</div>
	    	<?= $form->field( $content, 'seoName' ) ?>
	    	<?= $form->field( $content, 'seoDescription' )->textarea() ?>
	    	<?= $form->field( $content, 'seoKeywords' )->textarea() ?>
			<?= $form->field( $content, 'seoRobot' ) ?>
		</div>

		<div class="filler-height"></div>

		<div class="align align-center">
			<?=Html::a( 'Cancel',  [ 'all' ], [ 'class' => 'btn btn-medium' ] );?>
			<input class="element-medium" type="submit" value="Update" />
		</div>

		<?php ActiveForm::end(); ?>

		<div class="filler-height"></div>

		<div class="box-content clearfix">
			<div class="header">Assign Categories</div>
			<?= CategoryAutoBox::widget([
				'options' => [ 'id' => 'box-category-auto', 'class' => 'box-mapper-auto' ],
				'type' => CmnGlobal::TYPE_GROUP,
				'model' => $model,
				'mapActionUrl' => "community/group/assign-category?slug=$model->slug",
				'deleteActionUrl' => "community/group/remove-category?slug=$model->slug"
			])?>
		</div>

		<div class="filler-height"></div>

		<div class="box-content clearfix">
			<div class="header">Assign Tags</div>
			<?= TagMapper::widget([
				'options' => [ 'id' => 'box-tag-mapper', 'class' => 'box-tag-mapper' ],
				'loadAssets' => true,
				'model' => $model,
				'assignUrl' => "community/group/assign-tags?slug=$model->slug",
				'removeUrl' => "community/group/remove-tag?slug=$model->slug"
			])?>
		</div>

		<div class="filler-height"></div>
	</div>
</div>