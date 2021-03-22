<?php
// CMG Imports
use cmsgears\widgets\popup\Popup;

use cmsgears\widgets\grid\DataGrid;

$coreProperties = $this->context->getCoreProperties();
$title			= $this->context->title;
$this->title	= $title . 's | ' . $coreProperties->getSiteTitle();
$apixBase		= $this->context->apixBase;
$baseUrl		= $this->context->baseUrl;

// View Templates
$moduleTemplates	= '@cmsgears/module-community/admin/views/templates';
$themeTemplates		= '@themes/admin/views/templates';
?>
<?= DataGrid::widget([
	'dataProvider' => $dataProvider, 'add' => true, 'addUrl' => "create?pid=$parent->id", 'data' => [ 'baseUrl' => $baseUrl, 'parent' => $parent ],
	'title' => "{$title}s", 'options' => [ 'class' => 'grid-data grid-data-admin' ],
	'searchColumns' => [ 'content' => 'Content' ],
	'sortColumns' => [
		'sender' => 'Sender', 'broadcasted' => 'Broadcasted', 'delivered' => 'Delivered',
		'consumed' => 'Consumed', 'cdate' => 'Created At', 'udate' => 'Updated At'
	],
	'filters' => [
		'model' => [ 'broadcasted' => 'Broadcasted', 'delivered' => 'Delivered', 'consumed' => 'Consumed' ]
	],
	'reportColumns' => [
		'content' => [ 'title' => 'Content', 'type' => 'text' ],
		'broadcasted' => [ 'title' => 'Broadcasted', 'type' => 'flag' ],
		'delivered' => [ 'title' => 'Delivered', 'type' => 'flag' ],
		'consumed' => [ 'title' => 'Consumed', 'type' => 'flag' ]
	],
	'bulkPopup' => 'popup-grid-bulk', 'bulkActions' => [
		'model' => [ 'broadcasted' => 'Broadcasted', 'delivered' => 'Delivered', 'consumed' => 'Consumed', 'delete' => 'Delete' ]
	],
	'header' => false, 'footer' => true,
	'grid' => true, 'columns' => [ 'root' => 'colf colf15', 'factor' => [ null, null, 'x2', null, null, null, 'x6', 'x2' ] ],
	'gridColumns' => [
		'bulk' => 'Action',
		'icon' => [ 'title' => 'Icon', 'generate' => function( $model ) {
			$icon = "<div class=\"align align-center\"><i class=\"$model->icon\"></i></div>" ; return $icon;
		}],
		'sender' => [ 'title' => 'Sender', 'generate' => function( $model ) { return $model->sender->name; } ],
		'broadcasted' => [ 'title' => 'Broadcasted', 'generate' => function( $model ) { return $model->getBroadcastedStr(); } ],
		'delivered' => [ 'title' => 'Delivered', 'generate' => function( $model ) { return $model->getDeliveredStr(); } ],
		'consumed' => [ 'title' => 'Consumed', 'generate' => function( $model ) { return $model->getConsumedStr(); } ],
		'message' => [ 'title' => 'Message', 'generate' => function( $model ) { return $model->getMediumContent(); } ],
		'actions' => 'Actions'
	],
	'gridCards' => [ 'root' => 'col col12', 'factor' => 'x3' ],
	'templateDir' => "$themeTemplates/widget/grid",
	//'dataView' => "$moduleTemplates/grid/data/group-message",
	//'cardView' => "$moduleTemplates/grid/cards/group-message",
	'actionView' => "$moduleTemplates/grid/actions/group-message"
]) ?>

<?= Popup::widget([
	'title' => 'Apply Bulk Action', 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'bulk',
	'data' => [ 'model' => $title, 'app' => 'grid', 'controller' => 'crud', 'action' => 'bulk', 'url' => "$apixBase/bulk" ]
])?>

<?= Popup::widget([
	'title' => "Delete $title", 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'delete',
	'data' => [ 'model' => $title, 'app' => 'grid', 'controller' => 'crud', 'action' => 'delete', 'url' => "$apixBase/delete?id=" ]
])?>
