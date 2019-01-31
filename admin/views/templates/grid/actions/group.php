<?php
use yii\helpers\Html;

$modelContent	= $model->modelContent;
$template		= $modelContent->template;
?>
<span title="Members"><?= Html::a( "", [ "group/member/all?pid=$model->id" ], [ 'class' => 'cmti cmti-user' ] )  ?></span>
<span title="Posts"><?= Html::a( "", [ "group/post/all?pid=$model->id" ], [ 'class' => 'cmti cmti-envelope-o' ] )  ?></span>
<span title="Messages"><?= Html::a( "", [ "group/message/all?pid=$model->id" ], [ 'class' => 'cmti cmti-envelope' ] )  ?></span>
<span title="Reviews"><?= Html::a( "", [ "group/review/all?pid=$model->id" ], [ 'class' => 'cmti cmti-comment' ] ) ?></span>
<span title="Files"><?= Html::a( "", [ "group/file/all?pid=$model->id" ], [ 'class' => 'cmti cmti-file' ] ) ?></span>
<span title="Attributes"><?= Html::a( "", [ "group/attribute/all?pid=$model->id" ], [ 'class' => 'cmti cmti-tag' ] ) ?></span>
<span title="Gallery"><?= Html::a( "", [ "group/gallery?id=$model->id" ], [ 'class' => 'cmti cmti-image' ] ) ?></span>
<span title="Update"><?= Html::a( "", [ "update?id=$model->id" ], [ 'class' => 'cmti cmti-edit' ] )  ?></span>
<span title="Review"><?= Html::a( "", [ "review?id=$model->id" ], [ 'class' => 'cmti cmti-eye' ] )  ?></span>

<?php if( isset( $template ) ) { ?>
	<?php if( !empty( $template->dataForm ) ) { ?>
		<span title="Data"><?= Html::a( "", [ "data?id=$model->id" ], [ 'class' => 'cmti cmti-briefcase' ] ) ?></span>
	<?php } ?>
	<?php if( !empty( $template->configForm ) ) { ?>
		<span title="Config"><?= Html::a( "", [ "config?id=$model->id" ], [ 'class' => 'cmti cmti-setting-o' ] ) ?></span>
	<?php } ?>
	<?php if( !empty( $template->settingsForm ) ) { ?>
		<span title="Settings"><?= Html::a( "", [ "settings?id=$model->id" ], [ 'class' => 'cmti cmti-setting' ] ) ?></span>
	<?php } ?>
<?php } ?>

<span class="action action-pop action-delete cmti cmti-bin" title="Delete" target="<?= $model->id ?>" popup="popup-grid-delete"></span>
