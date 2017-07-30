<?php
// CMG Imports
use cmsgears\widgets\popup\Popup;

use cmsgears\widgets\grid\DataGrid;
// CMG Imports
use cmsgears\core\common\utilities\CodeGenUtil;
$coreProperties = $this->context->getCoreProperties();
$this->title	= 'Post | ' . $coreProperties->getSiteTitle();

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
	'grid' => true, 'columns' => [ 'root' => 'colf colf15', 'factor' => [ null , 'x3', null, 'x2', 'x2', 'x2', null, null, null , null ] ],
	'gridColumns' => [
		'bulk' => 'Action',
		'name' => 'Name',
		'status' => [ 'title' => 'Status', 'generate' => function( $model ) { return $model->getStatusStr(); } ],
		'visibility' => [ 'title' => 'Visibility', 'generate' => function( $model ) { return $model->getVisibilityStr(); } ],
		'template' => [ 'title' => 'Template', 'generate' => function( $model ) { return $model->modelContent->getTemplateName(); } ],
		'tag'	=> [ 'title' => 'Tags' , 'generate' => function( $model ) { 
				$value =  CodeGenUtil::generateLinksFromMap( '/cms/post/tag/update?id=', $model->getTagIdNameMap(), true, false );  
				return $value; } 
			],
		'createdAt'=>'Created on',
		'modifiedAt'=>'Updated on',
		'publishedAt'=>[ 'title' => 'Published on', 'generate' => function( $model ) { return $model->modelContent->publishedAt; } ],
		'actions' => 'Actions'
	],
	'gridCards' => [ 'root' => 'col col12', 'factor' => 'x3' ],
	'templateDir' => '@themes/admin/views/templates/widget/grid',
	//'dataView' => "$moduleTemplates/grid/data/gallery",
	//'cardView' => "$moduleTemplates/grid/cards/gallery",
	'actionView' => "$moduleTemplates/grid/actions/post"
]) ?>

<?= Popup::widget([
	'title' => 'Update Block', 'size' => 'medium',
	'templateDir' => Yii::getAlias( '@themes/admin/views/templates/widget/popup/grid' ), 'template' => 'bulk',
	'data' => [ 'model' => 'Block', 'app' => 'main', 'controller' => 'crud', 'action' => 'bulk', 'url' => "cms/post/bulk" ]
]) ?>

<?= Popup::widget([
	'title' => 'Delete Block', 'size' => 'medium',
	'templateDir' => Yii::getAlias( '@themes/admin/views/templates/widget/popup/grid' ), 'template' => 'delete',
	'data' => [ 'model' => 'Block', 'app' => 'main', 'controller' => 'crud', 'action' => 'delete', 'url' => "cms/post/delete?id=" ]
]) ?>
