<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\models\base\Meta;

/**
 * The community migration inserts the database tables of community module. It also insert the foreign
 * keys if FK flag of migration component is true.
 *
 * @since 1.0.0
 */
class m160910_110554_community extends \cmsgears\core\common\base\Migration {

	// Public Variables

	public $fk;
	public $options;

	// Private Variables

	private $prefix;

	public function init() {

		// Table prefix
		$this->prefix = Yii::$app->migration->cmgPrefix;

		// Get the values via config
		$this->fk		= Yii::$app->migration->isFk();
		$this->options	= Yii::$app->migration->getTableOptions();

		// Default collation
		if( $this->db->driverName === 'mysql' ) {

			$this->options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}
	}

    public function up() {

		// Friend
		$this->upFriend();
		$this->upFriendInvite();

		// User
		$this->upUserFollower();
		$this->upUserPost();
		$this->upUserPostMeta();

		// Chat
		$this->upChat();
		$this->upChatMember();
		$this->upChatMessage();
		$this->upChatMessageReport();

		// Group
		$this->upGroup();
		$this->upGroupMeta();
		$this->upGroupFollower();
		$this->upGroupPost();
		$this->upGroupPostMeta();
		$this->upGroupMember();
		$this->upGroupInvite();
		$this->upGroupMessage();
		$this->upGroupMessageReport();

		if( $this->fk ) {

			$this->generateForeignKeys();
		}
    }

	private function upFriend() {

        $this->createTable( $this->prefix . 'cmn_friend', [
			'id' => $this->bigPrimaryKey( 20 ),
			'userId' => $this->bigInteger( 20 )->notNull(),
			'friendId' => $this->bigInteger( 20 )->notNull(),
			'status' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'type' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'content' => $this->mediumText(),
			'data' => $this->mediumText(),
			'gridCache' => $this->longText(),
			'gridCacheValid' => $this->boolean()->notNull()->defaultValue( false ),
			'gridCachedAt' => $this->dateTime()
        ], $this->options );

        // Index for columns user and friend
        $this->createIndex( 'idx_' . $this->prefix . 'friend_user', $this->prefix . 'cmn_friend', 'userId' );
		$this->createIndex( 'idx_' . $this->prefix . 'friend_parent', $this->prefix . 'cmn_friend', 'friendId' );
	}

