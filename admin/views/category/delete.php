<?php
// Yii Imports
use yii\widgets\ActiveForm;
use yii\helpers\Html;

// CMG Imports
use cmsgears\core\common\widgets\Editor;
use cmsgears\files\widgets\ImageUploader;
use cmsgears\files\widgets\VideoUploader;
use cmsgears\icons\widgets\IconChooser;

$coreProperties = $this->context->getCoreProperties();
$this->title	= 'Delete Category | ' . $coreProperties->getSiteTitle();
$returnUrl		= $this->context->returnUrl;

Editor::widget( [ 'selector' => '.content-editor', 'loadAssets' => true ] );
?>
<div class="box box-cud">
	<div class="box-wrap-header">
		<div class="header">Delete Category</div>
	</div>
	<div class="box-wrap-content frm-split-40-60">
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-category' ] );?>

		<?= $form->field( $model, 'name' )->textInput( [ 'readonly' => true ] ) ?>
		<?= $form->field( $model, 'description' )->textInput( [ 'readonly' => true ] ) ?>
		<?= $form->field( $model, 'parentId' )->dropDownList( $categoryMap, [ 'disabled' => true ] ) ?>
		<?= IconChooser::widget( [ 'model' => $model, 'options' => [ 'class' => 'wrap-icon-picker clearfix' ], 'disabled' => true ] ) ?>
		<?= $form->field( $model, 'htmlOptions' )->textarea( [ 'readonly' => true ] ) ?>
		<?= $form->field( $model, 'featured' )->checkbox( [ 'disabled' => true ] ) ?>

		<div class="box-content clearfix">
			<div class="header">Category Summary</div>
			<?= $form->field( $content, 'summary' )->textarea( [ 'class' => 'content-editor' ] )->label( false ) ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Category Content</div>
			<?= $form->field( $content, 'content' )->textarea( [ 'class' => 'content-editor' ] )->label( false ) ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Category Banner</div>
			<?= ImageUploader::widget([
					'options' => [ 'id' => 'model-banner', 'class' => 'file-uploader' ],
					'model' => $banner, 'modelClass' => 'Banner', 'directory' => 'banner'
			]); ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Category Video</div>
			<?= VideoUploader::widget( [ 'options' => [ 'id' => 'model-video', 'class' => 'file-uploader' ], 'model' => $video ]); ?>
		</div>

		<div class="box-content clearfix">
			<div class="header">Category SEO</div>
			<?= $form->field( $content, 'seoName' )->textInput( [ 'readonly'=>'true' ] ) ?>
			<?= $form->field( $content, 'seoDescription' )->textarea( [ 'readonly' => 'true' ] ) ?>
			<?= $form->field( $content, 'seoKeywords' )->textarea( [ 'readonly' => 'true' ] ) ?>
			<?= $form->field( $content, 'seoRobot' )->textInput( [ 'readonly'=>'true' ] ) ?>
		</div>

		<div class="filler-height"></div>

		<div class="align align-center">
			<?=Html::a( 'Cancel', $returnUrl, [ 'class' => 'btn btn-medium' ] );?>
			<input class="element-medium" type="submit" value="Delete" />
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>


<?php
// Yii Imports
use yii\widgets\ActiveForm;
use yii\helpers\Html;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;
use cmsgears\core\common\widgets\Editor;
use cmsgears\files\widgets\ImageUploader;
use cmsgears\files\widgets\VideoUploader;
use cmsgears\widgets\category\CategoryMapper;
use cmsgears\icons\widgets\IconChooser;

Editor::widget( [ 'selector' => '.content-editor', 'loadAssets' => true ] );

$coreProperties = $this->context->getCoreProperties();
$this->title 	= 'Delete Block | ' . $coreProperties->getSiteTitle();
$returnUrl		= $this->context->returnUrl;
?>
<div class="box-crud-wrap row">
	<div class="box-crud-wrap-main colf colf3x2">
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-block', 'options' => [ 'class' => 'form' ] ] ); ?>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Basic Details</div>
			</div>
			<div class="box-content-wrap frm-split-40-60">
				<div class="box-content">
					<div class="row">
						<div class="col col2">
							<?= $form->field( $model, 'name' )->textInput( [ 'readonly' => true ] ) ?>
		
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'description' )->textInput( [ 'readonly' => true ] ) ?>
		
						</div>
					</div>
					<div class="filler-height"> </div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $model, 'parentId' )->dropDownList( $categoryMap, [ 'disabled' => true ] ) ?>
		
						</div>
						<div class="col col2">
							<?= IconChooser::widget( [ 'model' => $model, 'options' => [ 'class' => 'icon-picker-wrap' ], 'disabled' => true ] ) ?>
		
						</div>		
					</div>
					<div class="filler-height"> </div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $content, 'templateId' )->dropDownList( $templatesMap , [ 'disabled' => true ]) ?>
							
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'featured' )->checkbox( [ 'disabled' => true ] ) ?>
						</div>
					</div>
					<div class="filler-height"> </div>
					<div class="row">
						<div class="col col2">
							<label> Summary </label>
							<?= $form->field( $content, 'summary' )->textarea( [ 'class' => 'content-editor' ] )->label( false ) ?>
						</div>	
						<div class="col col2">
							<label> Content </label>
							<?= $form->field( $content, 'content' )->textarea( [ 'class' => 'content-editor' ] )->label( false ) ?>
						</div>	
					</div>	
					<div class="filler-height"> </div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $model, 'htmlOptions' )->textarea( [ 'readonly' => true ] ) ?>
		
						</div>	
						<div class="col col2">
						</div>	
					</div>
					<div class="filler-height"> </div>
				</div>
			</div>
		</div>
		<div class="filler-height"> </div>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Images</div>
			</div>
			<div class="box-content">
				<div class="box-content">
					<div class="row  padding padding-small-v">

						<div class="col col12x4">
							<label> Banner </label>
							<?= ImageUploader::widget([ 'directory' => 'banner' ,  'model' => $banner,  'modelClass' => 'Banner' ]); ?>
						</div>
						<div class="col col12x4">
							<label> Video </label>
							<?= VideoUploader::widget( [  'model' => $video ,  'modelClass' => 'Video', 'directory' => 'video' ]); ?>
						</div>

					</div>
				</div>
			</div>
		</div>
		<div class="filler-height"> </div>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Page SEO</div>
			</div>
			<div class="box-content">
				<div class="box-content">
					<div class="row  padding padding-small-v">

						<div class="col col2">
							<?= $form->field( $content, 'seoName' ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $content, 'seoRobot' ) ?>
						</div>
					</div>
					<div class="row  padding padding-small-v">
						<div class="col col2">
							<?= $form->field( $content, 'seoKeywords' )->textarea() ?>
						</div>
						<div class="col col2">
							<?= $form->field( $content, 'seoDescription' )->textarea() ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium"></div>
		
		
		<div class="filler-height filler-height-medium"></div>

		<div class="align align-right">
			<?= Html::a( 'Cancel', $returnUrl, [ 'class' => 'btn btn-medium' ] ); ?>
			<input class="element-medium" type="submit" value="Delete" />
		</div>

		<div class="filler-height filler-height-medium"></div>
		<?php ActiveForm::end(); ?>
	</div>
	<div class="box-crud-wrap-sidebar colf colf3">

	</div>
</div>


