<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use cmsgears\core\widgets\Editor;
use cmsgears\files\widgets\FileUploader;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Update Group';

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-group';
$this->params['sidebar-child'] 	= 'group';

Editor::widget( [ 'selector' => '.content-editor' ] );
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Update Group</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-group-create', 'options' => ['class' => 'frm-split form-with-editor' ] ] );?>

    	<?= $form->field( $model, 'name' ) ?>
    	<?= $form->field( $content, 'templateId' )->dropDownList( ArrayHelper::merge( [ '0' => 'Choose Template' ], $templateMap ) ) ?>
    	<?= $form->field( $model, 'status' )->dropDownList( $statusMap ) ?>
    	<?= $form->field( $model, 'visibility' )->dropDownList( $visibilityMap ) ?>

    	<h4>Group Summary</h4>
    	<?= $form->field( $content, 'summary' )->textarea( [ 'class' => 'content-editor' ] ) ?>

    	<h4>Group Content</h4>
    	<?= $form->field( $content, 'content' )->textarea( [ 'class' => 'content-editor' ] ) ?>

    	<h4>Group Avatar</h4>
		<?=FileUploader::widget( [ 'options' => [ 'id' => 'avatar-group', 'class' => 'file-uploader' ], 'model' => $model->avatar, 'modelClass' => 'Avatar', 'directory' => 'avatar', 'btnChooserIcon' => 'icon-action icon-action-edit' ] );?>

    	<h4>Group Banner</h4>
		<?=FileUploader::widget( [ 'options' => [ 'id' => 'banner-group', 'class' => 'file-uploader' ], 'model' => $content->banner, 'modelClass' => 'Banner', 'directory' => 'banner', 'btnChooserIcon' => 'icon-action icon-action-edit' ] );?>

		<h4>Group SEO</h4>
    	<?= $form->field( $content, 'seoName' ) ?>
    	<?= $form->field( $content, 'seoDescription' )->textarea() ?>
    	<?= $form->field( $content, 'seoKeywords' )->textarea() ?>
		<?= $form->field( $content, 'seoRobot' ) ?>

		<h4>Assign Categories</h4>
		<?php 
			$groupCategories	= $model->getCategoryIdList();

			foreach ( $categories as $category ) { 

				if( in_array( $category['id'], $groupCategories ) ) {
		?>		
					<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$category['id']?>" checked /><?=$category['name']?></span>
		<?php 
				}
				else {
		?>
					<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$category['id']?>" /><?=$category['name']?></span>
		<?php
				}
			}
		?>			
		<div class="box-filler"></div>

		<?=Html::a( "Cancel", [ '/cmgcmn/group/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Update" />

		<?php ActiveForm::end(); ?>
	</div>
</section>