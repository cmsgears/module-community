<?php
use \Yii;
use yii\helpers\Html; 
use yii\widgets\LinkPager;

use cmsgears\core\common\utilities\CodeGenUtil;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . " | Group Members";

$gid			= $group->id;

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-group';
$this->params['sidebar-child'] 	= 'group';

// Data
$pagination		= $dataProvider->getPagination();
$models			= $dataProvider->getModels();
?>
<div class="cud-box">
	<h2>Group Members</h2>
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
					<th>Role</th>
					<th>Status</th>
					<th>Joined On</th>
					<th>Refreshed On</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php

					foreach( $models as $groupMember ) {
						
						$id		= $groupMember->id;
						$user 	= $groupMember->user;
						$role	= $groupMember->role;
				?>
					<tr>
						<td> 
							<?php
								$avatar = $user->avatar;

								if( isset( $avatar ) ) { 
							?> 
								<img class="avatar" src="<?= $avatar->getThumbUrl() ?>">
							<?php 
								} else { 
							?>
								<img class="avatar" src="<?=Yii::getAlias('@web')?>/assets/images/avatar.png">
							<?php } ?>
						</td>
						<td><?= $user->username ?></td>
						<td><?= $user->getName() ?></td>
						<td><?= $user->email ?></td>
						<td><?= $role->name ?></td>
						<td><?= $groupMember->getStatusStr() ?></td>
						<td><?= $groupMember->createdAt ?></td>
						<td><?= $groupMember->syncedAt ?></td>
						<td>
							<span class="wrap-icon-action" title="Delete Group Member"><?= Html::a( "", ["/cmgcmn/group/delete-member?gid=$gid&id=$id"], ['class'=>'icon-action icon-action-delete'] )  ?></span>
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