<?php
// CMG Imports
use cmsgears\widgets\popup\Popup;

use cmsgears\widgets\grid\DataGrid;

$coreProperties = $this->context->getCoreProperties();
$this->title	= 'Chat Members | ' . $coreProperties->getSiteTitle();
$apixBase		= $this->context->apixBase;

// View Templates
$moduleTemplates	= '@cmsgears/module-community/admin/views/templates';
$themeTemplates		= '@themes/admin/views/templates';
?>
<?= DataGrid::widget([
	'dataProvider' => $dataProvider, 'add' => true, 'addUrl' => "create?pid=$parent->id", 'data' => [ 'parent' => $parent ],
	'title' => $this->title, 'options' => [ 'class' => 'grid-data grid-data-admin' ],
	'searchColumns' => [ 'user' => 'User', 'email' => 'email' ],
	'sortColumns' => [
		'user' => 'User', 'email' => 'email', 'status' => 'Status',
		'cdate' => 'Created At', 'udate' => 'Updated At'
	],
	'filters' => [
		'status' => [
			'new' => 'New', 'active' => 'Active', 'blocked' => 'Blocked'
		]
	],
	'reportColumns' => [
		'user' => [ 'title' => 'User', 'type' => 'text' ],
		'email' => [ 'title' => 'Email', 'type' => 'text' ],
		'status' => [ 'title' => 'Status', 'type' => 'select', 'options' => $statusMap ]
	],
	'bulkPopup' => 'popup-grid-bulk', 'bulkActions' => [
		'status' => [ 'active' => 'Activate', 'blocked' => 'Block' ],
		'model' => [ 'delete' => 'Delete' ]
	],
	'header' => false, 'footer' => true,
	'grid' => true, 'columns' => [ 'root' => 'colf colf15', 'factor' => [ null, 'x5', 'x4', null, null, null, 'x2' ] ],
	'gridColumns' => [
		'bulk' => 'Action',
		'user' => [ 'title' => 'User', 'generate' => function( $model ) { return $model->user->getName(); } ],
		'email' => [ 'title' => 'Email', 'generate' => function( $model ) { return $model->user->email; } ],
		'status' => [ 'title' => 'Status', 'generate' => function( $model ) { return $model->getStatusStr(); } ],
		'createdAt' => 'Created At',
		'modifiedAt' => 'Updated At',
		'actions' => 'Actions'
	],
	'gridCards' => [ 'root' => 'col col12', 'factor' => 'x3' ],
	'templateDir' => "$themeTemplates/widget/grid",
	//'dataView' => "$moduleTemplates/grid/data/chat-member",
	//'cardView' => "$moduleTemplates/grid/cards/chat-member",
	'actionView' => "$moduleTemplates/grid/actions/chat-member"
])?>

<?= Popup::widget([
	'title' => 'Apply Bulk Action', 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'bulk',
	'data' => [ 'model' => 'Group Member', 'app' => 'grid', 'controller' => 'crud', 'action' => 'bulk', 'url' => "$apixBase/bulk" ]
])?>

<?= Popup::widget([
	'title' => 'Block Group Member', 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'block',
	'data' => [ 'model' => 'Group Member', 'app' => 'grid', 'controller' => 'crud', 'action' => 'generic', 'url' => "$apixBase/toggle-block?id=" ]
])?>

<?= Popup::widget([
	'title' => 'Activate Group Member', 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'activate',
	'data' => [ 'model' => 'Group Member', 'app' => 'grid', 'controller' => 'crud', 'action' => 'generic', 'url' => "$apixBase/toggle-block?id=" ]
])?>

<?= Popup::widget([
	'title' => 'Delete Group Member', 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'delete',
	'data' => [ 'model' => 'Group Member', 'app' => 'grid', 'controller' => 'crud', 'action' => 'delete', 'url' => "$apixBase/delete?id=" ]
])?>
