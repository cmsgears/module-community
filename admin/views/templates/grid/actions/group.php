<?php

// Yii Imports
use yii\helpers\Html;
?>
<span title="Members"><?= Html::a( "", [ "group/member/all?id=$model->id" ], [ 'class' => 'cmti cmti-user' ] )  ?></span>
<span title="Messages"><?= Html::a( "", [ "group/message/all?id=$model->id" ], [ 'class' => 'cmti cmti-comment' ] )  ?></span>
<span title="Update"><?= Html::a( "", [ "update?id=$model->id" ], [ 'class' => 'cmti cmti-edit' ] )  ?></span>
<span title="Delete"><?= Html::a( "", [ "delete?id=$model->id" ], [ 'class' => 'cmti cmti-close-c-o' ] )  ?></span>