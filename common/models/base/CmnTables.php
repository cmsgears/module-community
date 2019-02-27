<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\community\common\models\base;

// CMG Imports
use cmsgears\core\common\models\base\DbTables;

/**
 * It provide table name constants of db tables available in Community Module.
 *
 * @since 1.0.0
 */
class CmnTables extends DbTables {

	// Entities -------------

	// Chatting
	const TABLE_CHAT = 'cmg_cmn_chat';

	// Groups
	const TABLE_GROUP = 'cmg_cmn_group';

	// Resources ------------

	// Users
	const TABLE_USER_FOLLOWER	= 'cmg_cmn_user_follower';
	const TABLE_USER_POST		= 'cmg_cmn_user_post';
	const TABLE_USER_POST_META = 'cmg_cmn_user_post_meta';

	// Chatting
	const TABLE_CHAT_MESSAGE = 'cmg_cmn_chat_message';

	// Groups
	const TABLE_GROUP_META		= 'cmg_cmn_group_meta';
	const TABLE_GROUP_FOLLOWER	= 'cmg_cmn_group_follower';
	const TABLE_GROUP_POST		= 'cmg_cmn_group_post';
	const TABLE_GROUP_POST_META	= 'cmg_cmn_group_post_meta';
	const TABLE_GROUP_MESSAGE	= 'cmg_cmn_group_message';

	// Reporting
	const TABLE_CHAT_MESSAGE_REPORT		= 'cmg_cmn_chat_message_report';
	const TABLE_GROUP_MESSAGE_REPORT	= 'cmg_cmn_group_message_report';

	// Mappers --------------

	// Friends
	const TABLE_FRIEND = 'cmg_cmn_friend';

	const TABLE_FRIEND_INVITE = 'cmg_cmn_friend_invite';

	// Chatting
	const TABLE_CHAT_MEMBER = 'cmg_cmn_chat_member';

	// Groups
	const TABLE_GROUP_MEMBER = 'cmg_cmn_group_member';

	const TABLE_GROUP_INVITE = 'cmg_cmn_group_invite';

}
