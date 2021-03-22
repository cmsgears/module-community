<?php
use yii\helpers\Html;

$baseUrl	= isset( $widget->data[ 'baseUrl' ] ) ? $widget->data[ 'baseUrl' ] : 'group/post';
$parent		= isset( $widget->data[ 'parent' ] ) ? $widget->data[ 'parent' ] : null;
$updUrl		= isset( $parent ) ? "update?id=$model->id&pid=$parent->id" : "update?id=$model->id";
?>
<span title="Attributes"><?= Html::a( "", [ "$baseUrl/attribute/all?pid=$model->id" ], [ 'class' => 'cmti cmti-tag' ] ) ?></span>
<span title="Gallery"><?= Html::a( "", [ "gallery?id=$model->id" ], [ 'class' => 'cmti cmti-image' ] ) ?></span>
<span title="Update"><?= Html::a( "", [ $updUrl ], [ 'class' => 'cmti cmti-edit' ] )  ?></span>

<?php if( $model->isBelowRejected() ) { ?>
	<span class="action action-pop action-approve cmti cmti-thumbs-up" title="Approve" target="<?= $model->id ?>" popup="popup-grid-approve"></span>
<?php } else if( $model->isActive() ) { ?>
	<span class="action action-pop action-block cmti cmti-ban" title="Block" target="<?= $model->id ?>" popup="popup-grid-block"></span>
<?php } else if( $model->isBlocked() ) { ?>
	<span class="action action-pop action-activate cmti cmti-check" title="Activate" target="<?= $model->id ?>" popup="popup-grid-activate"></span>
<?php } ?>

<span class="action action-pop action-delete cmti cmti-close-c" title="Delete" target="<?= $model->id ?>" popup="popup-grid-delete"></span>
