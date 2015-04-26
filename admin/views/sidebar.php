<?php
// Yii Imports
use \Yii;
use yii\helpers\Html;
use yii\helpers\Url;

$core	= Yii::$app->cmgCore;
$user	= Yii::$app->user->getIdentity();
?>

<?php if( Yii::$app->cmgCore->hasModule( 'cmgcmn' ) && $user->isPermitted( 'community' ) ) { ?>
	<div class="collapsible-tab has-children" id="sidebar-group">
		<div class="collapsible-tab-header clearfix">
			<div class="colf colf4"><span class="icon-sidebar icon-newsletter"></span></div>
			<div class="colf colf4x3">Community</div>
		</div>
		<div class="collapsible-tab-content clear">
			<ul>
				<li><?= Html::a( "Groups Matrix", ['/cmgcmn/group/matrix'] ) ?></li>
				<li><?= Html::a( "Group Categories", ['/cmgcmn/group/categories'] ) ?></li>
				<li><?= Html::a( "Groups", ['/cmgcmn/group/all'] ) ?></li>
				<li><?= Html::a( "Messages", ['/cmgcmn/message/all'] ) ?></li>
			</ul>
		</div>
	</div>
<?php } ?>