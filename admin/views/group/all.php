<?php
use \Yii;
use yii\helpers\Html; 
use yii\widgets\LinkPager;

use cmsgears\core\common\utilities\CodeGenUtil;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | All Groups';
$siteUrl		= $coreProperties->getSiteUrl();

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-group';
$this->params['sidebar-child'] 	= 'group';

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
					<th>Avatar</th>
					<th>Name
						<span class='box-icon-sort'>
							<span sort-order='name' class="icon-sort <?php if( strcmp( $sortOrder, 'name') == 0 ) echo 'icon-up-active'; else echo 'icon-up';?>"></span>
							<span sort-order='-name' class="icon-sort <?php if( strcmp( $sortOrder, '-name') == 0 ) echo 'icon-down-active'; else echo 'icon-down';?>"></span>
						</span>
					</th>
					<th>Slug</th>
					<th>Visibility</th>
					<th>Status</th>
					<th>SEO Name</th>
					<th>SEO Description</th>
					<th>SEO Keywords</th>
					<th>SEO Robot</th>
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

					$slugBase	= $siteUrl;

					foreach( $models as $group ) {

						$id 		= $group->id;
						$editUrl	= Html::a( $group->name, [ "/cmgcmn/group/update?id=$id" ] );
						$slug		= $group->slug;
						$slugUrl	= "<a href='" . $slugBase . "group/$slug'>$slug</a>";
						$content	= $group->content;
				?>
					<tr>
						<td> 
							<?php
								$avatar = $group->avatar;

								if( isset( $avatar ) ) { 
							?> 
								<img class="avatar" src="<?= $avatar->getThumbUrl() ?>">
							<?php 
								} else { 
							?>
								<img class="avatar" src="<?=Yii::getAlias('@web')?>/images/avatar.png">
							<?php } ?>
						</td>
						<td><?= $editUrl ?></td>
						<td><?= $slugUrl ?></td>
						<td><?= $group->getVisibilityStr() ?></td>
						<td><?= $group->getStatusStr() ?></td>
						<td><?= $content->seoName ?></td>
						<td><?= $content->seoDescription ?></td>
						<td><?= $content->seoKeywords ?></td>
						<td><?= $content->seoRobot ?></td>
						<td><?= $content->createdAt ?></td>
						<td><?= $content->modifiedAt ?></td>
						<td>
							<span class="wrap-icon-action" title="View Group Members"><?= Html::a( "", ["/cmgcmn/group/members?id=$id"], ['class'=>'icon-action icon-action-edit'] )  ?></span>
							<span class="wrap-icon-action" title="View Group Messages"><?= Html::a( "", ["/cmgcmn/group/messages?id=$id"], ['class'=>'icon-action icon-action-edit'] )  ?></span>
							<span class="wrap-icon-action" title="Update Group"><?= Html::a( "", ["/cmgcmn/group/update?id=$id"], ['class'=>'icon-action icon-action-edit'] )  ?></span>
							<span class="wrap-icon-action" title="Delete Group"><?= Html::a( "", ["/cmgcmn/group/delete?id=$id"], ['class'=>'icon-action icon-action-delete'] )  ?></span>
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