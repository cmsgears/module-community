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
$this->title 	= 'Update Sidebar | ' . $coreProperties->getSiteTitle();
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
				<div class="box-header-title"> Link Widget </div>
			</div>
			<div class="box-content-wrap frm-split-40-60">
				<div class="box-content">
					<?php foreach ( $widgets as $key => $widget ) { ?>
						<div class="row">
							<div class="col col2">
								<?= $form->field( $sidebarWidgets[ $key ], "[$key]htmlOptions" )->textInput( [ 'placeholder' => 'html options' ] ) ?>
							</div>

							<div class="col col2">
								<?= $form->field( $sidebarWidgets[ $key ], "[$key]order" )->textInput( [ 'placeholder' => 'order' ] ) ?>
							</div>
						</div>
						<div class="row">
							<div class="col col2">
								<?= $form->field( $sidebarWidgets[ $key ], "[$key]widget" )->checkbox( [ 'label' => $widget[ 'name' ] ] ) ?>
							</div>
							<div class="col col2">
									<?= $form->field( $sidebarWidgets[ $key ], "[$key]widgetId" )->hiddenInput( [ 'value' => $widget['id'] ] )->label( false ) ?>
							</div>		
						</div>
					<div class="filler-height">
					</div>	
					<?php } ?>
				</div>
			</div>
		</div>

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

