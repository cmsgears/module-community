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
$this->title 	= 'Update Menu | ' . $coreProperties->getSiteTitle();
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
							<?= $form->field( $model, 'active' )->checkbox() ?>
						</div>
					</div>
					<div class="filler-height"> </div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $model, 'description' )->textarea() ?>
						</div>
						<div class="col col2">
						</div>		
					</div>
					<div class="filler-height"> </div>
				</div>
			</div>
		</div>
		<div class="filler-height"></div>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title"> Link Pages </div>
			</div>
			<div class="box-content-wrap frm-split-40-60">
				<div class="box-content">
					<?php foreach ( $pages as $key => $page ) { ?>
						<div class="row">
							
							<div class="col col2">
								<?= $form->field( $pageLinks[ $key ], "[$key]urlOptions" )->textInput( [ "placeholder" => "url options" ] ) ?>
							</div>	
							<div class="col col2">
								<?= $form->field( $pageLinks[ $key ], "[$key]icon" )->textInput( [ "placeholder" => "icon" ] ) ?>
							</div>	
							<div class="col col2">
								<?= $form->field( $pageLinks[ $key ], "[$key]order" )->textInput( [ "placeholder" => "order" ] ) ?>
							</div>
							<div class="col col2">
								<?= $form->field( $pageLinks[ $key ], "[$key]link" )->checkbox( [ 'label' => $page[ 'name' ] ] ) ?>
								
							</div>
							<div class="col col2">
								<?= $form->field( $pageLinks[ $key ], "[$key]htmlOptions" )->textInput( [ "placeholder" => "item options" ] ) ?>
							</div>	
							<div class="col col2">
								<?= $form->field( $pageLinks[ $key ], "[$key]pageId" )->hiddenInput( [ 'value' => $page['id'] ] )->label( false ) ?>
							</div>
						</div>	
						<div class="filler-height"> </div>	
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="filler-height"></div>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title"> Additional Links </div>
			</div>
			<div class="box-content-wrap frm-split-40-60">
				<div class="box-content">
					<?php foreach ( $links as $key => $link ) { ?>
						<div class="row">
							<div class="col col2">
								<?= $form->field( $link, "[$key]private" )->checkbox() ?>
							</div>
							<div class="col col2">
								<?= $form->field( $link, "[$key]relative" )->checkbox() ?>
							</div>
							<div class="col col2">
								<?= $form->field( $link, "[$key]address" )->textInput( [ "placeholder" => "link address" ] ) ?>
							</div>	
							<div class="col col2">
								<?= $form->field( $link, "[$key]label" )->textInput( [ "placeholder" => "label" ] ) ?>
							</div>	
							<div class="col col2">
								<?= $form->field( $link, "[$key]htmlOptions" )->textInput( [ "placeholder" => "item options" ] ) ?>
							</div>	
							<div class="col col2">
								<?= $form->field( $link, "[$key]urlOptions" )->textInput( [ "placeholder" => "url options" ] ) ?>
							</div>	
							<div class="col col2">
								<?= $form->field( $link, "[$key]icon" )->textInput( [ "placeholder" => "icon" ] ) ?>
							</div>	
							<div class="col col2">
								<?= $form->field( $link, "[$key]order" )->textInput( [ "placeholder" => "order" ] ) ?>
							</div>	
						</div>	
						<div class="filler-height"> </div>	
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


