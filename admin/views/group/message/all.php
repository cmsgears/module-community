<?php
use \Yii;
use yii\helpers\Html; 
use yii\widgets\LinkPager;

use cmsgears\core\common\utilities\CodeGenUtil;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . " | Group Messages";

$gid			= $group->id;

// Sidebar
$this->params[ 'sidebar-parent' ] 	= $sidebar[ 'parent' ];
$this->params[ 'sidebar-child' ] 	= $sidebar[ 'child' ];

// Data
$pagination		= $dataProvider->getPagination();
$models			= $dataProvider->getModels();
?>
<div class="cud-box">
	<h2>Group Messages</h2>
	<form action="#" class="frm-split">
		<label>Name</label>
		<label><?= $group->name ?></label>		
	</form>
</div>
<div class="data-grid">
	<div class="grid-header">
		<?= LinkPager::widget( [ 'pagination' => $pagination ] ); ?>
	</div>
	<div class="wrap-grid">
		<table>
			<thead>
				<tr>
					<th>Avatar</th>
					<th>Username</th>
					<th>Name</th>
					<th>Email</th>
					<th>Content</th>
					<th>Created On</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php

					foreach( $models as $groupMessage ) {

						$id		= $groupMessage->id;
						$user 	= $groupMessage->member->user;
				?>
					<tr>
						<td><?= CodeGenUtil::getImageThumbTag( $user->avatar, [ 'class' => 'avatar', 'image' => 'avatar' ] ) ?></td>
						<td><?= $user->username ?></td>
						<td><?= $user->name ?></td>
						<td><?= $user->email ?></td>
						<td><?= $groupMessage->content ?></td>
						<td><?= $groupMessage->createdAt ?></td>
						<td>
							<span class="wrap-icon-action" title="Delete Group Message"><?= Html::a( "", ["/cmgcmn/group/message/delete?gid=$gid&id=$id"], ['class'=>'icon-action icon-action-delete'] )  ?></span>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="grid-footer">
		<div class="text"> <?=CodeGenUtil::getPaginationDetail( $dataProvider ) ?> </div>
		<?= LinkPager::widget( [ 'pagination' => $pagination ] ); ?>
	</div>
</div>