<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\core\common\widgets\Editor;
use cmsgears\files\widgets\AvatarUploader;
use cmsgears\files\widgets\FileUploader;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Delete Group';

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-group';
$this->params['sidebar-child'] 	= 'group';

Editor::widget( [ 'selector' => '.content-editor' ] );
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Delete Group</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-group-delete', 'options' => ['class' => 'frm-split form-with-editor' ] ] );?>

    	<?= $form->field( $model, 'name' )->textInput( [ 'readonly'=>'true' ] ) ?>
    	<?= $form->field( $content, 'templateId' )->dropDownList( ArrayHelper::merge( [ '0' => 'Choose Template' ], $templateMap ), [ 'disabled'=>'true' ] ) ?>
    	<?= $form->field( $model, 'status' )->dropDownList( $statusMap, [ 'disabled'=>'true' ] ) ?>
    	<?= $form->field( $model, 'visibility' )->dropDownList( $visibilityMap, [ 'disabled'=>'true' ] ) ?>

    	<h4>Group Summary</h4>
    	<?= $form->field( $content, 'summary' )->textarea( [ 'class' => 'content-editor', 'readonly' => 'true' ] ) ?>

    	<h4>Group Content</h4>
    	<?= $form->field( $content, 'content' )->textarea( [ 'class' => 'content-editor', 'readonly' => 'true' ] ) ?>

    	<h4>Group Avatar</h4>
		<?=AvatarUploader::widget( [ 'options' => [ 'id' => 'avatar-group', 'class' => 'file-uploader' ], 'model' => $avatar, 'modelClass' => 'Avatar',  'directory' => 'avatar', 'btnChooserIcon' => 'icon-action icon-action-edit' ] );?>

    	<h4>Group Banner</h4>
		<?=FileUploader::widget( [ 'options' => [ 'id' => 'banner-group', 'class' => 'file-uploader' ], 'model' => $banner, 'modelClass' => 'Banner', 'directory' => 'banner', 'btnChooserIcon' => 'icon-action icon-action-edit' ] );?>

		<h4>Group SEO</h4>
    	<?= $form->field( $content, 'seoName' )->textInput( [ 'readonly'=>'true' ] ) ?>
    	<?= $form->field( $content, 'seoDescription' )->textarea( [ 'readonly'=>'true' ] ) ?>
    	<?= $form->field( $content, 'seoKeywords' )->textarea( [ 'readonly'=>'true' ] ) ?>
		<?= $form->field( $content, 'seoRobot' )->textInput( [ 'readonly'=>'true' ] ) ?>

		<h4>Assign Categories</h4>
		<?php 
			$groupCategories	= $model->getCategoryIdList();

			foreach ( $categories as $category ) { 

				if( in_array( $category['id'], $groupCategories ) ) {
		?>		
					<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$category['id']?>" checked disabled /><?=$category['name']?></span>
		<?php 
				}
				else {
		?>
					<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$category['id']?>" disabled /><?=$category['name']?></span>
		<?php
				}
			}
		?>			
		<div class="box-filler"></div>

		<?=Html::a( "Back", [ '/cmgcmn/group/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Delete" />

		<?php ActiveForm::end(); ?>
	</div>
</section>