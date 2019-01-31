<?php
use yii\helpers\Html;
?>
<span title="Posts"><?= Html::a( "", [ "user/post/all?pid=$model->id" ], [ 'class' => 'cmti cmti-envelope-o' ] )  ?></span>
<span title="Gallery"><?= Html::a( "", [ "user/gallery?id=$model->id" ], [ 'class' => 'cmti cmti-image' ] ) ?></span>
<span title="Update"><?= Html::a( "", [ "update?id=$model->id" ], [ 'class' => 'cmti cmti-edit' ] )  ?></span>

<span class="action action-pop action-delete cmti cmti-bin" title="Delete" target="<?= $model->id ?>" popup="popup-grid-delete"></span>
