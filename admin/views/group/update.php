<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Update Group';
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Update Group</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-group-update', 'options' => ['class' => 'frm-split' ] ] );?>

    	<?= $form->field( $model, 'group_name' ) ?>
    	<?= $form->field( $model, 'group_desc' )->textarea() ?>
    	<?= $form->field( $model, 'group_status' )->dropDownList( $status ) ?>    	
    	<?= $form->field( $model, 'group_visibility' )->dropDownList( $visibilities ) ?>

    	<h4>Group Avatar</h4>
		<div id="file-avatar" class="file-container" legend="Group Avatar" selector="avatar" utype="image" btn-class="btn file-input-wrap" btn-text="Choose Avatar">
			<div class="file-fields">
				<input type="hidden" name="Avatar[file_id]" value="<?php if( isset( $avatar ) ) echo $avatar->getId(); ?>" />
				<input type="hidden" name="Avatar[file_name]" class="file-name" value="<?php if( isset( $avatar ) ) echo $avatar->getName(); ?>" />
				<input type="hidden" name="Avatar[file_extension]" class="file-extension" value="<?php if( isset( $avatar ) ) echo $avatar->getExtension(); ?>" />
				<input type="hidden" name="Avatar[file_directory]" value="avatar" value="<?php if( isset( $avatar ) ) echo $avatar->getDirectory(); ?>" />
				<input type="hidden" name="Avatar[changed]" class="file-change" value="<?php if( isset( $avatar ) ) echo $avatar->changed; ?>" />
			</div>
		</div>

    	<h4>Group Banner</h4>
		<div id="file-banner" class="file-container" legend="Group Banner" selector="banner" utype="image" btn-class="btn file-input-wrap" btn-text="Choose Banner">
			<div class="file-fields">
				<input type="hidden" name="Banner[file_id]" value="<?php if( isset( $banner ) ) echo $banner->getId(); ?>" />
				<input type="hidden" name="Banner[file_name]" class="file-name" value="<?php if( isset( $banner ) ) echo $banner->getName(); ?>" />
				<input type="hidden" name="Banner[file_extension]" class="file-extension" value="<?php if( isset( $banner ) ) echo $banner->getExtension(); ?>" />
				<input type="hidden" name="Banner[file_directory]" value="banner" value="<?php if( isset( $banner ) ) echo $banner->getDirectory(); ?>" />
				<input type="hidden" name="Banner[changed]" class="file-change" value="<?php if( isset( $banner ) ) echo $banner->changed; ?>" />
				<label>Banner Description</label> <input type="text" name="Banner[file_desc]" value="<?php if( isset( $banner ) ) echo $banner->getDesc(); ?>" />
				<label>Banner Alternate Text</label> <input type="text" name="Banner[file_alt_text]" value="<?php if( isset( $banner ) ) echo $banner->getAltText(); ?>" />
			</div>
		</div>

		<h4>Assign Categories</h4>
		<?php 
			$groupCategories	= $model->getCategoriesIdList();

			foreach ( $categories as $category ) { 

				if( in_array( $category['id'], $groupCategories ) ) {
		?>		
					<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$category['id']?>" checked /><?=$category['name']?></span>
		<?php 
				}
				else {
		?>
					<span class="box-half"><input type="checkbox" name="Binder[bindedData][]" value="<?=$category['id']?>" /><?=$category['name']?></span>
		<?php
				}
			}
		?>	

		<div class="box-filler"></div>

		<?=Html::a( "Back", [ '/cmgcommunity/group/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Update" />

		<?php ActiveForm::end(); ?>
	</div>
</section>

<script type="text/javascript">
	initSidebar( "sidebar-group", 2 );
	initFileUploader();

	<?php if( isset( $avatar ) ) { ?>
		jQuery("#file-avatar .file-image").html( "<img src='<?php echo Yii::$app->fileManager->uploadUrl . $avatar->getDisplayUrl(); ?>' />'" );
	<?php } ?>

	<?php if( isset( $banner ) ) { ?>
		jQuery("#file-banner .file-image").html( "<img src='<?php echo Yii::$app->fileManager->uploadUrl . $banner->getDisplayUrl(); ?>' />'" );
	<?php } ?>
</script>