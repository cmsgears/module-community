<?php
use yii\helpers\Html;

$parent = isset( $widget->data[ 'parent' ] ) ? $widget->data[ 'parent' ] : null;
$updUrl	= isset( $parent ) ? "update?id=$model->id&pid=$parent->id" : "update?id=$model->id";
?>
<span title="Update"><?= Html::a( "", [ $updUrl ], [ 'class' => 'cmti cmti-edit' ] )  ?></span>

<?php if( $model->isActive() ) { ?>
	<span class="action action-pop action-block cmti cmti-ban" title="Block" target="<?= $model->id ?>" popup="popup-grid-block"></span>
<?php } else if( $model->isNew() || $model->isBlocked() ) { ?>
	<span class="action action-pop action-activate cmti cmti-check" title="Activate" target="<?= $model->id ?>" popup="popup-grid-activate"></span>
<?php } ?>

<span class="action action-pop action-delete cmti cmti-close-c" title="Delete" target="<?= $model->id ?>" popup="popup-grid-delete"></span>
