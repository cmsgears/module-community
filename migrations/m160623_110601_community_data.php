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
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\core\common\base\Migration;

use cmsgears\core\common\models\entities\Site;
use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\entities\Role;
use cmsgears\core\common\models\entities\Permission;

use cmsgears\core\common\utilities\DateUtil;

class m160623_110601_community_data extends Migration {

	// Public Variables

	// Private Variables

	private $prefix;

	private $site;

	private $master;

	public function init() {

		// Table prefix
		$this->prefix	= Yii::$app->migration->cmgPrefix;

		$this->site		= Site::findBySlug( CoreGlobal::SITE_MAIN );
		$this->master	= User::findByUsername( Yii::$app->migration->getSiteMaster() );

		Yii::$app->core->setSite( $this->site );
	}

    public function up() {

		// Create RBAC
		$this->insertRolePermission();

		// Create post permission groups and CRUD permissions
		$this->insertGroupPermissions();

		// Roles and Permissions having type set to group
		$this->insertProdRolePermission();
    }

	private function insertRolePermission() {

		// Roles

		$columns = [ 'createdBy', 'modifiedBy', 'name', 'slug', 'adminUrl', 'homeUrl', 'type', 'icon', 'description', 'createdAt', 'modifiedAt' ];

		$roles = [
			[ $this->master->id, $this->master->id, 'Community Admin', 'community-admin', 'dashboard', NULL, CoreGlobal::TYPE_SYSTEM, NULL, 'The role community admin is limited to manage friends, followers, chat and groups from admin.', DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'core_role', $columns, $roles );

		$superAdminRole		= Role::findBySlugType( 'super-admin', CoreGlobal::TYPE_SYSTEM );
		$adminRole			= Role::findBySlugType( 'admin', CoreGlobal::TYPE_SYSTEM );
		$cmnAdminRole		= Role::findBySlugType( 'community-admin', CoreGlobal::TYPE_SYSTEM );

		// Permissions

		$columns = [ 'createdBy', 'modifiedBy', 'name', 'slug', 'type', 'icon', 'description', 'createdAt', 'modifiedAt' ];

		$permissions = [
			[ $this->master->id, $this->master->id, 'Admin Community', 'admin-community', CoreGlobal::TYPE_SYSTEM, null, 'The permission admin community is base permission to manage friends, followers, chat and groups from admin.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Admin Chat', 'admin-chat', CoreGlobal::TYPE_SYSTEM, NULL, 'The permission admin chat is to manage user private offline and online chat messages from admin.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Admin Group', 'admin-group', CoreGlobal::TYPE_SYSTEM, NULL, 'The permission admin group is to manage community groups, group members and messages from admin.', DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'core_permission', $columns, $permissions );

		$adminPerm			= Permission::findBySlugType( 'admin', CoreGlobal::TYPE_SYSTEM );
		$userPerm			= Permission::findBySlugType( 'user', CoreGlobal::TYPE_SYSTEM );
		$cmnAdminPerm		= Permission::findBySlugType( 'admin-community', CoreGlobal::TYPE_SYSTEM );
		$chatAdminPerm		= Permission::findBySlugType( 'admin-chat', CoreGlobal::TYPE_SYSTEM );
		$groupAdminPerm		= Permission::findBySlugType( 'admin-group', CoreGlobal::TYPE_SYSTEM );

		// RBAC Mapping

		$columns = [ 'roleId', 'permissionId' ];

		$mappings = [
			[ $superAdminRole->id, $cmnAdminPerm->id ], [ $superAdminRole->id, $chatAdminPerm->id ], [ $superAdminRole->id, $groupAdminPerm->id ],
			[ $adminRole->id, $cmnAdminPerm->id ], [ $adminRole->id, $chatAdminPerm->id ], [ $adminRole->id, $groupAdminPerm->id ],
			[ $cmnAdminRole->id, $adminPerm->id ], [ $cmnAdminRole->id, $userPerm->id ], [ $cmnAdminRole->id, $cmnAdminPerm->id ],
			[ $cmnAdminRole->id, $chatAdminPerm->id ], [ $cmnAdminRole->id, $groupAdminPerm->id ]
		];

		$this->batchInsert( $this->prefix . 'core_role_permission', $columns, $mappings );
	}

	private function insertGroupPermissions() {

		// Permissions
		$columns = [ 'createdBy', 'modifiedBy', 'name', 'slug', 'type', 'icon', 'group', 'description', 'createdAt', 'modifiedAt' ];

		$permissions = [
			// Permission Groups - Default - Website - Individual, Organization
			[ $this->master->id, $this->master->id, 'Manage Groups', 'manage-groups', CoreGlobal::TYPE_SYSTEM, NULL, true, 'The permission manage groups allows user to manage groups from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Group Author', 'group-author', CoreGlobal::TYPE_SYSTEM, NULL, true, 'The permission group author allows user to perform crud operations of group belonging to respective author from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],

			// Post Permissions - Hard Coded - Website - Individual, Organization
			[ $this->master->id, $this->master->id, 'View Groups', 'view-groups', CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission view groups allows users to view their groups from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Add Group', 'add-group', CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission add group allows users to create group from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Update Group', 'update-group', CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission update group allows users to update group from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Delete Group', 'delete-group', CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission delete group allows users to delete group from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Approve Group', 'approve-group', CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission approve group allows user to approve, freeze or block group from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Print Group', 'print-group', CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission print group allows user to print group from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Import Groups', 'import-groups', CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission import groups allows user to import groups from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Export Groups', 'export-groups', CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission export groups allows user to export groups from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'core_permission', $columns, $permissions );

		// Permission Groups
		$groupManagerPerm	= Permission::findBySlugType( 'manage-groups', CoreGlobal::TYPE_SYSTEM );
		$groupAuthorPerm	= Permission::findBySlugType( 'group-author', CoreGlobal::TYPE_SYSTEM );

		// Permissions
		$vGroupsPerm	= Permission::findBySlugType( 'view-groups', CoreGlobal::TYPE_SYSTEM );
		$aGroupPerm		= Permission::findBySlugType( 'add-group', CoreGlobal::TYPE_SYSTEM );
		$uGroupPerm		= Permission::findBySlugType( 'update-group', CoreGlobal::TYPE_SYSTEM );
		$dGroupPerm		= Permission::findBySlugType( 'delete-group', CoreGlobal::TYPE_SYSTEM );
		$apGroupPerm	= Permission::findBySlugType( 'approve-group', CoreGlobal::TYPE_SYSTEM );
		$pGroupPerm		= Permission::findBySlugType( 'print-group', CoreGlobal::TYPE_SYSTEM );
		$iGroupsPerm	= Permission::findBySlugType( 'import-groups', CoreGlobal::TYPE_SYSTEM );
		$eGroupsPerm	= Permission::findBySlugType( 'export-groups', CoreGlobal::TYPE_SYSTEM );

		//Hierarchy

		$columns = [ 'parentId', 'childId', 'rootId', 'parentType', 'lValue', 'rValue' ];

		$hierarchy = [
			// Group Manager - Organization, Approver
			[ null, null, $groupManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 1, 18 ],
			[ $groupManagerPerm->id, $vGroupsPerm->id, $groupManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 2, 3 ],
			[ $groupManagerPerm->id, $aGroupPerm->id, $groupManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 4, 5 ],
			[ $groupManagerPerm->id, $uGroupPerm->id, $groupManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 6, 7 ],
			[ $groupManagerPerm->id, $dGroupPerm->id, $groupManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 8, 9 ],
			[ $groupManagerPerm->id, $apGroupPerm->id, $groupManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 10, 11 ],
			[ $groupManagerPerm->id, $pGroupPerm->id, $groupManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 12, 13 ],
			[ $groupManagerPerm->id, $iGroupsPerm->id, $groupManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 14, 15 ],
			[ $groupManagerPerm->id, $eGroupsPerm->id, $groupManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 16, 17 ],

			// Group Author- Individual
			[ null, null, $groupAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 1, 16 ],
			[ $groupAuthorPerm->id, $vGroupsPerm->id, $groupAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 2, 3 ],
			[ $groupAuthorPerm->id, $aGroupPerm->id, $groupAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 4, 5 ],
			[ $groupAuthorPerm->id, $uGroupPerm->id, $groupAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 6, 7 ],
			[ $groupAuthorPerm->id, $dGroupPerm->id, $groupAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 8, 9 ],
			[ $groupAuthorPerm->id, $pGroupPerm->id, $groupAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 10, 11 ],
			[ $groupAuthorPerm->id, $iGroupsPerm->id, $groupAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 12, 13 ],
			[ $groupAuthorPerm->id, $eGroupsPerm->id, $groupAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 14, 15 ]
		];

		$this->batchInsert( $this->prefix . 'core_model_hierarchy', $columns, $hierarchy );
	}

	private function insertProdRolePermission() {

		// Roles

		$columns = [ 'createdBy', 'modifiedBy', 'name', 'slug', 'homeUrl', 'type', 'icon', 'description', 'createdAt', 'modifiedAt' ];

		$roles = [
			[ $this->master->id, $this->master->id, 'Group Manager', 'group-manager', '/', CmnGlobal::TYPE_COMMUNITY, null, 'The role manager is limited to manage groups from website. Manager has full rights to update Group Profile. Group Manager can also manage Group Members, change their roles with less privileges than Master.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Group Moderator', 'group-moderator', '/', CmnGlobal::TYPE_COMMUNITY, null, 'The role moderator is limited to manage groups from website. Moderators can update or delete Group Messages and change Group Status Message.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Group Member', 'group-member', '/', CmnGlobal::TYPE_COMMUNITY, null, 'The role member is limited to site users from website. Members can post on group, invite friends to join groups, share group on facebook wall, tweet about group on twitter.', DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'core_role', $columns, $roles );

		$managerRole	= Role::findBySlugType( 'group-manager', CmnGlobal::TYPE_COMMUNITY );
		$moderatorRole	= Role::findBySlugType( 'group-moderator', CmnGlobal::TYPE_COMMUNITY );
		$memberRole		= Role::findBySlugType( 'group-member', CmnGlobal::TYPE_COMMUNITY );

		// Permissions

		$columns = [ 'createdBy', 'modifiedBy', 'name', 'slug', 'type', 'icon', 'description', 'createdAt', 'modifiedAt' ];

		$permissions = [
			[ $this->master->id, $this->master->id, 'Group Manager', 'group-manager', CmnGlobal::TYPE_COMMUNITY, NULL, 'The permission Group Manager is group of permissions for Group Manager.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Group Moderator', 'group-moderator', CmnGlobal::TYPE_COMMUNITY, NULL, 'The permission Group Moderator is group of permissions for Group Moderator.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Group Member', 'group-member', CmnGlobal::TYPE_COMMUNITY, NULL, 'The permission Group Member is group of permissions for Group Member.', DateUtil::getDateTime(), DateUtil::getDateTime() ],

			[ $this->master->id, $this->master->id, 'Update Group Settings', 'update-group-settings', CmnGlobal::TYPE_COMMUNITY, NULL, 'The permission Update Group Settings is to update group settings from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Update Group Profile', 'update-group-profile', CmnGlobal::TYPE_COMMUNITY, NULL, 'The permission Update Group Profile is to update group profile from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Update Group Status', 'update-group-status', CmnGlobal::TYPE_COMMUNITY, NULL, 'The permission Update Group Status is to update group status from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],

			[ $this->master->id, $this->master->id, 'Invite Group Members', 'invite-group-members', CmnGlobal::TYPE_COMMUNITY, NULL, 'The permission Invite Group Members is to invite group members from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'View Group Members', 'view-group-members', CmnGlobal::TYPE_COMMUNITY, NULL, 'The permission View Group Members is to view group members from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Add Group Member', 'add-group-member', CmnGlobal::TYPE_COMMUNITY, NULL, 'The permission Add Group Member is to add group member from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Update Group Member', 'update-group-member', CmnGlobal::TYPE_COMMUNITY, NULL, 'The permission Update Group Member is to update group member from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Approve Group Member', 'approve-group-member', CmnGlobal::TYPE_COMMUNITY, NULL, 'The permission Approve Group Member is to approve group member from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Block Group Member', 'block-group-member', CmnGlobal::TYPE_COMMUNITY, NULL, 'The permission Block Group Member is to block group member from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Remove Group Member', 'remove-group-member', CmnGlobal::TYPE_COMMUNITY, NULL, 'The permission Remove Group Member is to remove group member from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],

			[ $this->master->id, $this->master->id, 'View Group Messages', 'view-group-messages', CmnGlobal::TYPE_COMMUNITY, NULL, 'The permission View Group Messages is to view group messages from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Add Group Message', 'add-group-message', CmnGlobal::TYPE_COMMUNITY, NULL, 'The permission Add Group Message is to add group message from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Update Group Message', 'update-group-message', CmnGlobal::TYPE_COMMUNITY, NULL, 'The permission Update Group Message is to update group message from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Delete Group Message', 'delete-group-message', CmnGlobal::TYPE_COMMUNITY, NULL, 'The permission Delete Group Message is to delete group message from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'core_permission', $columns, $permissions );

		$gManagerPerm	= Permission::findBySlugType( 'group-manager', CmnGlobal::TYPE_COMMUNITY );
		$gModeratorPerm	= Permission::findBySlugType( 'group-moderator', CmnGlobal::TYPE_COMMUNITY );
		$gMemberPerm	= Permission::findBySlugType( 'group-member', CmnGlobal::TYPE_COMMUNITY );

		$usGroupPerm	= Permission::findBySlugType( 'update-group-settings', CmnGlobal::TYPE_COMMUNITY );
		$upGroupPerm	= Permission::findBySlugType( 'update-group-profile', CmnGlobal::TYPE_COMMUNITY );
		$ustGroupPerm	= Permission::findBySlugType( 'update-group-status', CmnGlobal::TYPE_COMMUNITY );

		$iGroupMPerm	= Permission::findBySlugType( 'invite-group-members', CmnGlobal::TYPE_COMMUNITY );
		$vGroupMPerm	= Permission::findBySlugType( 'view-group-members', CmnGlobal::TYPE_COMMUNITY );
		$aGroupMPerm	= Permission::findBySlugType( 'add-group-member', CmnGlobal::TYPE_COMMUNITY );
		$uGroupMPerm	= Permission::findBySlugType( 'update-group-member', CmnGlobal::TYPE_COMMUNITY );
		$apGroupMPerm	= Permission::findBySlugType( 'approve-group-member', CmnGlobal::TYPE_COMMUNITY );
		$bGroupMPerm	= Permission::findBySlugType( 'block-group-member', CmnGlobal::TYPE_COMMUNITY );
		$rGroupMPerm	= Permission::findBySlugType( 'remove-group-member', CmnGlobal::TYPE_COMMUNITY );

		$vGroupMsgPerm	= Permission::findBySlugType( 'view-group-messages', CmnGlobal::TYPE_COMMUNITY );
		$aGroupMsgPerm	= Permission::findBySlugType( 'add-group-message', CmnGlobal::TYPE_COMMUNITY );
		$uGroupMsgPerm	= Permission::findBySlugType( 'update-group-message', CmnGlobal::TYPE_COMMUNITY );
		$dGroupMsgPerm	= Permission::findBySlugType( 'delete-group-message', CmnGlobal::TYPE_COMMUNITY );

		// RBAC Mapping

		$columns = [ 'roleId', 'permissionId' ];

		$mappings = [
			[ $managerRole->id, $gManagerPerm->id ],
			[ $moderatorRole->id, $gModeratorPerm->id ],
			[ $memberRole->id, $gMemberPerm->id ]
		];

		$this->batchInsert( $this->prefix . 'core_role_permission', $columns, $mappings );

		//Hierarchy

		$columns = [ 'parentId', 'childId', 'rootId', 'parentType', 'lValue', 'rValue' ];

		$hierarchy = [
			// Manager
			[ null, null, $gManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 1, 30 ],
			[ $gManagerPerm->id, $usGroupPerm->id, $gManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 2, 3 ],
			[ $gManagerPerm->id, $upGroupPerm->id, $gManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 4, 5 ],
			[ $gManagerPerm->id, $ustGroupPerm->id, $gManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 6, 7 ],
			[ $gManagerPerm->id, $iGroupMPerm->id, $gManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 8, 9 ],
			[ $gManagerPerm->id, $vGroupMPerm->id, $gManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 10, 11 ],
			[ $gManagerPerm->id, $aGroupMPerm->id, $gManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 12, 13 ],
			[ $gManagerPerm->id, $uGroupMPerm->id, $gManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 14, 15 ],
			[ $gManagerPerm->id, $apGroupMPerm->id, $gManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 16, 17 ],
			[ $gManagerPerm->id, $bGroupMPerm->id, $gManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 18, 19 ],
			[ $gManagerPerm->id, $rGroupMPerm->id, $gManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 20, 21 ],
			[ $gManagerPerm->id, $vGroupMsgPerm->id, $gManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 22, 23 ],
			[ $gManagerPerm->id, $aGroupMsgPerm->id, $gManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 24, 25 ],
			[ $gManagerPerm->id, $uGroupMsgPerm->id, $gManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 26, 27 ],
			[ $gManagerPerm->id, $dGroupMsgPerm->id, $gManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 28, 29 ],

			// Moderator - without Message Owner Filter
			[ null, null, $gModeratorPerm->id, CoreGlobal::TYPE_PERMISSION, 1, 12 ],
			[ $gModeratorPerm->id, $iGroupMPerm->id, $gModeratorPerm->id, CoreGlobal::TYPE_PERMISSION, 2, 3 ],
			[ $gModeratorPerm->id, $vGroupMsgPerm->id, $gModeratorPerm->id, CoreGlobal::TYPE_PERMISSION, 4, 5 ],
			[ $gModeratorPerm->id, $aGroupMsgPerm->id, $gModeratorPerm->id, CoreGlobal::TYPE_PERMISSION, 6, 7 ],
			[ $gModeratorPerm->id, $uGroupMsgPerm->id, $gModeratorPerm->id, CoreGlobal::TYPE_PERMISSION, 8, 9 ],
			[ $gModeratorPerm->id, $dGroupMsgPerm->id, $gModeratorPerm->id, CoreGlobal::TYPE_PERMISSION, 10, 11 ],

			// Member - with Message Owner Filter
			[ null, null, $gMemberPerm->id, CoreGlobal::TYPE_PERMISSION, 1, 10 ],
			[ $gMemberPerm->id, $vGroupMsgPerm->id, $gMemberPerm->id, CoreGlobal::TYPE_PERMISSION, 2, 3 ],
			[ $gMemberPerm->id, $aGroupMsgPerm->id, $gMemberPerm->id, CoreGlobal::TYPE_PERMISSION, 4, 5 ],
			[ $gMemberPerm->id, $uGroupMsgPerm->id, $gMemberPerm->id, CoreGlobal::TYPE_PERMISSION, 6, 7 ],
			[ $gMemberPerm->id, $dGroupMsgPerm->id, $gMemberPerm->id, CoreGlobal::TYPE_PERMISSION, 8, 9 ]
		];

		$this->batchInsert( $this->prefix . 'core_model_hierarchy', $columns, $hierarchy );
	}

    public function down() {

        echo "m160623_110601_community_data will be deleted with m160621_014408_core.\n";
    }

}
