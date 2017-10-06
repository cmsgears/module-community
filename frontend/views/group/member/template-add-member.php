<?php 
// Yii Imports
use yii\helpers\Url;
?>
<!-- Account Template -->
<script id="addMemberTemplate" type="text/x-handlebars-template"> 
	{{#each data}}
		<div class="grid-row" id="grid-row-{{memberId}}">						
			<div class="grid-row-data clearfix">
				<div class="col12x4 clearfix">
					<span class="label-header col1">{{name}}</span>
					<span class="data-account-name col1"><img src="{{avatar}}"></span> 
				</div>			 
				<div class="col12x4 clearfix">
					<span class="label-header col1">Role</span>
					<span class="col12x8" id="role-name-{{memberId}}">
						{{roleName}}
					</span>	
					<div class="col12x8 wrap-role-list hidden"> 
						<select class="bm-select hidden" name="GroupMember[roleId]">	
							{{roleList}}
						</select>
						<span class="hidden">role-name-{{memberId}}</span>	
						<span class="hidden"> {{updateUrl}} </span>									
					</div>	 				 
				</div>	 
				<div class="col12x4 clearfix"> 
					<div class="col1 wrap-action-icons">
						<a class="fa fa-lock btn-member-deactivate" title="Deactivate Member"></a>		
						<span class="hidden">{{deactivateUrl}}</span>	
						<span class="hidden"><?= 'grid-row-' ?>{{memberId}}</span>									
						<span><a data="role-name-{{memberId}}" class="fa fa-edit btn-update-role align-left" title="Update Role"></a></span>	
						<span>
							<a class="fa fa-remove btn-delete-member align-left" title="Delete Member"></a>
							<span class="hidden">grid-row-{{memberId}}</span>
							<span class="hidden">{{deleteUrl}}</span>
						</span>	
					</div>									
				</div> 		
			</div>
		</div> 
	{{/each}}
</script>