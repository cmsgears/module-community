<?php
namespace cmsgears\community\common\models\base;

class CmnTables {

	// Entities -------------

	// Friends
	const TABLE_FRIEND				= 'cmg_cmn_friend';

	// Chatting
	const TABLE_CHAT				= 'cmg_cmn_chat';

	// Groups
	const TABLE_GROUP				= 'cmg_cmn_group';

	// Followers
	const TABLE_FOLLOWER			= 'cmg_cmn_follower';

	// Resources ------------

	// Wall - User and Room
	const TABLE_WALL_MESSAGE		= 'cmg_cmn_wall_message';

	// Chatting
	const TABLE_CHAT_MESSAGE		= 'cmg_cmn_chat_message';

	// Groups
	const TABLE_GROUP_MESSAGE		= 'cmg_cmn_group_message';

	// Mappers & Traits -----

	// Chatting
	const TABLE_CHAT_MEMBER			= 'cmg_cmn_chat_member';

	// Groups
	const TABLE_GROUP_MEMBER		= 'cmg_cmn_group_member';
}

?>