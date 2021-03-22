<?php
// CMG Imports
use cmsgears\widgets\popup\Popup;

use cmsgears\widgets\grid\DataGrid;

$coreProperties = $this->context->getCoreProperties();
$title			= $this->context->title;
$this->title	= $title . 's | ' . $coreProperties->getSiteTitle();
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
		'user' => 'User', 'role' => 'Role', 'email' => 'email', 'status' => 'Status',
		'cdate' => 'Created At', 'udate' => 'Updated At'
	],
	'filters' => [
		'status' => [
			'new' => 'New', 'submitted' => 'Submitted', 'rejected' => 'Rejected', 're-submitted' => 'Re Submitted',
			'confirmed' => 'Confirmed', 'active' => 'Active', 'frozen' => 'Frozen', 'uplift-freeze' => 'Uplift Freeze',
			'blocked' => 'Blocked', 'uplift-block' => 'Uplift Block', 'terminated' => 'Terminated'
		]
	],
	'reportColumns' => [
		'user' => [ 'title' => 'User', 'type' => 'text' ],
		'email' => [ 'title' => 'Email', 'type' => 'text' ],
		'status' => [ 'title' => 'Status', 'type' => 'select', 'options' => $statusMap ]
	],
	'bulkPopup' => 'popup-grid-bulk', 'bulkActions' => [
		'status' => [ 'approved' => 'Approve', 'active' => 'Activate', 'blocked' => 'Block', 'terminated' => 'Terminate' ],
		'model' => [ 'delete' => 'Delete' ]
	],
	'header' => false, 'footer' => true,
	'grid' => true, 'columns' => [ 'root' => 'colf colf15', 'factor' => [ null, 'x3', 'x3', 'x3', null, null, null, 'x2' ] ],
	'gridColumns' => [
		'bulk' => 'Action',
		'role' => [ 'title' => 'Role', 'generate' => function( $model ) { return $model->role->name; } ],
		'user' => [ 'title' => 'User', 'generate' => function( $model ) { return $model->user->getName(); } ],
		'email' => [ 'title' => 'Email', 'generate' => function( $model ) { return $model->user->email; } ],
		'status' => [ 'title' => 'Status', 'generate' => function( $model ) { return $model->getStatusStr(); } ],
		'createdAt' => 'Created At',
		'modifiedAt' => 'Updated At',
		'actions' => 'Actions'
	],
	'gridCards' => [ 'root' => 'col col12', 'factor' => 'x3' ],
	'templateDir' => "$themeTemplates/widget/grid",
	//'dataView' => "$moduleTemplates/grid/data/group-member",
	//'cardView' => "$moduleTemplates/grid/cards/group-member",
	'actionView' => "$moduleTemplates/grid/actions/group-member"
])?>

<?= Popup::widget([
	'title' => 'Apply Bulk Action', 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'bulk',
	'data' => [ 'model' => $title, 'app' => 'grid', 'controller' => 'crud', 'action' => 'bulk', 'url' => "$apixBase/bulk" ]
])?>

<?= Popup::widget([
	'title' => "Approve $title", 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'approve',
	'data' => [ 'model' => $title, 'app' => 'grid', 'controller' => 'crud', 'action' => 'generic', 'url' => "$apixBase/approve?id=" ]
])?>

<?= Popup::widget([
	'title' => "Block $title", 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'block',
	'data' => [ 'model' => $title, 'app' => 'grid', 'controller' => 'crud', 'action' => 'generic', 'url' => "$apixBase/toggle-block?id=" ]
])?>

<?= Popup::widget([
	'title' => "Activate $title", 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'activate',
	'data' => [ 'model' => $title, 'app' => 'grid', 'controller' => 'crud', 'action' => 'generic', 'url' => "$apixBase/toggle-block?id=" ]
])?>

<?= Popup::widget([
	'title' => "Terminate $title", 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'terminate',
	'data' => [ 'model' => $title, 'app' => 'grid', 'controller' => 'crud', 'action' => 'generic', 'url' => "$apixBase/terminate?id=" ]
])?>

<?= Popup::widget([
	'title' => "Delete $title", 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'delete',
	'data' => [ 'model' => $title, 'app' => 'grid', 'controller' => 'crud', 'action' => 'delete', 'url' => "$apixBase/delete?id=" ]
])?>
