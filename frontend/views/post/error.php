<?php
	$coreProperties = $this->context->getCoreProperties();
	$this->title	= $coreProperties->getSiteTitle() . " | " . $page->getName();
?>
<h1><?= $page->getName() ?></h1>
<div>
	<?= $message ?>
</div>