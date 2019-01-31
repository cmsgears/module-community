<?php
use yii\helpers\Html;

$parent = isset( $widget->data[ 'parent' ] ) ? $widget->data[ 'parent' ] : null;
$updUrl	= isset( $parent ) ? "update?id=$model->id&pid=$parent->id" : "update?id=$model->id";
?>
<span title="Update"><?= Html::a( "", [ $updUrl ], [ 'class' => 'cmti cmti-edit' ] )  ?></span>

<?php if( $model->isBelowRejected() ) { ?>
	<span class="action action-pop action-approve cmti cmti-user-executive" title="Approve" target="<?= $model->id ?>" popup="popup-grid-approve"></span>
<?php } else if( $model->isActive() ) { ?>
	<span class="action action-pop action-block cmti cmti-ban" title="Block" target="<?= $model->id ?>" popup="popup-grid-block"></span>
<?php } else if( $model->isBlocked() ) { ?>
	<span class="action action-pop action-activate cmti cmti-check" title="Activate" target="<?= $model->id ?>" popup="popup-grid-activate"></span>
<?php } ?>

<?php if( !$model->isTerminated() ) { ?>
	<span class="action action-pop action-terminate cmti cmti-close-c-o" title="Terminate" target="<?= $model->id ?>" popup="popup-grid-terminate"></span>
<?php } ?>

<span class="action action-pop action-delete cmti cmti-close-c" title="Delete" target="<?= $model->id ?>" popup="popup-grid-delete"></span>
