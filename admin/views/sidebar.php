<?php
// Yii Imports
use \Yii;
use yii\helpers\Html;
use yii\helpers\Url;

$core	= Yii::$app->core;
$user	= Yii::$app->user->getIdentity();
?>

<?php if( Yii::$app->cmgCore->hasModule( 'cmgcmn' ) && $user->isPermitted( 'community' ) ) { ?>
	<div id="sidebar-group" class="collapsible-tab has-children <?php if( strcmp( $parent, 'sidebar-group' ) == 0 ) echo 'active';?>">
		<div class="collapsible-tab-header clearfix">
			<div class="colf colf4"><span class="icon-sidebar icon-newsletter"></span></div>
			<div class="colf colf4x3">Community</div>
		</div>
		<div class="collapsible-tab-content clear <?php if( strcmp( $parent, 'sidebar-group' ) == 0 ) echo 'expanded visible';?>">
			<ul>
				<li class='matrix <?php if( strcmp( $child, 'matrix' ) == 0 ) echo 'active';?>'><?= Html::a( "Groups Matrix", ['/cmgcmn/group/matrix'] ) ?></li>
				<li class='category <?php if( strcmp( $child, 'category' ) == 0 ) echo 'active';?>'><?= Html::a( "Group Categories", ['/cmgcmn/group/category/all'] ) ?></li>
				<li class='group <?php if( strcmp( $child, 'group' ) == 0 ) echo 'active';?>'><?= Html::a( "Groups", ['/cmgcmn/group/all'] ) ?></li>
				<!--<li class='message <?php if( strcmp( $child, 'message' ) == 0 ) echo 'active';?>'><?= Html::a( "Messages", ['/cmgcmn/message/all'] ) ?></li>-->
			</ul>
		</div>
	</div>
<?php } ?>