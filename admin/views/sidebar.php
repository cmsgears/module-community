<?php
// Yii Imports
use yii\helpers\Html;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

$core	= Yii::$app->core;
$user	= $core->getUser();
?>
<?php if( $core->hasModule( 'community' ) && $user->isPermitted( CmnGlobal::PERM_COMMUNITY_ADMIN ) ) { ?>
	<div id="sidebar-community" class="collapsible-tab has-children <?= $parent === 'sidebar-community' ? 'active' : null ?>">
		<span class="marker"></span>
		<div class="tab-header">
			<div class="tab-icon"><span class="cmti cmti-groups"></span></div>
			<div class="tab-title">Community</div>
		</div>
		<div class="tab-content clear <?= $parent === 'sidebar-community' ? 'expanded visible' : null ?>">
			<ul>
				<?php if( $user->isPermitted( CmnGlobal::PERM_GROUP_ADMIN ) ) { ?>
					<?php if( $user->isPermitted( CoreGlobal::PERM_RBAC ) ) { ?>
						<li class="role <?= $child === 'role' ? 'active' : null ?>"><?= Html::a( "Roles", ['/community/role/all'] ) ?></li>
						<li class="permission <?= $child === 'permission' ? 'active' : null ?>"><?= Html::a( "Permissions", ['/community/permission/all'] ) ?></li>
					<?php } ?>
					<li class="user <?= $child === 'user' ? 'active' : null ?>"><?= Html::a( "Users", ['/community/user/all'] ) ?></li>
					<li class="group <?= $child === 'group' ? 'active' : null ?>"><?= Html::a( "Groups", ['/community/group/all'] ) ?></li>
					<li class="group-category <?= $child === 'group-category' ? 'active' : null ?>"><?= Html::a( "Group Categories", ['/community/group/category/all'] ) ?></li>
					<li class="group-tag <?= $child === 'group-tag' ? 'active' : null ?>"><?= Html::a( "Group Tags", ['/community/group/tag/all'] ) ?></li>
					<li class="group-reviews <?= $child === 'group-reviews' ? 'active' : null ?>"><?= Html::a( "Group Reviews", ['/community/group/review/all'] ) ?></li>
					<li class="group-template <?= $child === 'group-template' ? 'active' : null ?>"><?= Html::a( "Group Templates", ['/community/group/template/all'] ) ?></li>
					<li class="user-post-template <?= $child === 'user-post-template' ? 'active' : null ?>"><?= Html::a( "User Post Templates", ['/community/user/post/template/all'] ) ?></li>
					<li class="group-post-template <?= $child === 'group-post-template' ? 'active' : null ?>"><?= Html::a( "Group Post Templates", ['/community/group/post/template/all'] ) ?></li>
				<?php } ?>
				<?php if( $user->isPermitted( CmnGlobal::PERM_CHAT_ADMIN ) ) { ?>
					<li class="chat <?= $child === 'chat' ? 'active' : null ?>"><?= Html::a( "Chat Sessions", ['/community/chat/all'] ) ?></li>
				<?php } ?>
			</ul>
		</div>
	</div>
<?php } ?>
