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
	'searchColumns' => [ 'title' => 'Title', 'content' => 'Content' ],
	'sortColumns' => [
		'title' => 'Title', 'status' => 'Status', 'template' => 'Template',
		'visibility' => 'Visibility', 'pinned' => 'Pinned', 'featured' => 'Featured',
		'cdate' => 'Created At', 'udate' => 'Updated At'
	],
	'filters' => [
		'status' => [ 'new' => 'New', 'active' => 'Active', 'blocked' => 'Blocked' ],
		'model' => [ 'pinned' => 'Pinned', 'featured' => 'Featured' ]
	],
	'reportColumns' => [
		'title' => [ 'title' => 'Title', 'type' => 'text' ],
		'content' => [ 'title' => 'Content', 'type' => 'text' ],
		'status' => [ 'title' => 'Status', 'type' => 'select', 'options' => $statusMap ],
		'visibility' => [ 'title' => 'Visibility', 'type' => 'select', 'options' => $visibilityMap ],
		'pinned' => [ 'title' => 'Pinned', 'type' => 'flag' ],
		'featured' => [ 'title' => 'Featured', 'type' => 'flag' ]
	],
	'bulkPopup' => 'popup-grid-bulk', 'bulkActions' => [
		'status' => [ 'approved' => 'Approve', 'rejected' => 'Reject', 'active' => 'Activate', 'blocked' => 'Block' ],
		'model' => [ 'pinned' => 'Pinned', 'featured' => 'Featured', 'delete' => 'Delete' ]
	],
	'header' => false, 'footer' => true,
	'grid' => true, 'columns' => [ 'root' => 'colf colf15', 'factor' => [ null, null, 'x2', 'x2', 'x2', null, null, null, null, 'x3' ] ],
	'gridColumns' => [
		'bulk' => 'Action',
		'icon' => [ 'title' => 'Icon', 'generate' => function( $model ) {
			$icon = "<div class=\"align align-center\"><i class=\"$model->icon\"></i></div>" ; return $icon;
		}],
		'title' => 'Title',
		'publisher' => [ 'title' => 'Publisher', 'generate' => function( $model ) { return isset( $model->publisher ) ? $model->publisher->name : null; } ],
		'template' => [ 'title' => 'Template', 'generate' => function( $model ) { return $model->getTemplateName(); } ],
		'status' => [ 'title' => 'Status', 'generate' => function( $model ) { return $model->getStatusStr(); } ],
		'visibility' => [ 'title' => 'Visibility', 'generate' => function( $model ) { return $model->getVisibilityStr(); } ],
		'pinned' => [ 'title' => 'Pinned', 'generate' => function( $model ) { return $model->getPinnedStr(); } ],
		'featured' => [ 'title' => 'Featured', 'generate' => function( $model ) { return $model->getFeaturedStr(); } ],
		'actions' => 'Actions'
	],
	'gridCards' => [ 'root' => 'col col12', 'factor' => 'x3' ],
	'templateDir' => "$themeTemplates/widget/grid",
	//'dataView' => "$moduleTemplates/grid/data/group-post",
	//'cardView' => "$moduleTemplates/grid/cards/group-post",
	'actionView' => "$moduleTemplates/grid/actions/group-post"
]) ?>

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
	'title' => "Delete $title", 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'delete',
	'data' => [ 'model' => $title, 'app' => 'grid', 'controller' => 'crud', 'action' => 'delete', 'url' => "$apixBase/delete?id=" ]
])?>
