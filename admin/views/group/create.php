<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use cmsgears\core\widgets\Editor;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Add Group';

Editor::widget( [ 'selector' => '.content-editor' ] );
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Add Group</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-group-create', 'options' => ['class' => 'frm-split' ] ] );?>

    	<?= $form->field( $model, 'name' ) ?>
    	<?= $form->field( $model, 'description' )->textarea() ?>
    	<?= $form->field( $model, 'status' )->dropDownList( $status ) ?>    	
    	<?= $form->field( $model, 'visibility' )->dropDownList( $visibilities ) ?>

    	<h4>Group Content</h4>
    	<?= $form->field( $model, 'content' )->textarea( [ 'class' => 'content-editor' ] ) ?>

    	<h4>Group Avatar</h4>
		<div id="file-avatar" class="file-container" legend="Group Avatar" selector="avatar" utype="image" btn-class="btn file-input-wrap" btn-text="Choose Avatar">
			<div class="file-fields">
				<input type="hidden" name="Avatar[name]" class="file-name" value="<?php if( isset( $avatar ) ) echo $avatar->name; ?>" />
				<input type="hidden" name="Avatar[extension]" class="file-extension" value="<?php if( isset( $avatar ) ) echo $avatar->extension; ?>" />
				<input type="hidden" name="Avatar[directory]" value="avatar" value="<?php if( isset( $avatar ) ) echo $avatar->directory; ?>" />
				<input type="hidden" name="Avatar[changed]" class="file-change" value="<?php if( isset( $avatar ) ) echo $avatar->changed; ?>" />
			</div>
		</div>

    	<h4>Group Banner</h4>
		<div id="file-banner" class="file-container" legend="Group Banner" selector="banner" utype="image" btn-class="btn file-input-wrap" btn-text="Choose Banner">
			<div class="file-fields">
				<input type="hidden" name="Banner[name]" class="file-name" value="<?php if( isset( $banner ) ) echo $banner->name; ?>" />
				<input type="hidden" name="Banner[extension]" class="file-extension" value="<?php if( isset( $banner ) ) echo $banner->extension; ?>" />
				<input type="hidden" name="Banner[directory]" value="banner" value="<?php if( isset( $banner ) ) echo $banner->directory; ?>" />
				<input type="hidden" name="Banner[changed]" class="file-change" value="<?php if( isset( $banner ) ) echo $banner->changed; ?>" />
				<label>Banner Description</label> <input type="text" name="Banner[description]" value="<?php if( isset( $banner ) ) echo $banner->description; ?>" />
				<label>Banner Alternate Text</label> <input type="text" name="Banner[altText]" value="<?php if( isset( $banner ) ) echo $banner->altText; ?>" />
			</div>
		</div>

		<h4>Assign Categories</h4>
		<?php foreach ( $categories as $category ) { ?>
			<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$category['id']?>" /><?=$category['name']?></span>
		<?php } ?>

		<div class="box-filler"></div>

		<?=Html::a( "Cancel", [ '/cmgcmn/group/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Create" />

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
		jQuery("#file-banner .file-image").html( "<img src='<?php echo $banner->getFileUrl(); ?>' />'" );
	<?php } ?>
</script>