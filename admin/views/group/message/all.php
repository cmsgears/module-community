<?php
use \Yii;
use yii\helpers\Html; 
use yii\widgets\LinkPager;

use cmsgears\modules\core\common\utilities\CodeGenUtil;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . " | Group Messages";

$gid			= $group->getId();
?>
<div class="cud-box">
	<h2>Group Messages</h2>
	<form action="#" class="frm-split">
		<label>Name</label>
		<label><?= $group->getName() ?></label>
		<label>Description</label>
		<label><?= $group->getDesc() ?></label>			
	</form>
</div>
<div class="data-grid">
	<div class="grid-header">
		<?= LinkPager::widget( [ 'pagination' => $pages ] ); ?>
	</div>
	<div class="wrap-grid">
		<table>
			<thead>
				<tr>
					<th> <input type='checkbox' /> </th>
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

					foreach( $page as $groupMessage ) {

						$id		= $groupMessage->getId();
						$user 	= $groupMessage->owner;
				?>
					<tr>
						<td> <input type='checkbox' /> </td>
						<td> 
							<?php
								$avatar = $user->avatar;

								if( isset( $avatar ) ) { 
							?> 
								<img class="avatar" src="<?=$coreProperties->getUploadUrl()?><?= $avatar->getThumb() ?>">
							<?php 
								} else { 
							?>
								<img class="avatar" src="<?=Yii::getAlias('@web')?>/assets/images/avatar.png">
							<?php } ?>
						</td>
						<td><?= $user->getUsername() ?></td>
						<td><?= $user->getName() ?></td>
						<td><?= $user->getEmail() ?></td>
						<td><?= $groupMessage->getContent() ?></td>
						<td><?= $groupMessage->getCreatedOn() ?></td>
						<td>
							<span class="wrap-icon-action" title="Delete Group Message"><?= Html::a( "", ["/cmgcommunity/group/delete-message?gid=$gid&id=$id"], ['class'=>'icon-action icon-action-delete'] )  ?></span>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="grid-footer">
		<div class="text"> <?=CodeGenUtil::getPaginationDetail( $pages, $page, $total ) ?> </div>
		<?= LinkPager::widget( [ 'pagination' => $pages ] ); ?>
	</div>
</div>
<script type="text/javascript">
	initSidebar( "sidebar-group", -1 );
</script>