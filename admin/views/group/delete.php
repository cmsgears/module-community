<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use cmsgears\core\widgets\Editor;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Delete Group';

Editor::widget( [ 'selector' => '.content-editor' ] );
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Delete Group</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-group-update', 'options' => ['class' => 'frm-split' ] ] );?>

    	<?= $form->field( $model, 'name' )->textInput( [ 'readonly'=>'true' ] ) ?>
    	<?= $form->field( $model, 'description' )->textarea( [ 'readonly'=>'true' ] ) ?>
    	<?= $form->field( $model, 'status' )->dropDownList( $status, [ 'disabled'=>'true' ] ) ?>    	
    	<?= $form->field( $model, 'visibility' )->dropDownList( $visibilities, [ 'disabled'=>'true' ] ) ?>

    	<h4>Group Content</h4>
    	<?= $form->field( $model, 'content' )->textarea( [ 'class' => 'content-editor', 'readonly' => 'true' ] ) ?>

    	<h4>Group Avatar</h4>
		<div id="file-avatar" class="file-container" legend="Group Avatar" selector="avatar" utype="image" btn-class="btn file-input-wrap" btn-text="Choose Avatar"></div>

    	<h4>Group Banner</h4>
		<div id="file-banner" class="file-container" legend="Group Banner" selector="banner" utype="image" btn-class="btn file-input-wrap" btn-text="Choose Banner"></div>

		<h4>Assign Categories</h4>
		<?php 
			$groupCategories	= $model->getCategoriesIdList();

			foreach ( $categories as $category ) { 

				if( in_array( $category['id'], $groupCategories ) ) {
		?>		
					<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$category['id']?>" checked disabled="true" /><?=$category['name']?></span>
		<?php 
				}
				else {
		?>
					<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$category['id']?>" disabled="true" /><?=$category['name']?></span>
		<?php
				}
			}
		?>	

		<div class="box-filler"></div>

		<?=Html::a( "Back", [ '/cmgcommunity/group/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Delete" />

		<?php ActiveForm::end(); ?>
	</div>
</section>

<script type="text/javascript">
	initSidebar( "sidebar-group", 2 );
	initFileUploader();

	<?php if( isset( $avatar ) ) { ?>
		jQuery("#file-avatar .file-image").html( "<img src='<?php echo $avatar->getFileUrl(); ?>' />'" );
	<?php } ?>

	<?php if( isset( $banner ) ) { ?>
		jQuery("#file-banner .file-image").html( "<img src='<?php $banner->getFileUrl(); ?>' />'" );
	<?php } ?>

	jQuery( ".file-input").attr( "disabled", "true" );
</script>