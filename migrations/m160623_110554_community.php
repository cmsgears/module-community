<?php
// CMG Imports
use cmsgears\core\common\config\CoreGlobal;


class m160623_110554_community extends \yii\db\Migration {

	// Public Variables

	public $fk;
	public $options;

	// Private Variables

	private $prefix;

	public function init() {

		// Fixed
		$this->prefix		= 'cmg_';

		// Get the values via config
		$this->fk			= Yii::$app->migration->isFk();
		$this->options		= Yii::$app->migration->getTableOptions();

		// Default collation
		if( $this->db->driverName === 'mysql' ) {

			$this->options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}
	}

    public function up() {

		// Friend
		$this->upFriend();

		// Chat
		$this->upChat();
		$this->upChatMember();

		// Group
		$this->upGroup();
		$this->upGroupMember();

		// Post
		$this->upPost();

		// Message
		$this->upChatMessage();
		$this->upGroupMessage();

		// Follower
		$this->upFollower();

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
			'type' => $this->string( CoreGlobal::TEXT_MEDIUM )->notNull(),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'content' => $this->text(),
			'data' => $this->text()
        ], $this->options );

        // Index for columns user and friend
        $this->createIndex( 'idx_' . $this->prefix . 'friend_user', $this->prefix . 'cmn_friend', 'userId' );
		$this->createIndex( 'idx_' . $this->prefix . 'friend_parent', $this->prefix . 'cmn_friend', 'friendId' );
	}

	private function upChat() {

        $this->createTable( $this->prefix . 'cmn_chat', [
			'id' => $this->bigPrimaryKey( 20 ),
			'createdBy' => $this->bigInteger( 20 )->notNull(),
			'modifiedBy' => $this->bigInteger( 20 ),
			'sessionId' => $this->string( CoreGlobal::TEXT_XLARGE )->notNull(),
			'status' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime()
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
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'syncedAt' => $this->dateTime()
        ], $this->options );

        // Index for columns creator and modifier
		$this->createIndex( 'idx_' . $this->prefix . 'chat_member_chat', $this->prefix . 'cmn_chat_member', 'chatId' );
		$this->createIndex( 'idx_' . $this->prefix . 'chat_member_user', $this->prefix . 'cmn_chat_member', 'userId' );
	}

	private function upGroup() {

        $this->createTable( $this->prefix . 'cmn_group', [
			'id' => $this->bigPrimaryKey( 20 ),
			'avatarId' => $this->bigInteger( 20 ),
			'createdBy' => $this->bigInteger( 20 )->notNull(),
			'modifiedBy' => $this->bigInteger( 20 ),
			'name' => $this->string( CoreGlobal::TEXT_LARGE )->notNull(),
			'slug' => $this->string( CoreGlobal::TEXT_XLARGE )->notNull(),
			'type' => $this->string( CoreGlobal::TEXT_MEDIUM )->notNull(),
			'icon' => $this->string( CoreGlobal::TEXT_MEDIUM )->defaultValue( null ),
			'description' => $this->string( CoreGlobal::TEXT_XLARGE )->defaultValue( null ),
			'status' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'visibility' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'content' => $this->text(),
			'data' => $this->text()
        ], $this->options );

        // Index for columns avatar, creator and modifier
		$this->createIndex( 'idx_' . $this->prefix . 'group_avatar', $this->prefix . 'cmn_group', 'avatarId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_creator', $this->prefix . 'cmn_group', 'createdBy' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_modifier', $this->prefix . 'cmn_group', 'modifiedBy' );
	}

	private function upGroupMember() {

        $this->createTable( $this->prefix . 'cmn_group_member', [
			'id' => $this->bigPrimaryKey( 20 ),
			'groupId' => $this->bigInteger( 20 )->notNull(),
			'userId' => $this->bigInteger( 20 )->notNull(),
			'roleId' => $this->bigInteger( 20 ),
			'status' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'syncedAt' => $this->dateTime()
        ], $this->options );

        // Index for columns group, user and role
		$this->createIndex( 'idx_' . $this->prefix . 'group_member_group', $this->prefix . 'cmn_group_member', 'groupId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_member_user', $this->prefix . 'cmn_group_member', 'userId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_member_role', $this->prefix . 'cmn_group_member', 'roleId' );
	}

	private function upPost() {

        $this->createTable( $this->prefix . 'cmn_post', [
			'id' => $this->bigPrimaryKey( 20 ),
			'senderId' => $this->bigInteger( 20 )->notNull(),
			'recipientId' => $this->bigInteger( 20 ),
			'groupId' => $this->bigInteger( 20 ),
			'visibility' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'type' => $this->string( CoreGlobal::TEXT_MEDIUM )->notNull(),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'content' => $this->text(),
			'data' => $this->text()
        ], $this->options );

        // Index for columns sender, recipient and group
		$this->createIndex( 'idx_' . $this->prefix . 'cmn_post_sender', $this->prefix . 'cmn_post', 'senderId' );
		$this->createIndex( 'idx_' . $this->prefix . 'cmn_post_recipient', $this->prefix . 'cmn_post', 'recipientId' );
		$this->createIndex( 'idx_' . $this->prefix . 'cmn_post_group', $this->prefix . 'cmn_post', 'groupId' );
	}

	private function upChatMessage() {

        $this->createTable( $this->prefix . 'cmn_chat_message', [
			'id' => $this->bigPrimaryKey( 20 ),
			'senderId' => $this->bigInteger( 20 )->notNull(),
			'recipientId' => $this->bigInteger( 20 ),
			'chatId' => $this->bigInteger( 20 ),
			'consumed' => $this->boolean()->notNull()->defaultValue( false ),
			'type' => $this->string( CoreGlobal::TEXT_MEDIUM )->defaultValue( 'default' ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'content' => $this->text(),
			'data' => $this->text()
        ], $this->options );

        // Index for columns sender, recipient and chat
		$this->createIndex( 'idx_' . $this->prefix . 'chat_message_sender', $this->prefix . 'cmn_chat_message', 'senderId' );
		$this->createIndex( 'idx_' . $this->prefix . 'chat_message_recipient', $this->prefix . 'cmn_chat_message', 'recipientId' );
		$this->createIndex( 'idx_' . $this->prefix . 'chat_message_chat', $this->prefix . 'cmn_chat_message', 'chatId' );
	}

	private function upGroupMessage() {

        $this->createTable( $this->prefix . 'cmn_group_message', [
			'id' => $this->bigPrimaryKey( 20 ),
			'senderId' => $this->bigInteger( 20 )->notNull(),
			'groupId' => $this->bigInteger( 20 ),
			'type' => $this->string( CoreGlobal::TEXT_MEDIUM )->defaultValue( 'default' ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'content' => $this->text(),
			'data' => $this->text()
        ], $this->options );

        // Index for columns sender and group
		$this->createIndex( 'idx_' . $this->prefix . 'group_message_sender', $this->prefix . 'cmn_group_message', 'senderId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_message_group', $this->prefix . 'cmn_group_message', 'groupId' );
	}

	private function upFollower() {

        $this->createTable( $this->prefix . 'cmn_follower', [
			'id' => $this->bigPrimaryKey( 20 ),
			'userId' => $this->bigInteger( 20 )->notNull(),
			'parentId' => $this->bigInteger( 20 )->notNull(),
			'parentType' => $this->string( CoreGlobal::TEXT_MEDIUM )->notNull(),
			'type' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'active' => $this->boolean()->notNull()->defaultValue( false ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime()
        ], $this->options );

        // Index for columns sender and group
		$this->createIndex( 'idx_' . $this->prefix . 'follower_user', $this->prefix . 'cmn_follower', 'userId' );
	}

	private function generateForeignKeys() {

		// Friend
		$this->addForeignKey( 'fk_' . $this->prefix . 'friend_user', $this->prefix . 'cmn_friend', 'userId', $this->prefix . 'core_user', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'friend_parent', $this->prefix . 'cmn_friend', 'friendId', $this->prefix . 'core_user', 'id', 'CASCADE' );

		// Chat
        $this->addForeignKey( 'fk_' . $this->prefix . 'chat_creator', $this->prefix . 'cmn_chat', 'createdBy', $this->prefix . 'core_user', 'id', 'RESTRICT' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'chat_modifier', $this->prefix . 'cmn_chat', 'modifiedBy', $this->prefix . 'core_user', 'id', 'SET NULL' );

		// Chat Member
        $this->addForeignKey( 'fk_' . $this->prefix . 'chat_member_chat', $this->prefix . 'cmn_chat_member', 'chatId', $this->prefix . 'cmn_chat', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'chat_member_user', $this->prefix . 'cmn_chat_member', 'userId', $this->prefix . 'core_user', 'id', 'CASCADE' );

		// Group
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_avatar', $this->prefix . 'cmn_group', 'avatarId', $this->prefix . 'core_file', 'id', 'SET NULL' );
        $this->addForeignKey( 'fk_' . $this->prefix . 'group_creator', $this->prefix . 'cmn_group', 'createdBy', $this->prefix . 'core_user', 'id', 'RESTRICT' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_modifier', $this->prefix . 'cmn_group', 'modifiedBy', $this->prefix . 'core_user', 'id', 'SET NULL' );

		// Group Member
        $this->addForeignKey( 'fk_' . $this->prefix . 'group_member_group', $this->prefix . 'cmn_group_member', 'groupId', $this->prefix . 'cmn_group', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_member_user', $this->prefix . 'cmn_group_member', 'userId', $this->prefix . 'core_user', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_member_role', $this->prefix . 'cmn_group_member', 'roleId', $this->prefix . 'core_role', 'id', 'SET NULL' );

		// Post
        $this->addForeignKey( 'fk_' . $this->prefix . 'cmn_post_sender', $this->prefix . 'cmn_post', 'senderId', $this->prefix . 'core_user', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'cmn_post_recipient', $this->prefix . 'cmn_post', 'recipientId', $this->prefix . 'core_user', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'cmn_post_group', $this->prefix . 'cmn_post', 'groupId', $this->prefix . 'cmn_group', 'id', 'CASCADE' );

		// Chat Message
        $this->addForeignKey( 'fk_' . $this->prefix . 'chat_message_sender', $this->prefix . 'cmn_chat_message', 'senderId', $this->prefix . 'core_user', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'chat_message_recipient', $this->prefix . 'cmn_chat_message', 'recipientId', $this->prefix . 'core_user', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'chat_message_chat', $this->prefix . 'cmn_chat_message', 'chatId', $this->prefix . 'cmn_chat', 'id', 'CASCADE' );

		// Group Message
        $this->addForeignKey( 'fk_' . $this->prefix . 'group_message_sender', $this->prefix . 'cmn_group_message', 'senderId', $this->prefix . 'core_user', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_message_group', $this->prefix . 'cmn_group_message', 'groupId', $this->prefix . 'cmn_group', 'id', 'CASCADE' );

		// Follower
        $this->addForeignKey( 'fk_' . $this->prefix . 'follower_user', $this->prefix . 'cmn_follower', 'userId', $this->prefix . 'core_user', 'id', 'CASCADE' );
	}

    public function down() {

		if( $this->fk ) {

			$this->dropForeignKeys();
		}

		// Friend
		$this->dropTable( $this->prefix . 'cmn_friend' );

		// Chat
        $this->dropTable( $this->prefix . 'cmn_chat' );
		$this->dropTable( $this->prefix . 'cmn_chat_member' );

		// Group
        $this->dropTable( $this->prefix . 'cmn_group' );
		$this->dropTable( $this->prefix . 'cmn_group_member' );

		// Post
		$this->dropTable( $this->prefix . 'cmn_post' );

		// Message
		$this->dropTable( $this->prefix . 'cmn_chat_message' );
		$this->dropTable( $this->prefix . 'cmn_group_message' );

		// Follower
		$this->dropTable( $this->prefix . 'cmn_follower' );
    }

	private function dropForeignKeys() {

		// Friend
		$this->dropForeignKey( 'fk_' . $this->prefix . 'friend_user', $this->prefix . 'cmn_friend' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'friend_parent', $this->prefix . 'cmn_friend' );

		// Chat
        $this->dropForeignKey( 'fk_' . $this->prefix . 'chat_creator', $this->prefix . 'cmn_chat' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'chat_modifier', $this->prefix . 'cmn_chat' );

		// Chat Member
        $this->dropForeignKey( 'fk_' . $this->prefix . 'chat_member_chat', $this->prefix . 'cmn_chat_member' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'chat_member_user', $this->prefix . 'cmn_chat_member' );

		// Group
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_avatar', $this->prefix . 'cmn_group' );
        $this->dropForeignKey( 'fk_' . $this->prefix . 'group_creator', $this->prefix . 'cmn_group' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_modifier', $this->prefix . 'cmn_group' );

		// Group Member
        $this->dropForeignKey( 'fk_' . $this->prefix . 'group_member_group', $this->prefix . 'cmn_group_member' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_member_user', $this->prefix . 'cmn_group_member' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_member_role', $this->prefix . 'cmn_group_member' );

		// Post
        $this->dropForeignKey( 'fk_' . $this->prefix . 'cmn_post_sender', $this->prefix . 'cmn_post' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'cmn_post_recipient', $this->prefix . 'cmn_post' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'cmn_post_group', $this->prefix . 'cmn_post' );

		// Chat Message
        $this->dropForeignKey( 'fk_' . $this->prefix . 'chat_message_sender', $this->prefix . 'cmn_chat_message' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'chat_message_recipient', $this->prefix . 'cmn_chat_message' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'chat_message_chat', $this->prefix . 'cmn_chat_message' );

		// Group Message
        $this->dropForeignKey( 'fk_' . $this->prefix . 'group_message_sender', $this->prefix . 'cmn_group_message' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_message_group', $this->prefix . 'cmn_group_message' );

		// Follower
        $this->dropForeignKey( 'fk_' . $this->prefix . 'follower_user', $this->prefix . 'cmn_follower' );
	}
}

?>