<?php
// CMG Imports
use cmsgears\widgets\popup\Popup;

use cmsgears\widgets\grid\DataGrid;
// CMG Imports
use cmsgears\core\common\utilities\CodeGenUtil;
$coreProperties = $this->context->getCoreProperties();
$this->title	= 'Category | ' . $coreProperties->getSiteTitle();

// Templates
$moduleTemplates	= '@cmsgears/module-cms/admin/views/templates';
?>

<?= DataGrid::widget([
	'dataProvider' => $dataProvider, 'add' => true, 'addUrl' => 'create', 'data' => [ ],
	'title' => 'Blocks', 'options' => [ 'class' => 'grid-data grid-data-admin' ],
	'searchColumns' => [ 'name' => 'Name',  ],
	'sortColumns' => [
		'name' => 'Name', 'slug' => 'Slug', 'active' => 'Active'
		
	],
	'filters' => [ 'status' => [ 'active' => 'Active' ] ],
	'reportColumns' => [
		'name' => [ 'title' => 'Name', 'type' => 'text' ],
		
		'desc' => [ 'title' => 'Description', 'type' => 'text' ],
		'active' => [ 'title' => 'Active', 'type' => 'flag' ]
	],
	'bulkPopup' => 'popup-grid-bulk', 'bulkActions' => [
		'status' => [ 'block' => 'Block', 'active' => 'Activate' ],
		'model' => [ 'delete' => 'Delete' ]
	],
	'header' => false, 'footer' => true,
	'grid' => true, 'columns' => [ 'root' => 'colf colf15', 'factor' => [ null , 'x3', null, 'x4', 'x2', 'x2', null, null,  ] ],
	'gridColumns' => [
		'bulk' => 'Action',
		'name' => 'Name',
		'icon' => [ 'title' => 'Icon', 'generate' => function( $model ) { $icon = "<div class='align align-center'><i class='fa-2x " . $model->icon ."'></i></div>" ; return $icon;  } ],
		'description' => 'Description',
		'featured'	=> [ 'title' => 'Featured', 'generate' => function( $model ) { return $model->getFeaturedStr(); } ],
		'parent'	=> [ 'title' => 'Parent', 'generate' => function( $model ) { return $model->getParentName(); } ],
		'template'	=> [ 'title' => 'Template', 'generate' => function( $model ) { return $model->modelContent->getTemplateName(); } ],
		'actions'	=> 'Actions'
	],
	'gridCards' => [ 'root' => 'col col12', 'factor' => 'x3' ],
	'templateDir' => '@themes/admin/views/templates/widget/grid',
	//'dataView' => "$moduleTemplates/grid/data/gallery",
	//'cardView' => "$moduleTemplates/grid/cards/gallery",
	//'actionView' => "$moduleTemplates/grid/actions/gallery"
]) ?>

<?= Popup::widget([
	'title' => 'Update Block', 'size' => 'medium',
	'templateDir' => Yii::getAlias( '@themes/admin/views/templates/widget/popup/grid' ), 'template' => 'bulk',
	'data' => [ 'model' => 'Block', 'app' => 'main', 'controller' => 'crud', 'action' => 'bulk', 'url' => "cms/category/bulk" ]
]) ?>

<?= Popup::widget([
	'title' => 'Delete Block', 'size' => 'medium',
	'templateDir' => Yii::getAlias( '@themes/admin/views/templates/widget/popup/grid' ), 'template' => 'delete',
	'data' => [ 'model' => 'Block', 'app' => 'main', 'controller' => 'crud', 'action' => 'delete', 'url' => "cms/category/delete?id=" ]
]) ?>
