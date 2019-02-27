<?php
use yii\helpers\Html;

$parent = isset( $widget->data[ 'parent' ] ) ? $widget->data[ 'parent' ] : null;
$updUrl	= isset( $parent ) ? "update?id=$model->id&pid=$parent->id" : "update?id=$model->id";
?>

<span title="Update"><?= Html::a( "", [ $updUrl ], [ 'class' => 'cmti cmti-edit' ] )  ?></span>

<span class="action action-pop action-delete cmti cmti-close-c" title="Delete" target="<?= $model->id ?>" popup="popup-grid-delete"></span>
