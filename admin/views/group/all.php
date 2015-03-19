<?php
use \Yii;
use yii\helpers\Html; 
use yii\widgets\LinkPager;

use cmsgears\modules\core\common\utilities\CodeGenUtil;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | All Groups';
$groupsUrl		= $coreProperties->getSiteUrl() . "group/";

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
		<?= Html::a( "Add Group", ["/cmgcommunity/group/create"], ['class'=>'btn'] )  ?>				
	</div>
	<div class="header-search">
		<input type="text" name="search" id="search-terms" value="<?php if( isset($searchTerms) ) echo $searchTerms;?>">
		<input type="submit" name="submit-search" value="Search" onclick="return searchTable();" />
	</div>
</div>
<div class="data-grid">
	<div class="grid-header">
		<?= LinkPager::widget( [ 'pagination' => $pages ] ); ?>
	</div>
	<div class="wrap-grid">
		<table>
			<thead>
				<tr>
					<th> <input type='checkbox' /> </th>
					<th>Avatar</th>
					<th>Name
						<span class='box-icon-sort'>
							<span sort-order='name' class="icon-sort <?php if( strcmp( $sortOrder, 'name') == 0 ) echo 'icon-up-active'; else echo 'icon-up';?>"></span>
							<span sort-order='-name' class="icon-sort <?php if( strcmp( $sortOrder, '-name') == 0 ) echo 'icon-down-active'; else echo 'icon-down';?>"></span>
						</span>
					</th>
					<th>Slug</th>	
					<th>Description</th>
					<th>Categories</th>
					<th>Visibility</th>
					<th>Status</th>
					<th>Created on
						<span class='box-icon-sort'>
							<span sort-order='cdate' class="icon-sort <?php if( strcmp( $sortOrder, 'cdate') == 0 ) echo 'icon-up-active'; else echo 'icon-up';?>"></span>
							<span sort-order='-cdate' class="icon-sort <?php if( strcmp( $sortOrder, '-cdate') == 0 ) echo 'icon-down-active'; else echo 'icon-down';?>"></span>
						</span>
					</th>
					<th>Updated on
						<span class='box-icon-sort'>
							<span sort-order='udate' class="icon-sort <?php if( strcmp( $sortOrder, 'udate') == 0 ) echo 'icon-up-active'; else echo 'icon-up';?>"></span>
							<span sort-order='-udate' class="icon-sort <?php if( strcmp( $sortOrder, '-udate') == 0 ) echo 'icon-down-active'; else echo 'icon-down';?>"></span>
						</span>
					</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
					
					$uploadUrl	= Yii::$app->fileManager->uploadUrl;

					foreach( $page as $group ) {

						$id 		= $group->getId();
						$editUrl	= Html::a( $group->getName(), ["cmgcommunity/group/update?id=$id"] );
						$slug		= $group->getSlug();
						$slugUrl	= "<a href='" . $groupsUrl . "$slug'>$slug</a>";
						$categories	= CodeGenUtil::generateCategoriesCsv( "#", $group->getCategoriesIdNameMap() );
				?>
					<tr>
						<td> <input type='checkbox' /> </td>
						<td> 
							<?php
								$avatar = $group->avatar;

								if( isset( $avatar ) ) { 
							?> 
								<img class="avatar" src="<?=$uploadUrl?><?= $avatar->getThumb() ?>">
							<?php 
								} else { 
							?>
								<img class="avatar" src="<?=Yii::getAlias('@web')?>/assets/images/avatar.png">
							<?php } ?>
						</td>
						<td><?= $editUrl ?></td>
						<td><?= $slugUrl ?></td>
						<td><?= $group->getDesc() ?></td>
						<td><?= $categories ?></td>
						<td><?= $group->getVisibilityStr() ?></td>
						<td><?= $group->getStatusStr() ?></td>
						<td><?= $group->getCreatedOn() ?></td>
						<td><?= $group->getUpdatedOn() ?></td>
						<td>
							<span class="wrap-icon-action" title="View Group Members"><?= Html::a( "", ["/cmgcommunity/group/members?id=$id"], ['class'=>'icon-action icon-action-edit'] )  ?></span>
							<span class="wrap-icon-action" title="View Group Messages"><?= Html::a( "", ["/cmgcommunity/group/messages?id=$id"], ['class'=>'icon-action icon-action-edit'] )  ?></span>
							<span class="wrap-icon-action" title="Update Group"><?= Html::a( "", ["/cmgcommunity/group/update?id=$id"], ['class'=>'icon-action icon-action-edit'] )  ?></span>
							<span class="wrap-icon-action" title="Delete Group"><?= Html::a( "", ["/cmgcommunity/group/delete?id=$id"], ['class'=>'icon-action icon-action-delete'] )  ?></span>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="grid-footer">
		<div class="text"> <?=CodeGenUtil::getPaginationDetail( $pages, $page, $total ) ?> </div>
		<?= LinkPager::widget( [ 'pagination' => $pages ] ); ?>
	</div>
</div>
<script type="text/javascript">
	initSidebar( "sidebar-group", 2 );
</script>