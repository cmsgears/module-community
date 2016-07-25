<?php
// Yii Imports
use yii\helpers\Html;
use yii\helpers\Url;

$core	= Yii::$app->core;
$user	= Yii::$app->user->getIdentity();
?>

<?php if( Yii::$app->core->hasModule( 'community' ) && $user->isPermitted( 'community' ) ) { ?>

	<div id="sidebar-community" class="collapsible-tab has-children <?php if( strcmp( $parent, 'sidebar-community' ) == 0 ) echo 'active'; ?>">
		<div class="collapsible-tab-header clearfix">
			<div class="colf colf5 wrap-icon"><span class="cmti cmti-chart-column"></span></div>
			<div class="colf colf4x3">Community</div>
		</div>
		<div class="collapsible-tab-content clear <?php if( strcmp( $parent, 'sidebar-community' ) == 0 ) echo 'expanded visible'; ?>">
			<ul>
				<li class='role <?php if( strcmp( $child, 'group-role' ) == 0 ) echo 'active'; ?>'><?= Html::a( "Roles", ['/community/role/all'] ) ?></li>
				<li class='permission <?php if( strcmp( $child, 'group-permission' ) == 0 ) echo 'active'; ?>'><?= Html::a( "Permissions", ['/community/permission/all'] ) ?></li>
				<li class='group <?php if( strcmp( $child, 'group' ) == 0 ) echo 'active'; ?>'><?= Html::a( "Groups", ['/community/group/all'] ) ?></li>
				<li class='group-template <?php if( strcmp( $child, 'group-template' ) == 0 ) echo 'active'; ?>'><?= Html::a( "Group Templates", ['/community/group/template/all'] ) ?></li>
				<li class='group-category <?php if( strcmp( $child, 'group-category' ) == 0 ) echo 'active'; ?>'><?= Html::a( "Group Categories", ['/community/group/category/all'] ) ?></li>
				<li class='group-tag <?php if( strcmp( $child, 'group-tag' ) == 0 ) echo 'active'; ?>'><?= Html::a( "Group Tags", ['/community/group/tag/all'] ) ?></li>
				<!--<li class='message <?php if( strcmp( $child, 'message' ) == 0 ) echo 'active';?>'><?= Html::a( "Messages", ['/cmgcmn/message/all'] ) ?></li>-->
			</ul>
		</div>
	</div>
<?php } ?>