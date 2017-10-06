<?php
namespace cmsgears\community\common\components;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

/**
 * The community component for CMSGears based sites using community module.
 */
class Community extends \yii\base\Component {

	// Global -----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

    /**
     * Initialise the CMG Core Component.
     */
    public function init() {

        parent::init();

		// Register application components and objects i.e. CMG and Project
		$this->registerComponents();
    }

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// Cms -----------------------------------

	// Properties

	// Components and Objects

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

	public function initSystemServices() {

		$factory = Yii::$app->factory->getContainer();

		//$factory->set( '<name>', '<classpath>' );
	}

	public function registerResourceServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'cmsgears\community\common\services\interfaces\resources\IChatMessageService', 'cmsgears\community\common\services\resources\ChatMessageService' );
		$factory->set( 'cmsgears\community\common\services\interfaces\resources\IGroupMetaService', 'cmsgears\community\common\services\resources\GroupMetaService' );
		$factory->set( 'cmsgears\community\common\services\interfaces\resources\IGroupMessageService', 'cmsgears\community\common\services\resources\GroupMessageService' );
		$factory->set( 'cmsgears\community\common\services\interfaces\resources\IPostService', 'cmsgears\community\common\services\resources\PostService' );
	}

	public function registerMapperServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'cmsgears\community\common\services\interfaces\mappers\IChatMemberService', 'cmsgears\community\common\services\mappers\ChatMemberService' );
		$factory->set( 'cmsgears\community\common\services\interfaces\mappers\IFollowerService', 'cmsgears\community\common\services\mappers\FollowerService' );
		$factory->set( 'cmsgears\community\common\services\interfaces\mappers\IFriendService', 'cmsgears\community\common\services\mappers\FriendService' );
		$factory->set( 'cmsgears\community\common\services\interfaces\mappers\IGroupMemberService', 'cmsgears\community\common\services\mappers\GroupMemberService' );
	}

	public function registerEntityServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'cmsgears\community\common\services\interfaces\entities\IChatService', 'cmsgears\community\common\services\entities\ChatService' );
		$factory->set( 'cmsgears\community\common\services\interfaces\entities\IGroupService', 'cmsgears\community\common\services\entities\GroupService' );
	}

	public function initResourceServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'chatMessageService', 'cmsgears\community\common\services\resources\ChatMessageService' );
		$factory->set( 'groupMetaService', 'cmsgears\community\common\services\resources\GroupMetaService' );
		$factory->set( 'groupMessageService', 'cmsgears\community\common\services\resources\GroupMessageService' );
		$factory->set( 'cmnPostService', 'cmsgears\community\common\services\resources\PostService' );
	}

	public function initMapperServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'chatMemberService', 'cmsgears\community\common\services\mappers\ChatMemberService' );
		$factory->set( 'followerService', 'cmsgears\community\common\services\mappers\FollowerService' );
		$factory->set( 'friendService', 'cmsgears\community\common\services\mappers\FriendService' );
		$factory->set( 'groupMemberService', 'cmsgears\community\common\services\mappers\GroupMemberService' );
	}

	public function initEntityServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'chatService', 'cmsgears\community\common\services\entities\ChatService' );
		$factory->set( 'groupService', 'cmsgears\community\common\services\entities\GroupService' );
	}
}
