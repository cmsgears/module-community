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
use yii\base\Component;

/**
 * Community component register the services provided by Community Module.
 *
 * @since 1.0.0
 */
class Community extends Component {

	// Global -----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	/**
	 * Initialize the services.
	 */
	public function init() {

		parent::init();

		// Register components and objects
		$this->registerComponents();
	}

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// Cms -----------------------------------

	// Properties ----------------

	// Components and Objects ----

	/**
	 * Register the services.
	 */
	public function registerComponents() {

		// Init system services
		$this->initSystemServices();

		// Register services
		$this->registerResourceServices();
		$this->registerMapperServices();
		$this->registerEntityServices();

		// Init services
		$this->initResourceServices();
		$this->initMapperServices();
		$this->initEntityServices();
	}

	/**
	 * Register and initialize system services.
	 */
	public function initSystemServices() {

		$factory = Yii::$app->factory->getContainer();

		//$factory->set( '<name>', '<classpath>' );
	}

	/**
	 * Registers resource services.
	 */
	public function registerResourceServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'cmsgears\community\common\services\interfaces\resources\IChatMessageService', 'cmsgears\community\common\services\resources\ChatMessageService' );
		$factory->set( 'cmsgears\community\common\services\interfaces\resources\IGroupMetaService', 'cmsgears\community\common\services\resources\GroupMetaService' );
		$factory->set( 'cmsgears\community\common\services\interfaces\resources\IGroupMessageService', 'cmsgears\community\common\services\resources\GroupMessageService' );
		$factory->set( 'cmsgears\community\common\services\interfaces\resources\IGroupPostService', 'cmsgears\community\common\services\resources\GroupPostService' );
		$factory->set( 'cmsgears\community\common\services\interfaces\resources\IUserPostService', 'cmsgears\community\common\services\resources\UserPostService' );
	}

	/**
	 * Registers mapper services.
	 */
	public function registerMapperServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'cmsgears\community\common\services\interfaces\mappers\IChatMemberService', 'cmsgears\community\common\services\mappers\ChatMemberService' );
		$factory->set( 'cmsgears\community\common\services\interfaces\mappers\IFriendService', 'cmsgears\community\common\services\mappers\FriendService' );
		$factory->set( 'cmsgears\community\common\services\interfaces\mappers\IGroupFollowerService', 'cmsgears\community\common\services\mappers\GroupFollowerService' );
		$factory->set( 'cmsgears\community\common\services\interfaces\mappers\IGroupMemberService', 'cmsgears\community\common\services\mappers\GroupMemberService' );
		$factory->set( 'cmsgears\community\common\services\interfaces\mappers\IUserFollowerService', 'cmsgears\community\common\services\mappers\UserFollowerService' );
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
	 * Initialize resource services.
	 */
	public function initResourceServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'chatMessageService', 'cmsgears\community\common\services\resources\ChatMessageService' );
		$factory->set( 'groupMetaService', 'cmsgears\community\common\services\resources\GroupMetaService' );
		$factory->set( 'groupMessageService', 'cmsgears\community\common\services\resources\GroupMessageService' );
		$factory->set( 'groupPostService', 'cmsgears\community\common\services\resources\GroupPostService' );
		$factory->set( 'userPostService', 'cmsgears\community\common\services\resources\UserPostService' );
	}

	/**
	 * Initialize mapper services.
	 */
	public function initMapperServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'chatMemberService', 'cmsgears\community\common\services\mappers\ChatMemberService' );
		$factory->set( 'friendService', 'cmsgears\community\common\services\mappers\FriendService' );
		$factory->set( 'groupFollowerService', 'cmsgears\community\common\services\mappers\GroupFollowerService' );
		$factory->set( 'groupMemberService', 'cmsgears\community\common\services\mappers\GroupMemberService' );
		$factory->set( 'userFollowerService', 'cmsgears\community\common\services\mappers\UserFollowerService' );
	}

	/**
	 * Initialize entity services.
	 */
	public function initEntityServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'chatService', 'cmsgears\community\common\services\entities\ChatService' );
		$factory->set( 'groupService', 'cmsgears\community\common\services\entities\GroupService' );
	}

}
