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
$this->title 	= 'Add Block | ' . $coreProperties->getSiteTitle();
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
							<?= IconChooser::widget( [ 'model' => $model, 'options' => [ 'class' => 'icon-picker-wrap' ] ] ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $model, 'description' )->textarea() ?>
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'templateId' )->dropDownList( $templatesMap ) ?>
						</div>		
					</div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $model, 'htmlOptions' )->textarea() ?>
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'title' ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
								<?= $form->field( $model, 'active' )->checkbox() ?>
						</div>
						<div class="col col2">
								
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
							<label> Texture </label>
							<?= ImageUploader::widget([ 'directory' => 'texture' ,  'model' => $texture,  'modelClass' => 'Texture' ]); ?>
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
				<div class="box-header-title"> Link Elements </div>
			</div>
			<div class="box-content">
				<div class="box-content">
					<div class="row padding padding-small-v">

						<div class="col col1">
							<label> Link Elements </label>
							<?php foreach ( $elements as $key => $element ) { ?>
								<span class="box-half">
									<?= $form->field( $blockElements[ $key ], "[$key]element" )->checkbox( [ 'label' => $element[ 'name' ] ] ) ?>
									<?= $form->field( $blockElements[ $key ], "[$key]elementId" )->hiddenInput( [ 'value' => $element['id'] ] )->label( false ) ?>
									<div class="frm-split-40-60 clearfix">
										<?= $form->field( $blockElements[ $key ], "[$key]htmlOptions" )->textInput( [ "placeholder" => "item options" ] ) ?>
										<?= $form->field( $blockElements[ $key ], "[$key]order" )->textInput( [ "placeholder" => "order" ] ) ?>
									</div>
								</span>
							<?php } ?>
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
