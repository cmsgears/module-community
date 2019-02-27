<?php
// CMG Imports
use cmsgears\widgets\popup\Popup;

use cmsgears\widgets\grid\DataGrid;

$coreProperties = $this->context->getCoreProperties();
$this->title	= 'Chat Messages | ' . $coreProperties->getSiteTitle();
$apixBase		= $this->context->apixBase;

// View Templates
$moduleTemplates	= '@cmsgears/module-community/admin/views/templates';
$themeTemplates		= '@themes/admin/views/templates';
?>
<?= DataGrid::widget([
	'dataProvider' => $dataProvider, 'add' => true, 'addUrl' => "create?pid=$parent->id", 'data' => [ 'parent' => $parent ],
	'title' => 'Groups', 'options' => [ 'class' => 'grid-data grid-data-admin' ],
	'searchColumns' => [ 'content' => 'Content' ],
	'sortColumns' => [
		'sender' => 'Sender', 'sent' => 'Sent', 'delivered' => 'Delivered',
		'consumed' => 'Consumed', 'cdate' => 'Created At', 'udate' => 'Updated At'
	],
	'filters' => [
		'model' => [ 'sent' => 'Sent', 'delivered' => 'Delivered', 'consumed' => 'Consumed' ]
	],
	'reportColumns' => [
		'content' => [ 'title' => 'Content', 'type' => 'text' ],
		'sent' => [ 'title' => 'Sent', 'type' => 'flag' ],
		'delivered' => [ 'title' => 'Delivered', 'type' => 'flag' ],
		'consumed' => [ 'title' => 'Consumed', 'type' => 'flag' ]
	],
	'bulkPopup' => 'popup-grid-bulk', 'bulkActions' => [
		'model' => [ 'sent' => 'Sent', 'delivered' => 'Delivered', 'consumed' => 'Consumed', 'delete' => 'Delete' ]
	],
	'header' => false, 'footer' => true,
	'grid' => true, 'columns' => [ 'root' => 'colf colf15', 'factor' => [ null, null, 'x2', null, null, null, 'x6', 'x2' ] ],
	'gridColumns' => [
		'bulk' => 'Action',
		'icon' => [ 'title' => 'Icon', 'generate' => function( $model ) {
			$icon = "<div class=\"align align-center\"><i class=\"$model->icon\"></i></div>" ; return $icon;
		}],
		'sender' => [ 'title' => 'Sender', 'generate' => function( $model ) { return $model->sender->name; } ],
		'sent' => [ 'title' => 'Sent', 'generate' => function( $model ) { return $model->getSentStr(); } ],
		'delivered' => [ 'title' => 'Delivered', 'generate' => function( $model ) { return $model->getDeliveredStr(); } ],
		'consumed' => [ 'title' => 'Consumed', 'generate' => function( $model ) { return $model->getConsumedStr(); } ],
		'message' => [ 'title' => 'Message', 'generate' => function( $model ) { return $model->getMediumContent(); } ],
		'actions' => 'Actions'
	],
	'gridCards' => [ 'root' => 'col col12', 'factor' => 'x3' ],
	'templateDir' => "$themeTemplates/widget/grid",
	//'dataView' => "$moduleTemplates/grid/data/chat-message",
	//'cardView' => "$moduleTemplates/grid/cards/chat-message",
	'actionView' => "$moduleTemplates/grid/actions/chat-message"
]) ?>

<?= Popup::widget([
	'title' => 'Apply Bulk Action', 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'bulk',
	'data' => [ 'model' => 'Group Message', 'app' => 'grid', 'controller' => 'crud', 'action' => 'bulk', 'url' => "$apixBase/bulk" ]
])?>

<?= Popup::widget([
	'title' => 'Delete Group Message', 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'delete',
	'data' => [ 'model' => 'Group Message', 'app' => 'grid', 'controller' => 'crud', 'action' => 'delete', 'url' => "$apixBase/delete?id=" ]
])?>
