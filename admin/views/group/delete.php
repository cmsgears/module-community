<?php
// Yii Imports
use yii\widgets\ActiveForm;
use yii\helpers\Html;

// CMG Imports
use cmsgears\core\common\widgets\Editor;
use cmsgears\files\widgets\ImageUploader;
use cmsgears\files\widgets\VideoUploader;
use cmsgears\icons\widgets\IconChooser;

Editor::widget( [ 'selector' => '.content-editor', 'loadAssets' => true ] );

$coreProperties = $this->context->getCoreProperties();
$this->title 	= 'Add Group | ' . $coreProperties->getSiteTitle();
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
							<?= $form->field( $content, 'templateId' )->dropDownList( $templatesMap ) ?>
		
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $model, 'status' )->dropDownList( $statusMap ) ?>
		
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'visibility' )->dropDownList( $visibilityMap ) ?>
						</div>		
					</div>
					<div class="row">
						<div class="col col2">
							<label> Group Summary </label>
							<?= $form->field( $content, 'content' )->textarea( [ 'class' => 'content-editor', 'readonly' => 'true' ] )->label( false ) ?>
						</div>
						<div class="col col2">
							<label> Group Content </label>
							<?= $form->field( $content, 'content' )->textarea( [ 'class' => 'content-editor', 'readonly' => 'true'  ] )->label( false ) ?>
						</div>
					</div>
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
					<div class="row padding padding-small-v">

						<div class="col col12x4">
							<label> Avatar </label>
							<?= ImageUploader::widget([ 'directory' => 'avatar' ,  'model' => $avatar,  'modelClass' => 'Avatar' ]); ?>
						</div>
						<div class="col col12x4">
							<label> Banner </label>
							<?= ImageUploader::widget([ 'model' => $banner, 'modelClass' => 'Banner', 'directory' => 'banner' ] ); ?>
						</div>
							<div class="col col12x4">
							<label> Video </label>
							<?= VideoUploader::widget([  'model' => $video  ]); ?>
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
							<?= $form->field( $content, 'seoName' )->textInput( [ 'readonly'=>'true' ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $content, 'seoRobot' )->textInput( [ 'readonly'=>'true' ] ) ?>
						</div>
					</div>
					<div class="row  padding padding-small-v">
						<div class="col col2">
							<?= $form->field( $content, 'seoKeywords' )->textInput( [ 'readonly'=>'true' ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $content, 'seoDescription' )->textInput( [ 'readonly'=>'true' ] ) ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="filler-height filler-height-medium"></div>

		<div class="align align-right">
			<?= Html::a( 'Cancel', $returnUrl, [ 'class' => 'btn btn-medium' ] ); ?>
			<input class="element-medium" type="submit" value="Create" />
		</div>

		<div class="filler-height filler-height-medium"></div>
		<?php ActiveForm::end(); ?>
	</div>
	<div class="box-crud-wrap-sidebar colf colf3">

	</div>
</div>
