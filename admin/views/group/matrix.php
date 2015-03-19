<?php
use \Yii;
use yii\helpers\Html; 
use yii\widgets\LinkPager;

use cmsgears\modules\core\common\utilities\CodeGenUtil;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . " | Groups Matrix";
?>
<div class="content-header clearfix">
	<div class="header-actions"> 
		<?= Html::a( "Add Group", ["/cmgcommunity/group/create"], ['class'=>'btn'] )  ?>				
	</div>
	<div class="header-search">
		<form action="#">
			<input type="text" name="search" />
			<input type="submit" value="Search" />
		</form>
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
					<th>Group</th>
					<th>Categories</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php

					foreach( $page as $group ) {

						$id 		= $group->getId();
						$categories	= $group->getCategoriesIdList();
						$apixUrl	= Yii::$app->urlManager->createAbsoluteUrl( "/apix/cmgcommunity/group/bind-categories" );
				?>
					<tr>
						<td><?= $group->getName() ?></td>
						<td>
							<form action="<?=$apixUrl?>" method="POST">
								<input type="hidden" name="groupId" value="<?=$id?>" />
								<ul class="ul-inline">
									<?php foreach ( $allCategories as $category ) { 

										if( in_array( $category['id'], $categories ) ) {
									?>		
											<li><input type="checkbox" name="bindedData" value="<?=$category['id']?>" checked /><?=$category['name']?></li>
									<?php		
										}
										else {
									?>
											<li><input type="checkbox" name="bindedData" value="<?=$category['id']?>" /><?=$category['name']?></li>
									<?php
										}
									}
									?>
								</ul>
							</form>
						</td>
						<td><span class="wrap-icon-action"><span class="icon-action icon-action-save matrix-row"</span></span></td>
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
	initSidebar( "sidebar-group", 0 );
	initMappingsMatrix();
</script>