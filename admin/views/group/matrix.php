<?php
use \Yii;
use yii\helpers\Html; 
use yii\widgets\LinkPager;

use cmsgears\core\common\utilities\CodeGenUtil;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . " | Groups Matrix";

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-group';
$this->params['sidebar-child'] 	= 'matrix';

// Data
$pagination		= $dataProvider->getPagination();
$models			= $dataProvider->getModels();

// Searching
$searchTerms	= Yii::$app->request->getQueryParam("search");

// Sorting
$sortOrder		= Yii::$app->request->getQueryParam("sort");

if( !isset( $sortOrder ) ) {

	$sortOrder	= '';
}
?>
<div class="content-header clearfix">
	<div class="header-actions"> 
		<?= Html::a( "Add Group", ["/cmgcmn/group/create"], ['class'=>'btn'] )  ?>				
	</div>
	<div class="header-search"> 
		<input type="text" name="search" id="search-terms" value="<?php if( isset($searchTerms) ) echo $searchTerms;?>">
		<input type="submit" name="submit-search" value="Search" onclick="return searchTable();" />
	</div>
</div>
<div class="data-grid">
	<div class="grid-header">
		<?= LinkPager::widget( [ 'pagination' => $pagination ] ); ?>
	</div>
	<div class="wrap-grid">
		<table>
			<thead>
				<tr>
					<th>Group
						<span class='box-icon-sort'>
							<span sort-order='name' class="icon-sort <?php if( strcmp( $sortOrder, 'name') == 0 ) echo 'icon-up-active'; else echo 'icon-up';?>"></span>
							<span sort-order='-name' class="icon-sort <?php if( strcmp( $sortOrder, '-name') == 0 ) echo 'icon-down-active'; else echo 'icon-down';?>"></span>
						</span>
					</th>
					<th>Categories</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php

					foreach( $models as $group ) {

						$id 		= $group->id;
						$categories	= $group->getCategoryIdList();
						$apixUrl	= Yii::$app->urlManager->createAbsoluteUrl( "/apix/cmgcmn/group/bind-categories" );
				?>
					<tr id="post-matrix-<?=$id?>" class="request-ajax" cmt-controller="group" cmt-action="matrix" action="<?=$apixUrl?>" method="POST" cmt-clear-data="false">
						<td><?= $group->name ?></td>
						<td>
							<input type="hidden" name="Binder[binderId]" value="<?=$id?>" />
							<ul class="ul-inline">
								<?php foreach ( $categoriesList as $category ) { 

									if( in_array( $category['id'], $categories ) ) {
								?>		
										<li><input type="checkbox" name="Binder[bindedData][]" value="<?=$category['id']?>" checked /><?=$category['name']?></li>
								<?php		
									}
									else {
								?>
										<li><input type="checkbox" name="Binder[bindedData][]" value="<?=$category['id']?>" /><?=$category['name']?></li>
								<?php
									}
								}
								?>
							</ul>
						</td>
						<td>
							<span class="wrap-icon-action cmt-submit" title="Assign Categories" cmt-request="post-matrix-<?=$id?>">
								<span class="icon-action icon-action-save"</span>
							</span>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="grid-footer">
		<div class="text"> <?=CodeGenUtil::getPaginationDetail( $dataProvider ) ?> </div>
		<?= LinkPager::widget( [ 'pagination' => $pagination ] ); ?>
	</div>
</div>