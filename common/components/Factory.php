<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\community\common\components;

// Yii Imports
use Yii;

/**
 * The Community Factory component initialise the services available in Community Module.
 *
 * @since 1.0.0
 */
class Factory extends \cmsgears\core\common\base\Component {

	// Global -----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Register services
		$this->registerServices();

		// Register service alias
		$this->registerServiceAlias();
	}

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// Factory -------------------------------

	public function registerServices() {

		$this->registerResourceServices();
		$this->registerMapperServices();
		$this->registerEntityServices();
	}

	public function registerServiceAlias() {

		$this->registerResourceAliases();
		$this->registerMapperAliases();
		$this->registerEntityAliases();
	}

	/**
	 * Registers resource services.
	 */
	public function registerResourceServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'cmsgears\community\common\services\interfaces\resources\user\IPostService', 'cmsgears\community\common\services\resources\user\PostService' );
		$factory->set( 'cmsgears\community\common\services\interfaces\resources\user\IPostMetaService', 'cmsgears\community\common\services\resources\user\PostMetaService' );

		$factory->set( 'cmsgears\community\common\services\interfaces\resources\chat\IMessageService', 'cmsgears\community\common\services\resources\chat\MessageService' );

		$factory->set( 'cmsgears\community\common\services\interfaces\resources\group\IMetaService', 'cmsgears\community\common\services\resources\group\MetaService' );
		$factory->set( 'cmsgears\community\common\services\interfaces\resources\group\IMessageService', 'cmsgears\community\common\services\resources\group\MessageService' );
		$factory->set( 'cmsgears\community\common\services\interfaces\resources\group\IPostService', 'cmsgears\community\common\services\resources\group\PostService' );
		$factory->set( 'cmsgears\community\common\services\interfaces\resources\group\IPostMetaService', 'cmsgears\community\common\services\resources\group\PostMetaService' );
	}

	/**
	 * Registers mapper services.
	 */
	public function registerMapperServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'cmsgears\community\common\services\interfaces\mappers\IFriendService', 'cmsgears\community\common\services\mappers\FriendService' );

		$factory->set( 'cmsgears\community\common\services\interfaces\mappers\IUserFollowerService', 'cmsgears\community\common\services\mappers\UserFollowerService' );

		$factory->set( 'cmsgears\community\common\services\interfaces\mappers\IChatMemberService', 'cmsgears\community\common\services\mappers\ChatMemberService' );

		$factory->set( 'cmsgears\community\common\services\interfaces\mappers\IGroupFollowerService', 'cmsgears\community\common\services\mappers\GroupFollowerService' );
		$factory->set( 'cmsgears\community\common\services\interfaces\mappers\IGroupMemberService', 'cmsgears\community\common\services\mappers\GroupMemberService' );
	}

	/**
	 * Registers entity services.
	 */
	public function registerEntityServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'cmsgears\community\common\services\interfaces\entities\IChatService', 'cmsgears\community\common\services\entities\ChatService' );

		$factory->set( 'cmsgears\community\common\services\interfaces\entities\IGroupService', 'cmsgears\community\common\services\entities\GroupService' );
	}

	/**
	 * Registers resource aliases.
	 */
	public function registerResourceAliases() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'userPostService', 'cmsgears\community\common\services\resources\user\PostService' );
		$factory->set( 'userPostMetaService', 'cmsgears\community\common\services\resources\user\PostMetaService' );

		$factory->set( 'chatMessageService', 'cmsgears\community\common\services\resources\chat\MessageService' );

		$factory->set( 'groupMetaService', 'cmsgears\community\common\services\resources\group\MetaService' );
		$factory->set( 'groupMessageService', 'cmsgears\community\common\services\resources\group\MessageService' );
		$factory->set( 'groupPostService', 'cmsgears\community\common\services\resources\group\PostService' );
		$factory->set( 'groupPostMetaService', 'cmsgears\community\common\services\resources\group\PostMetaService' );
	}

	/**
	 * Registers mapper aliases.
	 */
	public function registerMapperAliases() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'friendService', 'cmsgears\community\common\services\mappers\FriendService' );

		$factory->set( 'userFollowerService', 'cmsgears\community\common\services\mappers\UserFollowerService' );

		$factory->set( 'chatMemberService', 'cmsgears\community\common\services\mappers\ChatMemberService' );

		$factory->set( 'groupFollowerService', 'cmsgears\community\common\services\mappers\GroupFollowerService' );
		$factory->set( 'groupMemberService', 'cmsgears\community\common\services\mappers\GroupMemberService' );
	}

	/**
	 * Registers entity aliases.
	 */
	public function registerEntityAliases() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'chatService', 'cmsgears\community\common\services\entities\ChatService' );

		$factory->set( 'groupService', 'cmsgears\community\common\services\entities\GroupService' );
	}

}
