<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\community\common\services\mappers;

// Yii Imports
use Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\core\common\services\interfaces\entities\IRoleService;
use cmsgears\core\common\services\interfaces\entities\IUserService;
use cmsgears\core\common\services\interfaces\mappers\ISiteMemberService;
use cmsgears\community\common\services\interfaces\mappers\IGroupMemberService;

use cmsgears\core\common\services\traits\base\ApprovalTrait;

use cmsgears\core\common\utilities\DateUtil;

/**
 * GroupMemberService provide service methods of group member.
 *
 * @since 1.0.0
 */
class GroupMemberService extends \cmsgears\core\common\services\base\MapperService implements IGroupMemberService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass = '\cmsgears\community\common\models\mappers\GroupMember';

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	protected $roleService;
	protected $memberService;
	protected $userService;

	// Private ----------------

	// Traits ------------------------------------------------------

	use ApprovalTrait;

	// Constructor and Initialisation ------------------------------

	public function __construct( IRoleService $roleService, ISiteMemberService $memberService, IUserService $userService, $config = [] ) {

		$this->roleService		= $roleService;
		$this->memberService	= $memberService;
		$this->userService		= $userService;

		parent::__construct( $config );
	}

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// GroupMemberService --------------------

	// Data Provider ------

	public function getPage( $config = [] ) {

		$modelClass	= static::$modelClass;
		$modelTable	= $this->getModelTable();

		$groupTable	= Yii::$app->factory->get( 'groupService' )->getModelTable();
		$userTable	= $this->userService->getModelTable();
		$roleTable	= $this->roleService->getModelTable();

	    $sort = new Sort([
	        'attributes' => [
	            'id' => [
	                'asc' => [ "$modelTable.id" => SORT_ASC ],
	                'desc' => [ "$modelTable.id" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Id'
	            ],
	            'group' => [
	                'asc' => [ "$groupTable.name" => SORT_ASC ],
	                'desc' => [ "$groupTable.name" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Group'
	            ],
				'user' => [
					'asc' => [ "$userTable.name" => SORT_ASC ],
					'desc' => [ "$userTable.name" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'User',
				],
				'role' => [
					'asc' => [ "$roleTable.name" => SORT_ASC ],
					'desc' => [ "$roleTable.name" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Role',
				],
				'status' => [
					'asc' => [ "$modelTable.status" => SORT_ASC ],
					'desc' => [ "$modelTable.status" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Status',
				],
	            'cdate' => [
	                'asc' => [ "$modelTable.createdAt" => SORT_ASC ],
	                'desc' => [ "$modelTable.createdAt" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Created At'
	            ],
	            'udate' => [
	                'asc' => [ "$modelTable.modifiedAt" => SORT_ASC ],
	                'desc' => [ "$modelTable.modifiedAt" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Update At'
	            ],
	            'sdate' => [
	                'asc' => [ "$modelTable.syncedAt" => SORT_ASC ],
	                'desc' => [ "$modelTable.syncedAt" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Synced At'
	            ]
	        ],
	        'defaultOrder' => [
	        	'cdate' => SORT_DESC
	        ]
	    ]);

		if( !isset( $config[ 'sort' ] ) ) {

			$config[ 'sort' ] = $sort;
		}

		// Query ------------

		if( !isset( $config[ 'query' ] ) ) {

			$config[ 'hasOne' ] = true;
		}

		// Filters ----------

		// Filter - Status
		$status	= Yii::$app->request->getQueryParam( 'status' );

		if( isset( $status ) && isset( $modelClass::$urlRevStatusMap[ $status ] ) ) {

			$config[ 'conditions' ][ "$modelTable.status" ]	= $modelClass::$urlRevStatusMap[ $status ];
		}

		// Searching --------

		$searchCol	= Yii::$app->request->getQueryParam( 'search' );

		if( isset( $searchCol ) ) {

			$search = [
				'user' => "$userTable.name",
				'email' => "$userTable.email"
			];

			$config[ 'search-col' ] = $search[ $searchCol ];
		}

		// Reporting --------

		$config[ 'report-col' ]	= [
			'user' => "$userTable.name",
			'email' => "$userTable.email",
			'status' => "$modelTable.status"
		];

		// Result -----------

		return parent::getPage( $config );
	}

	public function getPageByGroupId( $groupId ) {

		return $this->getPage( [ 'conditions' => [ 'groupId' => $groupId ] ] );
	}

	// Read ---------------

    // Read - Models ---

   	public function getByGroupId( $groupId ) {

		$modelClass	= static::$modelClass;

		return $modelClass::findByGroupId( $groupId );
	}

   	public function getByUserId( $userId ) {

		$modelClass	= static::$modelClass;

		return $modelClass::findByUserId( $userId );
	}

    // Read - Lists ----

    // Read - Maps -----

	public function searchByGroupIdName( $groupId, $name ) {

		$modelClass	= static::$modelClass;
		$modelTable	= $this->getModelTable();

		$userTable	= Yii::$app->factory->get( 'userService' )->getModelTable();

		$terminated	= $modelClass::STATUS_TERMINATED;

		$models	= $modelClass::queryWithUser()
					->where( "$modelTable.groupId =:gid AND $modelTable.status < $terminated", [ ':gid' => $groupId ] )
					->andWhere( "$userTable.name like :name", [ ':name' => "$name%" ] )
					->limit( 5 )->all();

		$results = [];

		foreach( $models as $model ) {

			$user = $model->user;
			$role = $model->role;

			$results[] = [ 'id' => $model->id, 'name' => $user->getName(), 'email' => $user->email, 'role' => $role->name ];
		}

		return $results;
	}

	// Read - Others ---

	// Create -------------

	public function create( $model, $config = [] ) {

		$modelClass	= static::$modelClass;

		$group	= isset( $config[ 'group' ] ) ? $config[ 'group' ] : null;
		$role	= isset( $config[ 'role' ] ) ? $config[ 'role' ] : null;
		$user	= isset( $config[ 'user' ] ) ? $config[ 'user' ] : null;

		$model->groupId	= isset( $group ) ? $group->id : $model->groupId;
		$model->roleId	= isset( $role ) ? $role->id : $model->roleId;
		$model->userId	= isset( $user ) ? $user->id : $model->userId;

		$model->status = isset( $model->status ) ? $model->status : $modelClass::STATUS_NEW;

		$model->generateVerifyToken();

		if( empty( $model->roleId ) ) {

			$role = $this->roleService->getBySlugType( CmnGlobal::ROLE_GROUP_MEMBER, CmnGlobal::TYPE_COMMUNITY );

			$model->roleId = $role->id;
		}

		return parent::create( $model, $config );
	}

	public function add( $model, $config = [] ) {

		$admin		= isset( $config[ 'admin' ] ) ? $config[ 'admin' ] : false;
		$notify		= isset( $config[ 'notify' ] ) ? $config[ 'notify' ] : true;
		$mail		= isset( $config[ 'mail' ] ) ? $config[ 'mail' ] : true;
		$avatar		= isset( $config[ 'avatar' ] ) ? $config[ 'avatar' ] : null;
		$group		= isset( $config[ 'group' ] ) ? $config[ 'group' ] : null;
		$user		= isset( $config[ 'user' ] ) ? $config[ 'user' ] : null;
		$member		= isset( $config[ 'member' ] ) ? $config[ 'member' ] : null;
		$adminLink	= isset( $config[ 'adminLink' ] ) ? $config[ 'adminLink' ] : '/community/group/member/update';

		$transaction = Yii::$app->db->beginTransaction();

		try {

			// Create User and group member in case existing user is not selected
			if( isset( $user ) && isset( $member ) ) {

				$user = $this->userService->create( $user, [ 'avatar' => $avatar ] );

				$member->userId = $user->id;

				// Add User to current Site
				$this->memberService->create( $member );
			}

			// Create Group Member
			$model = $this->create( $model, [ 'group' => $group, 'user' => $user ] );

			// Update User Status to Submitted for further approval
			if( Yii::$app->core->userApproval ) {

				$this->userService->submit( $model->user );
			}

			$transaction->commit();
		}
		catch( Exception $e ) {

			$transaction->rollBack();

			return false;
		}

		$group = $model->group;

		// Notify Group Admin
		if( $notify ) {

			// Trigger Notification
			Yii::$app->eventManager->triggerNotification( CmnGlobal::TPL_NOTIFY_GROUP_MEMBER_ADD,
				[ 'model' => $model, 'service' => $this, 'group' => $group, 'user' => $model->user, 'role' => $model->role ],
				[ 'parentId' => $group->id, 'parentType' => CmnGlobal::TYPE_GROUP, 'email' => $group->getEmail(), 'adminLink' => "{$adminLink}?id={$model->id}" ]
			);
		}

		// Trigger mail to Member
		if( $mail ) {

			// New User
			if( isset( $user ) && isset( $member ) ) {

				Yii::$app->cmnMailer->sendCreateGroupMemberMail( $model, $group, $user );
			}
			// Existing User
			else {

				$model->generateVerifyToken();

				Yii::$app->cmnMailer->sendInviteGroupMemberMail( $model, $group, $model->user );
			}
		}

		return $model;
	}

	public function register( $model, $config = [] ) {

		$notify		= isset( $config[ 'notify' ] ) ? $config[ 'notify' ] : true;
		$mail		= isset( $config[ 'mail' ] ) ? $config[ 'mail' ] : true;
		$adminLink	= isset( $config[ 'adminLink' ] ) ? $config[ 'adminLink' ] : '/community/group/member/update';

		$group	= $config[ 'group' ];
		$user	= Yii::$app->core->getUser();

		$transaction = Yii::$app->db->beginTransaction();

		try {

			$model = $this->create( $model, [ 'group' => $group, 'user' => $user ] );

			// Update User status of newly registered user
			if( $user->isRegistration() ) {

				$this->userService->submit( $user );
			}

			$transaction->commit();
		}
		catch( Exception $e ) {

			$transaction->rollBack();

			return false;
		}

		// Notify Site & Group Admin
		if( $notify ) {

			Yii::$app->eventManager->triggerNotification( CmnGlobal::TPL_NOTIFY_GROUP_MEMBER_SUBMIT,
				[ 'model' => $model, 'service' => $this, 'group' => $group, 'user' => $model->user, 'role' => $model->role ],
				[ 'parentId' => $group->id, 'parentType' => CmnGlobal::TYPE_GROUP, 'email' => $group->getEmail(), 'adminLink' => "{$adminLink}?id={$model->id}" ]
			);
		}

		// Email Member
		if( $mail ) {

			Yii::$app->cmnMailer->sendRegisterGroupMemberMail( $model, $group, $user );
		}

		return $model;
	}

	public function join( $model, $config = [] ) {

		$notify		= isset( $config[ 'notify' ] ) ? $config[ 'notify' ] : true;
		$mail		= isset( $config[ 'mail' ] ) ? $config[ 'mail' ] : true;
		$adminLink	= isset( $config[ 'adminLink' ] ) ? $config[ 'adminLink' ] : '/community/group/member/update';

		$group	= $config[ 'group' ];
		$user	= Yii::$app->core->getUser();

		$model = $this->create( $model, [ 'group' => $group, 'user' => $user ] );

		// Notify Group Admin
		if( $notify ) {

			Yii::$app->eventManager->triggerNotification( CmnGlobal::TPL_NOTIFY_GROUP_MEMBER_JOIN,
				[ 'model' => $model, 'service' => $this, 'group' => $group, 'user' => $model->user, 'role' => $model->role ],
				[ 'parentId' => $group->id, 'parentType' => CmnGlobal::TYPE_GROUP, 'email' => $group->getEmail(), 'adminLink' => "{$adminLink}?id={$model->id}" ]
			);
		}

		// Email Member
		if( $mail ) {

			Yii::$app->cmnMailer->sendJoinGroupMemberMail( $model, $group, $user );
		}

		return $model;
	}

	// Update -------------

	public function update( $model, $config = [] ) {

		$admin = isset( $config[ 'admin' ] ) ? $config[ 'admin' ] : false;

		if( $admin ) {

			return parent::update( $model, [
				'attributes' => [ 'roleId', 'status' ]
			]);
		}
		else {

			$model->syncedAt = DateUtil::getDateTime();
		}

		return parent::update( $model, [
			'attributes' => [ 'syncedAt' ]
		]);
	}

	// Delete -------------

	public function deleteByGroupId( $groupId ) {

		$modelClass	= static::$modelClass;

		$modelClass::deleteByGroupId( $groupId );
	}

	// Bulk ---------------

	public function applyBulkByGroupId( $column, $action, $target, $groupId ) {

		foreach( $target as $id ) {

			$model = $this->getById( $id );

			if( isset( $model ) && !$model->isTerminated() && $model->groupId == $groupId ) {

				$this->applyBulk( $model, $column, $action, $target );
			}
		}
	}

	public function applyBulkByUserId( $column, $action, $target, $userId ) {

		foreach( $target as $id ) {

			$model = $this->getById( $id );

			if( isset( $model ) && !$model->isTerminated() && $model->userId == $userId ) {

				$this->applyBulk( $model, $column, $action, $target );
			}
		}
	}

	protected function applyBulk( $model, $column, $action, $target, $config = [] ) {

		switch( $column ) {

			case 'status': {

				switch( $action ) {

					case 'approved': {

						if( $model->isBelowRejected() ) {

							$this->approve( $model );
						}

						break;
					}
					case 'active': {

						$this->activate( $model );

						break;
					}
					case 'blocked': {

						$this->block( $model );

						break;
					}
					case 'terminated': {

						if( !$model->isTerminated() ) {

							$this->terminate( $model );
						}

						break;
					}
				}

				break;
			}
			case 'model': {

				switch( $action ) {

					case 'delete': {

						$this->delete( $model );

						break;
					}
				}

				break;
			}
		}
	}

	// Notifications ------

	// Cache --------------

	// Additional ---------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// GroupMemberService --------------------

	// Data Provider ------

	// Read ---------------

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------

}
