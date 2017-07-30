<?php

// Yii Imports
use yii\helpers\Html;
?>

<span title="Comments"><?= Html::a( "", [ "comment/all?pid=$model->id" ], [ 'class' => 'cmti cmti-comment' ] ) ?></span>
<span title="Update"><?= Html::a( "", [ "update?id=$model->id" ], [ 'class' => 'cmti cmti-edit' ] )  ?></span>
<span title="Gallery"><?= Html::a( "", [ "post/gallery/items?postId=$model->galleryId" ], [ 'class' => 'cmti cmti-image' ] ) ?></span>
<span title="Delete"><?= Html::a( "", [ "delete?id=$model->id" ], [ 'class' => 'cmti cmti-close-c-o' ] )  ?></span>
