<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\core\common\widgets\Editor;
use cmsgears\files\widgets\AvatarUploader;
use cmsgears\files\widgets\FileUploader;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Add Group';
 

Editor::widget( [ 'selector' => '.content-editor' ] );
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		
		<?php $form = ActiveForm::begin( ['id' => 'frm-group-create', 'options' => ['class' => 'frm-split-40-60 form-with-editor content-60' ] ] );?>
		<h4 class="clear">Add Group</h4>
    	<?= $form->field( $model, 'name' ) ?>
    	<?= $form->field( $content, 'templateId' )->dropDownList( ArrayHelper::merge( [ '0' => 'Choose Template' ], $templateMap ) ) ?>
    	<?= $form->field( $model, 'status' )->dropDownList( $statusMap ) ?>
     
    	<h4 class="clear">Group Summary</h4>
    	<?= $form->field( $content, 'summary' )->textarea( [ 'class' => 'content-editor' ] ) ?>

    	<h4 class="clear">Group Content</h4>
    	<?= $form->field( $content, 'content' )->textarea( [ 'class' => 'content-editor' ] ) ?>

    	<h4 class="clear">Group Avatar</h4>
		<?=AvatarUploader::widget( [ 'options' => [ 'id' => 'avatar-group', 'class' => 'file-uploader' ], 'model' => $avatar, 'modelClass' => 'Avatar',  'directory' => 'avatar', 'btnChooserIcon' => 'fa fa-edit' ] );?>

    	<h4 class="clear">Group Banner</h4>
		<?=FileUploader::widget( [ 'options' => [ 'id' => 'banner-group', 'class' => 'file-uploader' ], 'model' => $banner, 'modelClass' => 'Banner', 'directory' => 'banner', 'btnChooserIcon' => 'fa fa-edit' ] );?>

		<h4 class="clear">Group SEO</h4>
    	<?= $form->field( $content, 'seoName' ) ?>
    	<?= $form->field( $content, 'seoDescription' )->textarea() ?>
    	<?= $form->field( $content, 'seoKeywords' )->textarea() ?>
		<?= $form->field( $content, 'seoRobot' ) ?>

		<h4 class="clear">Assign Categories</h4>
		<?php foreach ( $categories as $category ) { ?>
			<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$category['id']?>" /><?=$category['name']?></span>
		<?php } ?> 
		<div class="row clearfix">
			<div class="col12x2"></div>
			<div class="col12x4 clearfix">
				<?=Html::a( "Cancel", [ '/cmgcmn/group/index' ], ['class' => 'btn' ] );?>
			</div>
			<div class="col12x4 clearfix">
				<input type="submit" class="btn" value="Create" />
			</div>	
			<div class="col12x2"></div>
		</div>	

		<?php ActiveForm::end(); ?>
	</div>
</section>