	private function upFriendInvite() {

        $this->createTable( $this->prefix . 'cmn_friend_invite', [
			'id' => $this->bigPrimaryKey( 20 ),
			'userId' => $this->bigInteger( 20 )->notNull(),
			'friendId' => $this->bigInteger( 20 )->defaultValue( null ),
			'email' => $this->string( Yii::$app->core->xLargeText )->defaultValue( null ),
			'mobile' => $this->string( Yii::$app->core->mediumText )->defaultValue( null ),
			'service' => $this->string( Yii::$app->core->mediumText )->notNull(),
			'status' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'type' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'verifyToken' => $this->string( Yii::$app->core->largeText )->defaultValue( null ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'content' => $this->mediumText(),
			'data' => $this->mediumText(),
			'gridCache' => $this->longText(),
			'gridCacheValid' => $this->boolean()->notNull()->defaultValue( false ),
			'gridCachedAt' => $this->dateTime()
        ], $this->options );

        // Index for columns user and friend
        $this->createIndex( 'idx_' . $this->prefix . 'friend_invite_user', $this->prefix . 'cmn_friend_invite', 'userId' );
		$this->createIndex( 'idx_' . $this->prefix . 'friend_invite_parent', $this->prefix . 'cmn_friend_invite', 'friendId' );
	}

	private function upUserFollower() {

        $this->createTable( $this->prefix . 'cmn_user_follower', [
			'id' => $this->bigPrimaryKey( 20 ),
			'modelId' => $this->bigInteger( 20 )->notNull(),
			'parentId' => $this->bigInteger( 20 )->notNull(),
			'type' => $this->string( Yii::$app->core->mediumText )->notNull(),
			'order' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'active' => $this->boolean()->notNull()->defaultValue( true ),
			'pinned' => $this->boolean()->notNull()->defaultValue( false ),
			'featured' => $this->boolean()->notNull()->defaultValue( false ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'data' => $this->mediumText()
        ], $this->options );

        // Index for columns user and model
		$this->createIndex( 'idx_' . $this->prefix . 'user_follower_user', $this->prefix . 'cmn_user_follower', 'modelId' );
		$this->createIndex( 'idx_' . $this->prefix . 'user_follower_parent', $this->prefix . 'cmn_user_follower', 'parentId' );
	}

	private function upUserPost() {

        $this->createTable( $this->prefix . 'cmn_user_post', [
			'id' => $this->bigPrimaryKey( 20 ),
			'userId' => $this->bigInteger( 20 )->notNull(),
			'senderId' => $this->bigInteger( 20 )->defaultValue( null ),
			'parentId' => $this->bigInteger( 20 )->defaultValue( null ),
			'templateId' => $this->bigInteger( 20 )->defaultValue( null ),
			'galleryId' => $this->bigInteger( 20 )->defaultValue( null ),
			'avatarId' => $this->bigInteger( 20 )->defaultValue( null ),
			'bannerId' => $this->bigInteger( 20 )->defaultValue( null ),
			'videoId' => $this->bigInteger( 20 )->defaultValue( null ),
			'icon' => $this->string( Yii::$app->core->largeText )->defaultValue( null ),
			'texture' => $this->string( Yii::$app->core->largeText )->defaultValue( null ),
			'title' => $this->string( Yii::$app->core->xxxLargeText )->defaultValue( null ),
			'type' => $this->string( Yii::$app->core->mediumText )->defaultValue( CoreGlobal::TYPE_DEFAULT ),
			'status' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'visibility' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'pinned' => $this->boolean()->notNull()->defaultValue( false ),
			'featured' => $this->boolean()->notNull()->defaultValue( false ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'content' => $this->mediumText(),
			'data' => $this->mediumText(),
			'gridCache' => $this->longText(),
			'gridCacheValid' => $this->boolean()->notNull()->defaultValue( false ),
			'gridCachedAt' => $this->dateTime()
        ], $this->options );

        // Index for columns user, sender, parent, template, gallery, avatar, banner and video
		$this->createIndex( 'idx_' . $this->prefix . 'user_post_user', $this->prefix . 'cmn_user_post', 'userId' );
		$this->createIndex( 'idx_' . $this->prefix . 'user_post_sender', $this->prefix . 'cmn_user_post', 'senderId' );
		$this->createIndex( 'idx_' . $this->prefix . 'user_post_parent', $this->prefix . 'cmn_user_post', 'parentId' );
		$this->createIndex( 'idx_' . $this->prefix . 'user_post_template', $this->prefix . 'cmn_user_post', 'templateId' );
		$this->createIndex( 'idx_' . $this->prefix . 'user_post_gallery', $this->prefix . 'cmn_user_post', 'galleryId' );
		$this->createIndex( 'idx_' . $this->prefix . 'user_post_avatar', $this->prefix . 'cmn_user_post', 'avatarId' );
		$this->createIndex( 'idx_' . $this->prefix . 'user_post_banner', $this->prefix . 'cmn_user_post', 'bannerId' );
		$this->createIndex( 'idx_' . $this->prefix . 'user_post_video', $this->prefix . 'cmn_user_post', 'videoId' );
	}

	private function upUserPostMeta() {

        $this->createTable( $this->prefix . 'cmn_user_post_meta', [
			'id' => $this->bigPrimaryKey( 20 ),
			'modelId' => $this->bigInteger( 20 )->notNull(),
			'icon' => $this->string( Yii::$app->core->largeText )->defaultValue( null ),
			'name' => $this->string( Yii::$app->core->xLargeText )->notNull(),
			'label' => $this->string( Yii::$app->core->xxLargeText )->notNull(),
			'type' => $this->string( Yii::$app->core->mediumText )->notNull(),
			'active' => $this->boolean()->defaultValue( false ),
			'order' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'valueType' => $this->string( Yii::$app->core->mediumText )->notNull()->defaultValue( Meta::VALUE_TYPE_TEXT ),
			'value' => $this->text(),
			'data' => $this->mediumText()
        ], $this->options );

        // Index for columns site, parent, creator and modifier
		$this->createIndex( 'idx_' . $this->prefix . 'user_post_meta_parent', $this->prefix . 'cmn_user_post_meta', 'modelId' );
	}

	private function upChat() {

        $this->createTable( $this->prefix . 'cmn_chat', [
			'id' => $this->bigPrimaryKey( 20 ),
			'createdBy' => $this->bigInteger( 20 )->notNull(),
			'modifiedBy' => $this->bigInteger( 20 ),
			'title' => $this->string( Yii::$app->core->xxxLargeText )->defaultValue( null ),
			'status' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'sessionId' => $this->string( Yii::$app->core->mediumText )->notNull(),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'content' => $this->mediumText(),
			'data' => $this->mediumText(),
			'gridCache' => $this->longText(),
			'gridCacheValid' => $this->boolean()->notNull()->defaultValue( false ),
			'gridCachedAt' => $this->dateTime()
        ], $this->options );

        // Index for columns creator and modifier
		$this->createIndex( 'idx_' . $this->prefix . 'chat_creator', $this->prefix . 'cmn_chat', 'createdBy' );
		$this->createIndex( 'idx_' . $this->prefix . 'chat_modifier', $this->prefix . 'cmn_chat', 'modifiedBy' );
	}

	private function upChatMember() {

        $this->createTable( $this->prefix . 'cmn_chat_member', [
			'id' => $this->bigPrimaryKey( 20 ),
			'chatId' => $this->bigInteger( 20 )->notNull(),
			'userId' => $this->bigInteger( 20 )->notNull(),
			'verifyToken' => $this->string( Yii::$app->core->largeText )->defaultValue( null ),
			'status' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'syncedAt' => $this->dateTime(),
			'data' => $this->mediumText()
        ], $this->options );

        // Index for columns creator and modifier
		$this->createIndex( 'idx_' . $this->prefix . 'chat_member_parent', $this->prefix . 'cmn_chat_member', 'chatId' );
		$this->createIndex( 'idx_' . $this->prefix . 'chat_member_user', $this->prefix . 'cmn_chat_member', 'userId' );
	}

	private function upChatMessage() {

        $this->createTable( $this->prefix . 'cmn_chat_message', [
			'id' => $this->bigPrimaryKey( 20 ),
			'senderId' => $this->bigInteger( 20 )->notNull(),
			'recipientId' => $this->bigInteger( 20 ), // Required for one-on-one messaging
			'chatId' => $this->bigInteger( 20 ), // Required for chatting
			'avatarId' => $this->bigInteger( 20 )->defaultValue( null ),
			'bannerId' => $this->bigInteger( 20 )->defaultValue( null ),
			'videoId' => $this->bigInteger( 20 )->defaultValue( null ),
			'icon' => $this->string( Yii::$app->core->largeText )->defaultValue( null ),
			'texture' => $this->string( Yii::$app->core->largeText )->defaultValue( null ),
			'type' => $this->string( Yii::$app->core->mediumText )->defaultValue( CoreGlobal::TYPE_DEFAULT ),
			'code' => $this->string( Yii::$app->core->mediumText )->defaultValue( null ),
			'sent' => $this->boolean()->notNull()->defaultValue( false ),
			'delivered' => $this->boolean()->notNull()->defaultValue( false ),
			'consumed' => $this->boolean()->notNull()->defaultValue( false ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'content' => $this->mediumText(),
			'data' => $this->mediumText(),
			'gridCache' => $this->longText(),
			'gridCacheValid' => $this->boolean()->notNull()->defaultValue( false ),
			'gridCachedAt' => $this->dateTime()
        ], $this->options );

        // Index for columns sender, recipient and chat
		$this->createIndex( 'idx_' . $this->prefix . 'chat_message_sender', $this->prefix . 'cmn_chat_message', 'senderId' );
		$this->createIndex( 'idx_' . $this->prefix . 'chat_message_recipient', $this->prefix . 'cmn_chat_message', 'recipientId' );
		$this->createIndex( 'idx_' . $this->prefix . 'chat_message_parent', $this->prefix . 'cmn_chat_message', 'chatId' );
		$this->createIndex( 'idx_' . $this->prefix . 'chat_message_avatar', $this->prefix . 'cmn_chat_message', 'avatarId' );
		$this->createIndex( 'idx_' . $this->prefix . 'chat_message_banner', $this->prefix . 'cmn_chat_message', 'bannerId' );
		$this->createIndex( 'idx_' . $this->prefix . 'chat_message_video', $this->prefix . 'cmn_chat_message', 'videoId' );
	}

	private function upChatMessageReport() {

        $this->createTable( $this->prefix . 'cmn_chat_message_report', [
			'id' => $this->bigPrimaryKey( 20 ),
			'chatId' => $this->bigInteger( 20 )->notNull(),
			'recipientId' => $this->bigInteger( 20 )->notNull(),
			'sent' => $this->boolean()->notNull()->defaultValue( false ),
			'received' => $this->boolean()->notNull()->defaultValue( false ),
			'consumed' => $this->boolean()->notNull()->defaultValue( false ),
			'sentAt' => $this->dateTime()->notNull(),
			'receivedAt' => $this->dateTime(),
			'consumedAt' => $this->dateTime(),
			'gridCache' => $this->longText(),
			'gridCacheValid' => $this->boolean()->notNull()->defaultValue( false ),
			'gridCachedAt' => $this->dateTime()
        ], $this->options );

        // Index for columns chat and recipient
		$this->createIndex( 'idx_' . $this->prefix . 'chat_msg_report_chat', $this->prefix . 'cmn_chat_message_report', 'chatId' );
		$this->createIndex( 'idx_' . $this->prefix . 'chat_msg_report_target', $this->prefix . 'cmn_chat_message_report', 'recipientId' );
	}

	private function upGroup() {

        $this->createTable( $this->prefix . 'cmn_group', [
			'id' => $this->bigPrimaryKey( 20 ),
			'siteId' => $this->bigInteger( 20 )->notNull(),
			'ownerId' => $this->bigInteger( 20 ),
			'avatarId' => $this->bigInteger( 20 ),
			'createdBy' => $this->bigInteger( 20 )->notNull(),
			'modifiedBy' => $this->bigInteger( 20 ),
			'name' => $this->string( Yii::$app->core->xLargeText )->notNull(),
			'slug' => $this->string( Yii::$app->core->xxLargeText )->notNull(),
			'type' => $this->string( Yii::$app->core->mediumText )->notNull(),
			'icon' => $this->string( Yii::$app->core->largeText )->defaultValue( null ),
			'texture' => $this->string( Yii::$app->core->largeText )->defaultValue( null ),
			'title' => $this->string( Yii::$app->core->xxxLargeText )->defaultValue( null ),
			'description' => $this->string( Yii::$app->core->xtraLargeText )->defaultValue( null ),
			'passwordHash' => $this->string( Yii::$app->core->xLargeText )->defaultValue( null ),
			'email' => $this->string( Yii::$app->core->xxLargeText )->defaultValue( null ),
			'status' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'visibility' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'order' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'pinned' => $this->boolean()->notNull()->defaultValue( false ),
			'featured' => $this->boolean()->notNull()->defaultValue( false ),
			'reviews' => $this->boolean()->notNull()->defaultValue( false ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'content' => $this->mediumText(),
			'data' => $this->mediumText(),
			'gridCache' => $this->longText(),
			'gridCacheValid' => $this->boolean()->notNull()->defaultValue( false ),
			'gridCachedAt' => $this->dateTime()
        ], $this->options );

        // Index for columns avatar, creator and modifier
		$this->createIndex( 'idx_' . $this->prefix . 'group_site', $this->prefix . 'cmn_group', 'siteId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_owner', $this->prefix . 'cmn_group', 'ownerId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_avatar', $this->prefix . 'cmn_group', 'avatarId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_creator', $this->prefix . 'cmn_group', 'createdBy' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_modifier', $this->prefix . 'cmn_group', 'modifiedBy' );
	}

	private function upGroupMeta() {

        $this->createTable( $this->prefix . 'cmn_group_meta', [
			'id' => $this->bigPrimaryKey( 20 ),
			'modelId' => $this->bigInteger( 20 )->notNull(),
			'icon' => $this->string( Yii::$app->core->largeText )->defaultValue( null ),
			'name' => $this->string( Yii::$app->core->xLargeText )->notNull(),
			'label' => $this->string( Yii::$app->core->xxLargeText )->notNull(),
			'type' => $this->string( Yii::$app->core->mediumText )->notNull(),
			'active' => $this->boolean()->defaultValue( false ),
			'order' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'valueType' => $this->string( Yii::$app->core->mediumText )->notNull()->defaultValue( Meta::VALUE_TYPE_TEXT ),
			'value' => $this->text(),
			'data' => $this->mediumText()
        ], $this->options );

        // Index for columns site, parent, creator and modifier
		$this->createIndex( 'idx_' . $this->prefix . 'group_meta_parent', $this->prefix . 'cmn_group_meta', 'modelId' );
	}

	private function upGroupFollower() {

        $this->createTable( $this->prefix . 'cmn_group_follower', [
			'id' => $this->bigPrimaryKey( 20 ),
			'modelId' => $this->bigInteger( 20 )->notNull(),
			'parentId' => $this->bigInteger( 20 )->notNull(),
			'type' => $this->string( Yii::$app->core->mediumText )->notNull(),
			'order' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'active' => $this->boolean()->notNull()->defaultValue( true ),
			'pinned' => $this->boolean()->notNull()->defaultValue( false ),
			'featured' => $this->boolean()->notNull()->defaultValue( false ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'data' => $this->mediumText()
        ], $this->options );

        // Index for columns user and model
		$this->createIndex( 'idx_' . $this->prefix . 'group_follower_user', $this->prefix . 'cmn_group_follower', 'modelId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_follower_parent', $this->prefix . 'cmn_group_follower', 'parentId' );
	}

	private function upGroupPost() {

        $this->createTable( $this->prefix . 'cmn_group_post', [
			'id' => $this->bigPrimaryKey( 20 ),
			'groupId' => $this->bigInteger( 20 )->notNull(),
			'publisherId' => $this->bigInteger( 20 )->defaultValue( null ),
			'parentId' => $this->bigInteger( 20 )->defaultValue( null ),
			'templateId' => $this->bigInteger( 20 )->defaultValue( null ),
			'galleryId' => $this->bigInteger( 20 )->defaultValue( null ),
			'avatarId' => $this->bigInteger( 20 )->defaultValue( null ),
			'bannerId' => $this->bigInteger( 20 )->defaultValue( null ),
			'videoId' => $this->bigInteger( 20 )->defaultValue( null ),
			'icon' => $this->string( Yii::$app->core->largeText )->defaultValue( null ),
			'texture' => $this->string( Yii::$app->core->largeText )->defaultValue( null ),
			'title' => $this->string( Yii::$app->core->xxxLargeText )->defaultValue( null ),
			'type' => $this->string( Yii::$app->core->mediumText )->defaultValue( CoreGlobal::TYPE_DEFAULT ),
			'status' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'visibility' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'pinned' => $this->boolean()->notNull()->defaultValue( false ),
			'featured' => $this->boolean()->notNull()->defaultValue( false ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'content' => $this->mediumText(),
			'data' => $this->mediumText(),
			'gridCache' => $this->longText(),
			'gridCacheValid' => $this->boolean()->notNull()->defaultValue( false ),
			'gridCachedAt' => $this->dateTime()
        ], $this->options );

        // Index for columns sender, recipient and group
		$this->createIndex( 'idx_' . $this->prefix . 'group_post_group', $this->prefix . 'cmn_group_post', 'groupId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_post_publisher', $this->prefix . 'cmn_group_post', 'publisherId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_post_parent', $this->prefix . 'cmn_user_post', 'parentId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_post_template', $this->prefix . 'cmn_group_post', 'templateId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_post_gallery', $this->prefix . 'cmn_group_post', 'galleryId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_post_avatar', $this->prefix . 'cmn_group_post', 'avatarId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_post_banner', $this->prefix . 'cmn_group_post', 'bannerId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_post_video', $this->prefix . 'cmn_group_post', 'videoId' );
	}

	private function upGroupPostMeta() {

        $this->createTable( $this->prefix . 'cmn_group_post_meta', [
			'id' => $this->bigPrimaryKey( 20 ),
			'modelId' => $this->bigInteger( 20 )->notNull(),
			'icon' => $this->string( Yii::$app->core->largeText )->defaultValue( null ),
			'name' => $this->string( Yii::$app->core->xLargeText )->notNull(),
			'label' => $this->string( Yii::$app->core->xxLargeText )->notNull(),
			'type' => $this->string( Yii::$app->core->mediumText )->notNull(),
			'active' => $this->boolean()->defaultValue( false ),
			'order' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'valueType' => $this->string( Yii::$app->core->mediumText )->notNull()->defaultValue( Meta::VALUE_TYPE_TEXT ),
			'value' => $this->text(),
			'data' => $this->mediumText()
        ], $this->options );

        // Index for columns site, parent, creator and modifier
		$this->createIndex( 'idx_' . $this->prefix . 'group_post_meta_parent', $this->prefix . 'cmn_group_post_meta', 'modelId' );
	}

	private function upGroupMember() {

        $this->createTable( $this->prefix . 'cmn_group_member', [
			'id' => $this->bigPrimaryKey( 20 ),
			'groupId' => $this->bigInteger( 20 )->notNull(),
			'userId' => $this->bigInteger( 20 )->notNull(),
			'roleId' => $this->bigInteger( 20 )->notNull(),
			'status' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'verifyToken' => $this->string( Yii::$app->core->largeText )->defaultValue( null ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'syncedAt' => $this->dateTime(),
			'data' => $this->mediumText()
        ], $this->options );

        // Index for columns group, user and role
		$this->createIndex( 'idx_' . $this->prefix . 'group_member_group', $this->prefix . 'cmn_group_member', 'groupId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_member_user', $this->prefix . 'cmn_group_member', 'userId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_member_role', $this->prefix . 'cmn_group_member', 'roleId' );
	}

	private function upGroupInvite() {

        $this->createTable( $this->prefix . 'cmn_group_invite', [
			'id' => $this->bigPrimaryKey( 20 ),
			'groupId' => $this->bigInteger( 20 )->notNull(),
			'userId' => $this->bigInteger( 20 )->defaultValue( null ),
			'roleId' => $this->bigInteger( 20 )->notNull(),
			'email' => $this->string( Yii::$app->core->xLargeText )->defaultValue( null ),
			'mobile' => $this->string( Yii::$app->core->mediumText )->defaultValue( null ),
			'service' => $this->string( Yii::$app->core->mediumText )->notNull(),
			'status' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'type' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'verifyToken' => $this->string( Yii::$app->core->largeText )->defaultValue( null ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'content' => $this->mediumText(),
			'data' => $this->mediumText(),
			'gridCache' => $this->longText(),
			'gridCacheValid' => $this->boolean()->notNull()->defaultValue( false ),
			'gridCachedAt' => $this->dateTime()
        ], $this->options );

        // Index for columns group and user
        $this->createIndex( 'idx_' . $this->prefix . 'group_invite_user', $this->prefix . 'cmn_group_invite', 'groupId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_invite_parent', $this->prefix . 'cmn_group_invite', 'userId' );
	}

	private function upGroupMessage() {

        $this->createTable( $this->prefix . 'cmn_group_message', [
			'id' => $this->bigPrimaryKey( 20 ),
			'senderId' => $this->bigInteger( 20 )->notNull(),
			'groupId' => $this->bigInteger( 20 )->notNull(),
			'avatarId' => $this->bigInteger( 20 )->defaultValue( null ),
			'bannerId' => $this->bigInteger( 20 )->defaultValue( null ),
			'videoId' => $this->bigInteger( 20 )->defaultValue( null ),
			'icon' => $this->string( Yii::$app->core->largeText )->defaultValue( null ),
			'texture' => $this->string( Yii::$app->core->largeText )->defaultValue( null ),
			'type' => $this->string( Yii::$app->core->mediumText )->defaultValue( CoreGlobal::TYPE_DEFAULT ),
			'code' => $this->string( Yii::$app->core->mediumText )->defaultValue( null ),
			'broadcasted' => $this->boolean()->notNull()->defaultValue( false ),
			'delivered' => $this->boolean()->notNull()->defaultValue( false ),
			'consumed' => $this->boolean()->notNull()->defaultValue( false ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'content' => $this->mediumText(),
			'data' => $this->mediumText(),
			'gridCache' => $this->longText(),
			'gridCacheValid' => $this->boolean()->notNull()->defaultValue( false ),
			'gridCachedAt' => $this->dateTime()
        ], $this->options );

        // Index for columns sender and group
		$this->createIndex( 'idx_' . $this->prefix . 'group_message_sender', $this->prefix . 'cmn_group_message', 'senderId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_message_group', $this->prefix . 'cmn_group_message', 'groupId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_message_avatar', $this->prefix . 'cmn_group_message', 'avatarId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_message_banner', $this->prefix . 'cmn_group_message', 'bannerId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_message_video', $this->prefix . 'cmn_group_message', 'videoId' );
	}

	private function upGroupMessageReport() {

        $this->createTable( $this->prefix . 'cmn_group_message_report', [
			'id' => $this->bigPrimaryKey( 20 ),
			'groupId' => $this->bigInteger( 20 )->notNull(),
			'recipientId' => $this->bigInteger( 20 )->notNull(),
			'sent' => $this->boolean()->notNull()->defaultValue( false ),
			'received' => $this->boolean()->notNull()->defaultValue( false ),
			'consumed' => $this->boolean()->notNull()->defaultValue( false ),
			'sentAt' => $this->dateTime()->notNull(),
			'receivedAt' => $this->dateTime(),
			'consumedAt' => $this->dateTime(),
			'gridCache' => $this->longText(),
			'gridCacheValid' => $this->boolean()->notNull()->defaultValue( false ),
			'gridCachedAt' => $this->dateTime()
        ], $this->options );

        // Index for columns group and recipient
		$this->createIndex( 'idx_' . $this->prefix . 'group_msg_report_group', $this->prefix . 'cmn_group_message_report', 'groupId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_msg_report_target', $this->prefix . 'cmn_group_message_report', 'recipientId' );
	}

	private function generateForeignKeys() {

		// Friend
		$this->addForeignKey( 'fk_' . $this->prefix . 'friend_user', $this->prefix . 'cmn_friend', 'userId', $this->prefix . 'core_user', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'friend_parent', $this->prefix . 'cmn_friend', 'friendId', $this->prefix . 'core_user', 'id', 'CASCADE' );

		// Friend Invite
		$this->addForeignKey( 'fk_' . $this->prefix . 'friend_invite_user', $this->prefix . 'cmn_friend_invite', 'userId', $this->prefix . 'core_user', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'friend_invite_parent', $this->prefix . 'cmn_friend_invite', 'friendId', $this->prefix . 'core_user', 'id', 'CASCADE' );

		// User Follower
        $this->addForeignKey( 'fk_' . $this->prefix . 'user_follower_user', $this->prefix . 'cmn_user_follower', 'modelId', $this->prefix . 'core_user', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'user_follower_parent', $this->prefix . 'cmn_user_follower', 'parentId', $this->prefix . 'core_user', 'id', 'CASCADE' );

		// User Post
		$this->addForeignKey( 'fk_' . $this->prefix . 'user_post_user', $this->prefix . 'cmn_user_post', 'userId', $this->prefix . 'core_user', 'id', 'CASCADE' );
        $this->addForeignKey( 'fk_' . $this->prefix . 'user_post_sender', $this->prefix . 'cmn_user_post', 'senderId', $this->prefix . 'core_user', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'user_post_parent', $this->prefix . 'cmn_user_post', 'parentId', $this->prefix . 'cmn_user_post', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'user_post_gallery', $this->prefix . 'cmn_user_post', 'galleryId', $this->prefix . 'core_gallery', 'id', 'SET NULL' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'user_post_avatar', $this->prefix . 'cmn_user_post', 'avatarId', $this->prefix . 'core_file', 'id', 'SET NULL' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'user_post_banner', $this->prefix . 'cmn_user_post', 'bannerId', $this->prefix . 'core_file', 'id', 'SET NULL' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'user_post_video', $this->prefix . 'cmn_user_post', 'videoId', $this->prefix . 'core_file', 'id', 'SET NULL' );

		// User Post Meta
        $this->addForeignKey( 'fk_' . $this->prefix . 'user_post_meta_parent', $this->prefix . 'cmn_user_post_meta', 'modelId', $this->prefix . 'cmn_user_post', 'id', 'CASCADE' );

		// Chat
        $this->addForeignKey( 'fk_' . $this->prefix . 'chat_creator', $this->prefix . 'cmn_chat', 'createdBy', $this->prefix . 'core_user', 'id', 'RESTRICT' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'chat_modifier', $this->prefix . 'cmn_chat', 'modifiedBy', $this->prefix . 'core_user', 'id', 'SET NULL' );

		// Chat Member
        $this->addForeignKey( 'fk_' . $this->prefix . 'chat_member_parent', $this->prefix . 'cmn_chat_member', 'chatId', $this->prefix . 'cmn_chat', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'chat_member_user', $this->prefix . 'cmn_chat_member', 'userId', $this->prefix . 'core_user', 'id', 'CASCADE' );

		// Chat Message
        $this->addForeignKey( 'fk_' . $this->prefix . 'chat_message_sender', $this->prefix . 'cmn_chat_message', 'senderId', $this->prefix . 'core_user', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'chat_message_recipient', $this->prefix . 'cmn_chat_message', 'recipientId', $this->prefix . 'core_user', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'chat_message_parent', $this->prefix . 'cmn_chat_message', 'chatId', $this->prefix . 'cmn_chat', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'chat_message_avatar', $this->prefix . 'cmn_chat_message', 'avatarId', $this->prefix . 'core_file', 'id', 'SET NULL' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'chat_message_banner', $this->prefix . 'cmn_chat_message', 'bannerId', $this->prefix . 'core_file', 'id', 'SET NULL' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'chat_message_video', $this->prefix . 'cmn_chat_message', 'videoId', $this->prefix . 'core_file', 'id', 'SET NULL' );

		// Chat Message Report
		$this->addForeignKey( 'fk_' . $this->prefix . 'chat_msg_report_chat', $this->prefix . 'cmn_chat_message_report', 'chatId', $this->prefix . 'cmn_chat', 'id', 'CASCADE' );
        $this->addForeignKey( 'fk_' . $this->prefix . 'chat_msg_report_target', $this->prefix . 'cmn_chat_message_report', 'recipientId', $this->prefix . 'core_user', 'id', 'CASCADE' );

		// Group
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_site', $this->prefix . 'cmn_group', 'siteId', $this->prefix . 'core_site', 'id', 'RESTRICT' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_owner', $this->prefix . 'cmn_group', 'ownerId', $this->prefix . 'core_user', 'id', 'SET NULL' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_avatar', $this->prefix . 'cmn_group', 'avatarId', $this->prefix . 'core_file', 'id', 'SET NULL' );
        $this->addForeignKey( 'fk_' . $this->prefix . 'group_creator', $this->prefix . 'cmn_group', 'createdBy', $this->prefix . 'core_user', 'id', 'RESTRICT' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_modifier', $this->prefix . 'cmn_group', 'modifiedBy', $this->prefix . 'core_user', 'id', 'SET NULL' );

		// Group Meta
        $this->addForeignKey( 'fk_' . $this->prefix . 'group_meta_parent', $this->prefix . 'cmn_group_meta', 'modelId', $this->prefix . 'cmn_group', 'id', 'CASCADE' );

		// Group Follower
        $this->addForeignKey( 'fk_' . $this->prefix . 'group_follower_user', $this->prefix . 'cmn_group_follower', 'modelId', $this->prefix . 'core_user', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_follower_parent', $this->prefix . 'cmn_group_follower', 'parentId', $this->prefix . 'cmn_group', 'id', 'CASCADE' );

		// Group Post
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_post_group', $this->prefix . 'cmn_group_post', 'groupId', $this->prefix . 'cmn_group', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_post_publisher', $this->prefix . 'cmn_group_post', 'publisherId', $this->prefix . 'core_user', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_post_parent', $this->prefix . 'cmn_group_post', 'parentId', $this->prefix . 'cmn_group_post', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_post_template', $this->prefix . 'cmn_group_post', 'templateId', $this->prefix . 'core_template', 'id', 'SET NULL' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_post_gallery', $this->prefix . 'cmn_group_post', 'galleryId', $this->prefix . 'core_gallery', 'id', 'SET NULL' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_post_avatar', $this->prefix . 'cmn_group_post', 'avatarId', $this->prefix . 'core_file', 'id', 'SET NULL' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_post_banner', $this->prefix . 'cmn_group_post', 'bannerId', $this->prefix . 'core_file', 'id', 'SET NULL' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_post_video', $this->prefix . 'cmn_group_post', 'videoId', $this->prefix . 'core_file', 'id', 'SET NULL' );

		// Group Post Meta
        $this->addForeignKey( 'fk_' . $this->prefix . 'group_post_meta_parent', $this->prefix . 'cmn_group_post_meta', 'modelId', $this->prefix . 'cmn_group_post', 'id', 'CASCADE' );

		// Group Member
        $this->addForeignKey( 'fk_' . $this->prefix . 'group_member_group', $this->prefix . 'cmn_group_member', 'groupId', $this->prefix . 'cmn_group', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_member_user', $this->prefix . 'cmn_group_member', 'userId', $this->prefix . 'core_user', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_member_role', $this->prefix . 'cmn_group_member', 'roleId', $this->prefix . 'core_role', 'id', 'CASCADE' );

		// Group Invite
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_invite_user', $this->prefix . 'cmn_group_invite', 'groupId', $this->prefix . 'cmn_group', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_invite_parent', $this->prefix . 'cmn_group_invite', 'userId', $this->prefix . 'core_user', 'id', 'CASCADE' );

		// Group Message
        $this->addForeignKey( 'fk_' . $this->prefix . 'group_message_sender', $this->prefix . 'cmn_group_message', 'senderId', $this->prefix . 'core_user', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_message_group', $this->prefix . 'cmn_group_message', 'groupId', $this->prefix . 'cmn_group', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_message_avatar', $this->prefix . 'cmn_group_message', 'avatarId', $this->prefix . 'core_file', 'id', 'SET NULL' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_message_banner', $this->prefix . 'cmn_group_message', 'bannerId', $this->prefix . 'core_file', 'id', 'SET NULL' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_message_video', $this->prefix . 'cmn_group_message', 'videoId', $this->prefix . 'core_file', 'id', 'SET NULL' );

		// Group Message Report
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_msg_report_group', $this->prefix . 'cmn_group_message_report', 'groupId', $this->prefix . 'cmn_group', 'id', 'CASCADE' );
        $this->addForeignKey( 'fk_' . $this->prefix . 'group_msg_report_target', $this->prefix . 'cmn_group_message_report', 'recipientId', $this->prefix . 'core_user', 'id', 'CASCADE' );
	}

    public function down() {

		if( $this->fk ) {

			$this->dropForeignKeys();
		}

		// Friend
		$this->dropTable( $this->prefix . 'cmn_friend' );
		$this->dropTable( $this->prefix . 'cmn_friend_invite' );

		// User
		$this->dropTable( $this->prefix . 'cmn_user_follower' );
		$this->dropTable( $this->prefix . 'cmn_user_post' );
		$this->dropTable( $this->prefix . 'cmn_user_post_meta' );

		// Chat
        $this->dropTable( $this->prefix . 'cmn_chat' );
		$this->dropTable( $this->prefix . 'cmn_chat_member' );
		$this->dropTable( $this->prefix . 'cmn_chat_message' );
		$this->dropTable( $this->prefix . 'cmn_chat_message_report' );

		// Group
        $this->dropTable( $this->prefix . 'cmn_group' );
		$this->dropTable( $this->prefix . 'cmn_group_meta' );
		$this->dropTable( $this->prefix . 'cmn_group_follower' );
		$this->dropTable( $this->prefix . 'cmn_group_post' );
		$this->dropTable( $this->prefix . 'cmn_group_post_meta' );
		$this->dropTable( $this->prefix . 'cmn_group_member' );
		$this->dropTable( $this->prefix . 'cmn_group_invite' );
		$this->dropTable( $this->prefix . 'cmn_group_message' );
		$this->dropTable( $this->prefix . 'cmn_group_message_report' );
    }

	private function dropForeignKeys() {

		// Friend
		$this->dropForeignKey( 'fk_' . $this->prefix . 'friend_user', $this->prefix . 'cmn_friend' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'friend_parent', $this->prefix . 'cmn_friend' );

		// Friend Invite
		$this->dropForeignKey( 'fk_' . $this->prefix . 'friend_invite_user', $this->prefix . 'cmn_friend_invite' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'friend_invite_parent', $this->prefix . 'cmn_friend_invite' );

		// User Follower
        $this->dropForeignKey( 'fk_' . $this->prefix . 'user_follower_user', $this->prefix . 'cmn_user_follower' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'user_follower_parent', $this->prefix . 'cmn_user_follower' );

		// User Post
		$this->dropForeignKey( 'fk_' . $this->prefix . 'user_post_user', $this->prefix . 'cmn_user_post' );
        $this->dropForeignKey( 'fk_' . $this->prefix . 'user_post_sender', $this->prefix . 'cmn_user_post' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'user_post_parent', $this->prefix . 'cmn_user_post' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'user_post_gallery', $this->prefix . 'cmn_user_post' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'user_post_avatar', $this->prefix . 'cmn_user_post' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'user_post_banner', $this->prefix . 'cmn_user_post' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'user_post_video', $this->prefix . 'cmn_user_post' );

		// User Post Meta
        $this->dropForeignKey( 'fk_' . $this->prefix . 'user_post_meta_parent', $this->prefix . 'cmn_user_post_meta' );

		// Chat
        $this->dropForeignKey( 'fk_' . $this->prefix . 'chat_creator', $this->prefix . 'cmn_chat' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'chat_modifier', $this->prefix . 'cmn_chat' );

		// Chat Member
        $this->dropForeignKey( 'fk_' . $this->prefix . 'chat_member_parent', $this->prefix . 'cmn_chat_member' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'chat_member_user', $this->prefix . 'cmn_chat_member' );

		// Chat Message
        $this->dropForeignKey( 'fk_' . $this->prefix . 'chat_message_sender', $this->prefix . 'cmn_chat_message' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'chat_message_recipient', $this->prefix . 'cmn_chat_message' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'chat_message_parent', $this->prefix . 'cmn_chat_message' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'chat_message_avatar', $this->prefix . 'cmn_chat_message' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'chat_message_banner', $this->prefix . 'cmn_chat_message' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'chat_message_video', $this->prefix . 'cmn_chat_message' );

		// Chat Message Report
		$this->dropForeignKey( 'fk_' . $this->prefix . 'chat_msg_report_chat', $this->prefix . 'cmn_chat_message_report' );
        $this->dropForeignKey( 'fk_' . $this->prefix . 'chat_msg_report_target', $this->prefix . 'cmn_chat_message_report' );

		// Group
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_site', $this->prefix . 'cmn_group' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_owner', $this->prefix . 'cmn_group' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_avatar', $this->prefix . 'cmn_group' );
        $this->dropForeignKey( 'fk_' . $this->prefix . 'group_creator', $this->prefix . 'cmn_group' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_modifier', $this->prefix . 'cmn_group' );

		// Group Meta
        $this->dropForeignKey( 'fk_' . $this->prefix . 'group_meta_parent', $this->prefix . 'cmn_group_meta' );

		// Group Follower
        $this->dropForeignKey( 'fk_' . $this->prefix . 'group_follower_user', $this->prefix . 'cmn_group_follower' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_follower_parent', $this->prefix . 'cmn_group_follower' );

		// Group Post
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_post_group', $this->prefix . 'cmn_group_post' );
        $this->dropForeignKey( 'fk_' . $this->prefix . 'group_post_publisher', $this->prefix . 'cmn_group_post' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_post_parent', $this->prefix . 'cmn_group_post' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_post_template', $this->prefix . 'cmn_group_post' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_post_gallery', $this->prefix . 'cmn_group_post' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_post_avatar', $this->prefix . 'cmn_group_post' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_post_banner', $this->prefix . 'cmn_group_post' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_post_video', $this->prefix . 'cmn_group_post' );

		// Group Post Meta
        $this->dropForeignKey( 'fk_' . $this->prefix . 'group_post_meta_parent', $this->prefix . 'cmn_group_post_meta' );

		// Group Member
        $this->dropForeignKey( 'fk_' . $this->prefix . 'group_member_group', $this->prefix . 'cmn_group_member' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_member_user', $this->prefix . 'cmn_group_member' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_member_role', $this->prefix . 'cmn_group_member' );

		// Group Invite
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_invite_user', $this->prefix . 'cmn_group_invite' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_invite_parent', $this->prefix . 'cmn_group_invite' );

		// Group Message
        $this->dropForeignKey( 'fk_' . $this->prefix . 'group_message_sender', $this->prefix . 'cmn_group_message' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_message_group', $this->prefix . 'cmn_group_message' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_message_avatar', $this->prefix . 'cmn_group_message' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_message_banner', $this->prefix . 'cmn_group_message' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_message_video', $this->prefix . 'cmn_group_message' );

		// Group Message Report
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_msg_report_group', $this->prefix . 'cmn_group_message_report' );
        $this->dropForeignKey( 'fk_' . $this->prefix . 'group_msg_report_target', $this->prefix . 'cmn_group_message_report' );
	}

}
