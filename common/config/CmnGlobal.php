<?php
namespace cmsgears\community\common\config;

class CmnGlobal {

	// Model Traits - Metas, Attachments, Addresses --------------------

	const TYPE_GROUP				= 'group';

	// Roles -----------------------------------------------------------

	// Role/Permission Type
	const TYPE_COMMUNITY			= 'community';

	// Default roles
	const ROLE_GROUP_SUPER_ADMIN	= 'group-super-admin';
	const ROLE_GROUP_ADMIN			= 'group-admin';
	const ROLE_GROUP_MODERATOR		= 'group-moderator';
	const ROLE_GROUP_MEMBER			= 'group-member';

	// Permissions -----------------------------------------------------

	// Base permissions
	const PERM_CHAT					= 'community-chat';
	const PERM_GROUP				= 'community-group';

	// Model Fields ----------------------------------------------------

	// Generic Fields
	const FIELD_FRIEND				= 'friendField';
	const FIELD_GROUP				= 'groupField';
	const FIELD_CHAT				= 'chatField';
	const FIELD_CONSUMED			= 'consumedField';
}
