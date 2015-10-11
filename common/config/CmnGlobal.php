<?php
namespace cmsgears\community\common\config;

class CmnGlobal {

	// Model Traits - Metas, Attachments, Addresses --------------------

	const TYPE_GROUP				= 'group';
	
	// Role Type -------------------------------
	
	const TYPE_COMMUNITY			= 'community';
	
	// Roles -----------------------------------------------------------
	
	const ROLE_GROUP_SUPER_ADMIN	= 'group-super-admin';
	const ROLE_GROUP_ADMIN			= 'group-admin';
	const ROLE_GROUP_MODERATOR		= 'group-moderator';
	const ROLE_GROUP_MEMBER			= 'group-member'; 

	// Permissions -----------------------------------------------------

	const PERM_CHAT					= 'community-chat';
	const PERM_GROUP				= 'community-group';

	// Model Fields ----------------------------------------------------

	// Generic Fields
	const FIELD_FRIEND				= 'friendField';
	const FIELD_GROUP				= 'groupField';
	const FIELD_CHAT				= 'chatField';
	const FIELD_CONSUMED			= 'consumedField';
	
	// Message Visibility
	
	const VISIBILITY_PUBLIC			= 0;	// Visible to All
	const VISIBILITY_PRIVATE		= 1;	// Visible to logged in users
	const VISIBILITY_MEMBERS		= 2;	// Visible to group members
}

?>