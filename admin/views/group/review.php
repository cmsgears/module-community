<?php
// Yii Imports
use yii\helpers\Html;
use yii\widgets\ActiveForm;

// CMG Imports
use cmsgears\community\common\models\entities\Group;

use cmsgears\core\common\widgets\Editor;
use cmsgears\files\widgets\AvatarUploader;
use cmsgears\files\widgets\ImageUploader;
use cmsgears\files\widgets\VideoUploader;

use cmsgears\icons\widgets\IconChooser;
use cmsgears\icons\widgets\TextureChooser;

$coreProperties = $this->context->getCoreProperties();
$title			= $this->context->title;
$this->title 	= "Review $title | " . $coreProperties->getSiteTitle();
$returnUrl		= $this->context->returnUrl;
$apixBase		= $this->context->apixBase;

Editor::widget();
?>
<div class="box-crud-wrap">
	<div class="box-crud-wrap-main row row-large">
		<div class="filler-height filler-height-medium"></div>
		<?php if( $model->isSubmitted() || $model->isReSubmit() ) { ?>
			<h5>Review Group</h5> <hr />
			<?php $form = ActiveForm::begin( [ 'id' => 'frm-approval' ] ); ?>
			<?= $form->field( $model, 'name' )->hiddenInput()->label( false ) ?>
			<div class="align align-center">
				<?php if( $model->isSubmitted() ) { ?>
					<input type="radio" name="status" value="<?= Group::STATUS_SUBMITTED ?>" checked>Approve &nbsp;&nbsp;
				<?php } else { ?>
					<input type="radio" name="status" value="<?= Group::STATUS_ACTIVE ?>" checked>Approve &nbsp;&nbsp;
				<?php } ?>
				<input type="radio" name="status" value="<?= Group::STATUS_REJECTED ?>">Reject
			</div>
			<div class="filler-height"></div>
			<div class="content-80">
				<textarea name="message" placeholder="Add cause of rejection ..."></textarea>
			</div>
			<div class="clear filler-height"></div>
			<div class="align align-center">
				<?= Html::a( 'Back', $returnUrl, [ 'class' => 'btn btn-medium' ] ); ?>
				<input class="frm-element-medium" type="submit" value="Submit" />
			</div>
			<?php ActiveForm::end(); ?>
		<?php } else if( $model->isApprovable() ) { ?>
			<h5>Review Group</h5> <hr />
			<?php $form = ActiveForm::begin( [ 'id' => 'frm-approval' ] ); ?>
			<?= $form->field( $model, 'name' )->hiddenInput()->label( false ) ?>
			<div class="align align-center">
				<input type="radio" name="status" value="<?= Group::STATUS_ACTIVE ?>" checked>Approve
			</div>
			<div class="clear filler-height"></div>
			<div class="align align-center">
				<?= Html::a( 'Back', $returnUrl, [ 'class' => 'btn btn-medium' ] ); ?>
				<input class="frm-element-medium" type="submit" value="Submit" />
			</div>
			<?php ActiveForm::end(); ?>
		<?php } else if( $model->isActive() ) { ?>
			<?php $form = ActiveForm::begin( [ 'id' => 'frm-approval' ] ); ?>
			<?= $form->field( $model, 'name' )->hiddenInput()->label( false ) ?>
			<div class="align align-center">
				<input type="radio" name="status" value="<?= Group::STATUS_FROJEN ?>" checked>Freeze &nbsp;&nbsp;
				<input type="radio" name="status" value="<?= Group::STATUS_BLOCKED ?>">Block
			</div>
			<div class="filler-height"></div>
			<div class="content-80">
				<textarea name="message" placeholder="Add cause ..."></textarea>
			</div>
			<div class="clear filler-height"></div>
			<div class="align align-center">
				<?= Html::a( 'Back', $returnUrl, [ 'class' => 'btn btn-medium' ] ); ?>
				<input class="frm-element-medium" type="submit" value="Submit" />
			</div>
			<?php ActiveForm::end(); ?>
		<?php } else { ?>
			<div class="align align-center">
				<?= Html::a( 'Back', $returnUrl, [ 'class' => 'btn btn-medium' ] ); ?>
			</div>
		<?php } ?>
		<div class="filler-height filler-height-medium"></div>
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-group', 'options' => [ 'class' => 'form' ] ] ); ?>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Basic Details</div>
			</div>
			<div class="box-content-wrap frm-split-40-60">
				<div class="box-content">
					<div class="row">
						<div class="col col3">
							<?= $form->field( $model, 'name' )->textInput( [ 'readonly' => 'true' ] ) ?>
						</div>
						<div class="col col3">
							<?= $form->field( $model, 'slug' )->textInput( [ 'readonly' => 'true' ] ) ?>
						</div>
						<div class="col col3">
							<?= $form->field( $model, 'title' )->textInput( [ 'readonly' => 'true' ] ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $content, 'templateId' )->dropDownList( $templatesMap, [ 'class' => 'cmt-select', 'disabled' => true ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'description' )->textarea( [ 'readonly' => 'true' ] ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $model, 'status' )->dropDownList( $statusMap, [ 'class' => 'cmt-select', 'disabled' => true ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'visibility' )->dropDownList( $visibilityMap, [ 'class' => 'cmt-select', 'disabled' => true ] ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= IconChooser::widget( [ 'model' => $model, 'options' => [ 'class' => 'icon-picker-wrap', 'disabled' => true ] ] ) ?>
						</div>
						<div class="col col2">
							<?= TextureChooser::widget( [ 'model' => $model, 'options' => [ 'class' => 'icon-picker-wrap', 'disabled' => true ] ] ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col3">
							<?= Yii::$app->formDesigner->getIconCheckbox( $form, $model, 'reviews', [ 'disabled' => true ], 'cmti cmti-checkbox' ) ?>
						</div>
						<div class="col col3">
							<?= Yii::$app->formDesigner->getIconCheckbox( $form, $model, 'pinned', [ 'disabled' => true ], 'cmti cmti-checkbox' ) ?>
						</div>
						<div class="col col3">
							<?= Yii::$app->formDesigner->getIconCheckbox( $form, $model, 'featured', [ 'disabled' => true ], 'cmti cmti-checkbox' ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $model, 'email' )->textInput( [ 'readonly' => 'true' ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $model, 'order' )->textInput( [ 'readonly' => 'true' ] ) ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium"></div>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Files</div>
			</div>
			<div class="box-content">
				<div class="box-content">
					<div class="row padding padding-small-v">
						<div class="col col3">
							<label>Avatar</label>
							<?= AvatarUploader::widget( [ 'model' => $avatar, 'disabled' => 'true' ] ) ?>
						</div>
						<div class="col col3">
							<label>Banner</label>
							<?= ImageUploader::widget( [ 'model' => $banner, 'disabled' => 'true' ] ) ?>
						</div>
						<div class="col col3">
							<label>Video</label>
							<?= VideoUploader::widget( [ 'model' => $video, 'disabled' => 'true' ] ) ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium"></div>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Summary</div>
			</div>
			<div class="box-content-wysiwyg">
				<div class="box-content">
					<?= $form->field( $content, 'summary' )->textarea( [ 'class' => 'content-editor' ] )->label( false ) ?>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium"></div>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Content</div>
			</div>
			<div class="box-content-wysiwyg">
				<div class="box-content">
					<?= $form->field( $content, 'content' )->textarea( [ 'class' => 'content-editor' ] )->label( false ) ?>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium"></div>
		<div class="box box-crud">
			<div class="box-header">
				<div class="box-header-title">Page SEO</div>
			</div>
			<div class="box-content">
				<div class="box-content">
					<div class="row">
						<div class="col col2">
							<?= $form->field( $content, 'seoName' )->textInput( [ 'readOnly' => true ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $content, 'seoRobot' )->textInput( [ 'readOnly' => true ] ) ?>
						</div>
					</div>
					<div class="row">
						<div class="col col2">
							<?= $form->field( $content, 'seoKeywords' )->textarea( [ 'readOnly' => true ] ) ?>
						</div>
						<div class="col col2">
							<?= $form->field( $content, 'seoDescription' )->textarea( [ 'readOnly' => true ] ) ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="filler-height filler-height-medium"></div>
		<?php ActiveForm::end(); ?>
	</div>
</div>
