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
$this->title 	= 'Delete Element | ' . $coreProperties->getSiteTitle();
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
							<?= $form->field( $model, 'name' )->textInput( [ 'readonly' => 'true' ] ) ?>
		
						</div>
						
						<div class="col col2">
							<?= IconChooser::widget( [ 'model' => $model, 'options' => [ 'class' => 'icon-picker-wrap' ], 'disabled' => true ] ) ?>
						</div>
					</div>
					<div class="filler-height"> </div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $model, 'description' )->textarea( [ 'readonly' => 'true' ] ) ?>
		
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'templateId' )->dropDownList( $templatesMap, [ 'disabled' => 'true' ] ) ?>
		
						</div>		
					</div>
					<div class="filler-height"> </div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $model, 'active' )->checkbox( [ 'disabled' => 'true' ] ) ?>
						</div>
						<div class="col col2">
						
						</div>
					</div>
					<div class="filler-height"> </div>
					<div class="box box-crud">
						<div class="box-header">
							<div class="box-header-title">Images</div>
						</div>
						<div class="box-content">
							<div class="box-content">
								<div class="row row-inline padding padding-small-v">
								
									<div class="col col12x4">
										<label> Texture </label>
										<?= ImageUploader::widget([ 'directory' => 'texture' ,  'model' => $texture,  'modelClass' => 'Texture' ]); ?>
									</div>
								
								</div>
							</div>
						</div>
					</div>
					<div class="filler-height"> </div>
					<div class="row">
						<div class="box-content clearfix">
							<label> Element Content </label>
							<?= $form->field( $meta, 'content' )->textarea( [ 'class' => 'content-editor' ] )->label( false ) ?>
						</div>
					</div>	
				</div>
			</div>
		</div>

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


