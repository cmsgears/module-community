<?php 
// Yii Imports
use yii\helpers\Url;
use cmsgears\core\common\utilities\CodeGenUtil;
?>
<!-- Account Template -->
<script id="updateRoleTemplate" type="text/x-handlebars-template"> 
	<select class="bm-select cmt-select hidden" name="GroupMember[roleId]">	
		 {{roleList}}
	</select>	 
</script>