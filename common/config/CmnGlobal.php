<?php
namespace cmsgears\community\common\config;

class CmnGlobal {

	// System Sites ---------------------------------------------------

	// System Pages ---------------------------------------------------

	// Grouping by type ------------------------------------------------

	const TYPE_COMMUNITY	= 'community';

	const TYPE_FRIEND		= 'friend';

	const TYPE_GROUP		= 'group';
	const TYPE_GROUP_META	= 'group-meta';

	const TYPE_CHAT			= 'chat';

	// Templates -------------------------------------------------------

	// Config ----------------------------------------------------------

	// Roles -----------------------------------------------------------

	// System roles

	const ROLE_COMMUNITY_ADMIN	= 'community-admin';

	// Group roles - Secondary roles having type set to group

	const ROLE_GROUP_MANAGER	= 'group-manager';
	const ROLE_GROUP_MODERATOR	= 'group-moderator';
	const ROLE_GROUP_MEMBER		= 'group-member';

	// Permissions -----------------------------------------------------

	// System permissions

	const PERM_COMMUNITY_ADMIN	= 'admin-community';

	const PERM_CHAT_ADMIN		= 'admin-chat';
	const PERM_GROUP_ADMIN		= 'admin-group';

	const PERM_GROUP_MANAGE		= 'manage-groups';
	const PERM_GROUP_AUTHOR		= 'group-author';

	const PERM_GROUP_VIEW		= 'view-groups';
	const PERM_GROUP_ADD		= 'add-group';
	const PERM_GROUP_UPDATE		= 'update-group';
	const PERM_GROUP_DELETE		= 'delete-group';
	const PERM_GROUP_APPROVE	= 'approve-group';
	const PERM_GROUP_PRINT		= 'print-group';
	const PERM_GROUP_IMPORT		= 'import-groups';
	const PERM_GROUP_EXPORT		= 'export-groups';

	// Group permissions - Secondary permissions having type set to group

	const PERM_GROUP_MANAGER	= 'group-manager';
	const PERM_GROUP_MODERATOR	= 'group-moderator';
	const PERM_GROUP_MEMBER		= 'group-member';

	const PERM_GROUP_SETTINGS	= 'update-group-settings';
	const PERM_GROUP_PROFILE	= 'update-group-profile';
	const PERM_GROUP_STATUS		= 'update-group-status';

	const PERM_GROUP_MEMBER_INVITE	='invite-group-members';
	const PERM_GROUP_MEMBER_VIEW	='view-group-members';
	const PERM_GROUP_MEMBER_ADD		='add-group-member';
	const PERM_GROUP_MEMBER_UPDATE	='update-group-member';
	const PERM_GROUP_MEMBER_APPROVE	='approve-group-member';
	const PERM_GROUP_MEMBER_BLOCK	='block-group-member';
	const PERM_GROUP_MEMBER_REMOVE	='remove-group-member';

	const PERM_GROUP_MESSAGE_VIEW	='view-group-messages';
	const PERM_GROUP_MESSAGE_ADD	='add-group-message';
	const PERM_GROUP_MESSAGE_UPDATE	='update-group-message';
	const PERM_GROUP_MESSAGE_DELETE	='delete-group-message';

	// Model Attributes ------------------------------------------------

	// Default Maps ----------------------------------------------------

	// Messages --------------------------------------------------------

	// Errors ----------------------------------------------------------

	// Model Fields ----------------------------------------------------

	// Generic Fields
	const FIELD_FRIEND			= 'friendField';
	const FIELD_GROUP			= 'groupField';
	const FIELD_CHAT			= 'chatField';

	const FIELD_BROADCASTED		= 'boradcastedField';

}
