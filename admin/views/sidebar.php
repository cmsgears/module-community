<?php
// Yii Imports
use yii\helpers\Html;
use yii\helpers\Url;

// CMG Imports
use cmsgears\community\common\config\CmnGlobal;

$core	= Yii::$app->core;
$user	= Yii::$app->user->getIdentity();
?>

<?php if( $core->hasModule( 'core' ) && $user->isPermitted( CmnGlobal::PERM_COMMUNITY) ) { ?>
	<div id="sidebar-community" class="collapsible-tab has-children <?php if( strcmp( $parent, 'sidebar-community' ) == 0 ) echo 'active'; ?>">
		<span class="marker"></span>
		<div class="tab-header">
			<div class="tab-icon"><span class="cmti cmti-groups"></span></div>
			<div class="tab-title">Community</div>
		</div>
		<div class="tab-content clear <?php if( strcmp( $parent, 'sidebar-community' ) == 0 ) echo 'expanded visible'; ?>">
			<ul>
				<?php if( $user->isPermitted( CmnGlobal::PERM_GROUP ) ) { ?>
					<li class='role <?php if( strcmp( $child, 'role' ) == 0 ) echo 'active';?>'><?= Html::a( "Roles", ['/community/role/all'] ) ?></li>
					<li class='permission <?php if( strcmp( $child, 'permission' ) == 0 ) echo 'active';?>'><?= Html::a( "Permissions", ['/community/permission/all'] ) ?></li>
					<li class='group <?php if( strcmp( $child, 'group' ) == 0 ) echo 'active'; ?>'><?= Html::a( "Groups", ['/community/group/all'] ) ?></li>
					<li class='group-template <?php if( strcmp( $child, 'group-template' ) == 0 ) echo 'active'; ?>'><?= Html::a( "Group Templates", ['/community/group/template/all'] ) ?></li>
					<li class='group-category <?php if( strcmp( $child, 'group-category' ) == 0 ) echo 'active'; ?>'><?= Html::a( "Group Categories", ['/community/group/category/all'] ) ?></li>
					<li class='group-tag <?php if( strcmp( $child, 'group-tag' ) == 0 ) echo 'active'; ?>'><?= Html::a( "Group Tags", ['/community/group/tag/all'] ) ?></li>
				<?php } ?>
				<?php if( $user->isPermitted( CmnGlobal::PERM_CHAT ) ) { ?>
					<!--<li class='message <?php if( strcmp( $child, 'message' ) == 0 ) echo 'active';?>'><?= Html::a( "Messages", ['/cmgcmn/message/all'] ) ?></li>-->
				<?php } ?>
			</ul>
		</div>
	</div>
<?php } ?>