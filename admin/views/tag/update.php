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
$this->title 	= 'Update Tag | ' . $coreProperties->getSiteTitle();
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
							<?= $form->field( $model, 'name' ) ?>
		
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'description' )->textarea() ?>
		
						</div>
					</div>
					<div class="filler-height"> </div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $content, 'templateId' )->dropDownList( $templatesMap ) ?>
						</div>
						<div class="col col2">
							<?= IconChooser::widget( [ 'model' => $model, 'options' => [ 'class' => 'icon-picker-wrap' ] ] ) ?>
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
			<?= Html::a( 'View All', $returnUrl, [ 'class' => 'btn btn-medium' ] ); ?>
			<input class="element-medium" type="submit" value="Update" />
		</div>

		<div class="filler-height filler-height-medium"></div>
		<?php ActiveForm::end(); ?>
	</div>
	<div class="box-crud-wrap-sidebar colf colf3">

	</div>
</div>


