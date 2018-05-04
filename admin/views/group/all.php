<?php
// CMG Imports
use cmsgears\widgets\popup\Popup;
use cmsgears\core\common\utilities\CodeGenUtil;
use cmsgears\widgets\grid\DataGrid;

$coreProperties = $this->context->getCoreProperties();
$siteUrl		= $coreProperties->getSiteUrl();
$this->title	= 'Groups | ' . $coreProperties->getSiteTitle();
$apixBase		= $this->context->apixBase;

// View Templates
$moduleTemplates	= '@cmsgears/module-cms/admin/views/templates';
$themeTemplates		= '@themes/admin/views/templates';
?>
<?= DataGrid::widget([
	'dataProvider' => $dataProvider, 'add' => true, 'addUrl' => 'create', 'data' => [ ],
	'title' => 'Groups', 'options' => [ 'class' => 'grid-data grid-data-admin' ],
	'searchColumns' => [ 'name' => 'Name', 'title' => 'Title' ],
	'sortColumns' => [
		'name' => 'Name', 'slug' => 'Slug', 'title' => 'Title', 'active' => 'Active',
		'cdate' => 'Created At', 'udate' => 'Updated At'
	],
	'filters' => [ 'status' => [ 'active' => 'Active' ] ],
	'reportColumns' => [
		'name' => [ 'title' => 'Name', 'type' => 'text' ],
		'title' => [ 'title' => 'Title', 'type' => 'text' ],
		'desc' => [ 'title' => 'Description', 'type' => 'text' ],
		'active' => [ 'title' => 'Active', 'type' => 'flag' ]
	],
	'bulkPopup' => 'popup-grid-bulk', 'bulkActions' => [
		'status' => [ 'block' => 'Block', 'active' => 'Activate' ],
		'model' => [ 'delete' => 'Delete' ]
	],
	'header' => false, 'footer' => true,
	'grid' => true, 'columns' => [ 'root' => 'colf colf15', 'factor' => [ null , 'x2', null, 'x2', 'x2', 'x2', 'x2', 'x2', null  ] ],
	'gridColumns' => [
		'bulk' => 'Action',
		'avatar' =>  [ 'title' => 'Avatar', 'generate' => function( $model ) {
				$avatar = '<div class="align align-center">'. CodeGenUtil::getImageThumbTag( $model->avatar, [ 'class' => 'avatar', 'image' => 'avatar' ] ) . '</div>';
				return $avatar; }
				],
		'name' => 'Name',
		'slug' =>  [ 'title' => 'Slug', 'generate' => function( $model ) {
				$slug		= $model->slug;
				$slugUrl	= "<a href='" . $siteUrl . "group/$slug'>$slug</a>";
				return $slugUrl; }
				],
		'visibility' => [ 'title' => 'Visibility', 'generate' => function( $model ) { return $model->getVisibilityStr(); } ],
		'status' => [ 'title' => 'Status', 'generate' => function( $model ) { return $model->getStatusStr(); } ],
		'createdAt' => 'Created on',
		'modifiedAt' => 'Updated on',
		'actions' => 'Actions'
	],
	'gridCards' => [ 'root' => 'col col12', 'factor' => 'x3' ],
	'templateDir' => '@themes/admin/views/templates/widget/grid',
	//'dataView' => "$moduleTemplates/grid/data/gallery",
	//'cardView' => "$moduleTemplates/grid/cards/gallery",
	'actionView' => "$moduleTemplates/grid/actions/group"
]) ?>

<?= Popup::widget([
	'title' => 'Apply Bulk Action', 'size' => 'medium',
	'templateDir' => Yii::getAlias( '@themes/admin/views/templates/widget/popup/grid' ), 'template' => 'bulk',
	'data' => [ 'model' => 'Group', 'app' => 'grid', 'controller' => 'crud', 'action' => 'bulk', 'url' => "$apixBase/bulk" ]
]) ?>

<?= Popup::widget([
	'title' => 'Delete Group', 'size' => 'medium',
	'templateDir' => Yii::getAlias( '@themes/admin/views/templates/widget/popup/grid' ), 'template' => 'delete',
	'data' => [ 'model' => 'Group', 'app' => 'grid', 'controller' => 'crud', 'action' => 'delete', 'url' => "$apixBase/delete?id=" ]
]) ?>
