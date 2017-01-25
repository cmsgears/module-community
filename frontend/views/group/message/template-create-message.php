<?php 
// Yii Imports
use yii\helpers\Url;
?>
<!-- Account Template -->
<script id="createMessageTemplate" type="text/x-handlebars-template"> 
	 <div class="grid-row" id="grid-row-{{data.messageId}}">						
		<div class="grid-row-data clearfix"> 
			<div class="col12x2">
				{{data.createdAt}}
			</div>				
			<div class="col12x3">
				{{data.username}}
			</div>
			<div class="col12x5">
				<span class="{{data.contentClass}}">  {{data.content}} </span>
			</div>			 
			<div class="col12x2 clearfix"> 
				<div class="col1 wrap-action-icons">										 
					<span>
						<a class="fa fa-edit btn-update-message align-left" title="Update Message"></a>
						<span class="hidden">grid-row-{{data.messageId}}</span> 
						<span class="hidden">{{data.updateUrl}}</span> 
						<span class="hidden">{{data.content}}</span>
					</span>	
					<span>
						<a class="fa fa-remove btn-delete-message align-left" title="Delete Message"></a> 
						<span class="hidden">grid-row-{{data.messageId}}</span> 
						<span class="hidden">{{data.deleteUrl}}</span> 
					</span>
				</div>									
			</div>			 
		</div>
	</div>		 
</script>