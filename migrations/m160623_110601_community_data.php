<?php
// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\core\common\models\entities\Site;
use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\entities\Role;
use cmsgears\core\common\models\entities\Permission;

use cmsgears\core\common\utilities\DateUtil;

class m160623_110601_community_data extends \yii\db\Migration {

	// Private Variables

	private $prefix;

	private $site;

	private $master;

	public function init() {

		// Fixed
		$this->prefix	= 'cmg_';

		$this->site		= Site::findBySlug( CoreGlobal::SITE_MAIN );
		$this->master	= User::findByUsername( 'demomaster' );

		Yii::$app->core->setSite( $this->site );
	}

    public function up() {

		// Create RBAC
		$this->insertAdminRolePermission();
		$this->insertProdRolePermission();
    }

	private function insertAdminRolePermission() {

		// Roles

		$columns = [ 'createdBy', 'modifiedBy', 'name', 'slug', 'homeUrl', 'type', 'icon', 'description', 'createdAt', 'modifiedAt' ];

		$roles = [
			[ $this->master->id, $this->master->id, 'Chat Manager', 'chat-manager', 'dashboard', CoreGlobal::TYPE_SYSTEM, null, 'The role Chat Manager is limited to manage private chat sessions from admin.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Group Manager', 'group-manager', 'dashboard', CoreGlobal::TYPE_SYSTEM, null, 'The role Group Manager is limited to manage groups from admin.', DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'core_role', $columns, $roles );

		$superAdminRole		= Role::findBySlugType( 'super-admin', CoreGlobal::TYPE_SYSTEM );
		$adminRole			= Role::findBySlugType( 'admin', CoreGlobal::TYPE_SYSTEM );

		$chatManagerRole	= Role::findBySlugType( 'chat-manager', CoreGlobal::TYPE_SYSTEM );
		$groupManagerRole	= Role::findBySlugType( 'group-manager', CoreGlobal::TYPE_SYSTEM );

		// Permissions

		$columns = [ 'createdBy', 'modifiedBy', 'name', 'slug', 'type', 'icon', 'description', 'createdAt', 'modifiedAt' ];

		$permissions = [
			[ $this->master->id, $this->master->id, 'Community', 'community', CoreGlobal::TYPE_SYSTEM, NULL, 'The permission community is to manage community module from admin.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Community Chat', 'community-chat', CoreGlobal::TYPE_SYSTEM, NULL, 'The permission community-chat is to manage user private offline and online chat messages from admin.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Community Group', 'community-group', CoreGlobal::TYPE_SYSTEM, NULL, 'The permission community-group is to manage community groups, group members and messages from admin.', DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'core_permission', $columns, $permissions );

		$adminPerm			= Permission::findBySlugType( 'admin', CoreGlobal::TYPE_SYSTEM );
		$userPerm			= Permission::findBySlugType( 'user', CoreGlobal::TYPE_SYSTEM );

		$cmnPerm			= Permission::findBySlugType( 'community', CoreGlobal::TYPE_SYSTEM );
		$cmnChatPerm		= Permission::findBySlugType( 'community-chat', CoreGlobal::TYPE_SYSTEM );
		$cmnGroupPerm		= Permission::findBySlugType( 'community-group', CoreGlobal::TYPE_SYSTEM );

		// RBAC Mapping

		$columns = [ 'roleId', 'permissionId' ];

		$mappings = [
			[ $superAdminRole->id, $cmnPerm->id ], [ $superAdminRole->id, $cmnChatPerm->id ], [ $superAdminRole->id, $cmnGroupPerm->id ],
			[ $adminRole->id, $cmnPerm->id ], [ $adminRole->id, $cmnChatPerm->id ], [ $adminRole->id, $cmnGroupPerm->id ],
			[ $chatManagerRole->id, $adminPerm->id ], [ $chatManagerRole->id, $userPerm->id ], [ $chatManagerRole->id, $cmnPerm->id ], [ $chatManagerRole->id, $cmnChatPerm->id ],
			[ $groupManagerRole->id, $adminPerm->id ], [ $groupManagerRole->id, $userPerm->id ], [ $groupManagerRole->id, $cmnPerm->id ], [ $groupManagerRole->id, $cmnGroupPerm->id ]
		];

		$this->batchInsert( $this->prefix . 'core_role_permission', $columns, $mappings );
	}

	private function insertProdRolePermission() {

		// Roles

		$columns = [ 'createdBy', 'modifiedBy', 'name', 'slug', 'homeUrl', 'type', 'icon', 'description', 'createdAt', 'modifiedAt' ];

		$roles = [
			[ $this->master->id, $this->master->id, 'Group Super Admin', 'group-super-admin', '/', CmnGlobal::TYPE_COMMUNITY, null, 'The role Super Admin is limited to manage groups from website. Admin has full rights to create, read, update or delete Group and to manage Group Settings. Group Admin can also manage Group Members and change their roles.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Group Admin', 'group-admin', '/', CmnGlobal::TYPE_COMMUNITY, null, 'The role Admin is limited to manage groups from website. Admin has full rights to update Group Profile. Group Admin can also manage Group Members, change their roles with less privileges than Admin.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Group Moderator', 'group-moderator', '/', CmnGlobal::TYPE_COMMUNITY, null, 'The role Moderator is limited to manage groups from website. Moderators can update or delete Group Messages and change Group Status Message.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Group Member', 'group-member', '/', CmnGlobal::TYPE_COMMUNITY, null, 'The role Member is limited to site users from website. Members can post on group, invite friends to join groups, share group on facebook wall, tweet about group on twitter.', DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'core_role', $columns, $roles );

		$gsaRole			= Role::findBySlugType( 'group-super-admin', CmnGlobal::TYPE_COMMUNITY );
		$gaRole				= Role::findBySlugType( 'group-admin', CmnGlobal::TYPE_COMMUNITY );
		$gmodRole			= Role::findBySlugType( 'group-moderator', CmnGlobal::TYPE_COMMUNITY );
		$gmemRole			= Role::findBySlugType( 'group-member', CmnGlobal::TYPE_COMMUNITY );

		// Permissions

		$columns = [ 'createdBy', 'modifiedBy', 'name', 'slug', 'type', 'icon', 'description', 'createdAt', 'modifiedAt' ];

		$permissions = [
			[ $this->master->id, $this->master->id, 'Group Master', 'group-master', CmnGlobal::TYPE_COMMUNITY, NULL, 'The permission Group Master is group of permissions for Group Super Admin.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Group Admin', 'group-admin', CmnGlobal::TYPE_COMMUNITY, NULL, 'The permission Group Admin is group of permissions for Group Admin.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Group Moderator', 'group-moderator', CmnGlobal::TYPE_COMMUNITY, NULL, 'The permission Group Moderator is group of permissions for Group Moderator.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Group Member', 'group-member', CmnGlobal::TYPE_COMMUNITY, NULL, 'The permission Group Member is group of permissions for Group Member.', DateUtil::getDateTime(), DateUtil::getDateTime() ],

			[ $this->master->id, $this->master->id, 'View Groups', 'view-groups', CmnGlobal::TYPE_COMMUNITY, NULL, 'The permission View Groups is to view related groups from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Add Group', 'add-group', CmnGlobal::TYPE_COMMUNITY, NULL, 'The permission Add Group is to add group from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Update Group', 'update-group', CmnGlobal::TYPE_COMMUNITY, NULL, 'The permission Update Group is to update group from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Delete Group', 'delete-group', CmnGlobal::TYPE_COMMUNITY, NULL, 'The permission Delete Group is to delete group from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Update Group Settings', 'update-group-settings', CmnGlobal::TYPE_COMMUNITY, NULL, 'The permission Update Group Settings is to update group settings from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Update Group Profile', 'update-group-profile', CmnGlobal::TYPE_COMMUNITY, NULL, 'The permission Update Group Profile is to update group profile from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Update Group Status', 'update-group-status', CmnGlobal::TYPE_COMMUNITY, NULL, 'The permission Update Group Status is to update group status from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],

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

		$gMasterPerm			= Permission::findBySlugType( 'group-master', CmnGlobal::TYPE_COMMUNITY );
		$gAdminPerm				= Permission::findBySlugType( 'group-admin', CmnGlobal::TYPE_COMMUNITY );
		$gModeratorPerm			= Permission::findBySlugType( 'group-moderator', CmnGlobal::TYPE_COMMUNITY );
		$gMemberPerm			= Permission::findBySlugType( 'group-member', CmnGlobal::TYPE_COMMUNITY );

		$vGroupPerm				= Permission::findBySlugType( 'view-groups', CmnGlobal::TYPE_COMMUNITY );
		$aGroupPerm				= Permission::findBySlugType( 'add-group', CmnGlobal::TYPE_COMMUNITY );
		$uGroupPerm				= Permission::findBySlugType( 'update-group', CmnGlobal::TYPE_COMMUNITY );
		$dGroupPerm				= Permission::findBySlugType( 'delete-group', CmnGlobal::TYPE_COMMUNITY );
		$usGroupPerm			= Permission::findBySlugType( 'update-group-settings', CmnGlobal::TYPE_COMMUNITY );
		$upGroupPerm			= Permission::findBySlugType( 'update-group-profile', CmnGlobal::TYPE_COMMUNITY );
		$ustGroupPerm			= Permission::findBySlugType( 'update-group-status', CmnGlobal::TYPE_COMMUNITY );

		$vGroupMPerm			= Permission::findBySlugType( 'view-group-members', CmnGlobal::TYPE_COMMUNITY );
		$aGroupMPerm			= Permission::findBySlugType( 'add-group-member', CmnGlobal::TYPE_COMMUNITY );
		$uGroupMPerm			= Permission::findBySlugType( 'update-group-member', CmnGlobal::TYPE_COMMUNITY );
		$apGroupMPerm			= Permission::findBySlugType( 'approve-group-member', CmnGlobal::TYPE_COMMUNITY );
		$bGroupMPerm			= Permission::findBySlugType( 'block-group-member', CmnGlobal::TYPE_COMMUNITY );
		$rGroupMPerm			= Permission::findBySlugType( 'remove-group-member', CmnGlobal::TYPE_COMMUNITY );

		$vGroupMsgPerm			= Permission::findBySlugType( 'view-group-messages', CmnGlobal::TYPE_COMMUNITY );
		$aGroupMsgPerm			= Permission::findBySlugType( 'add-group-message', CmnGlobal::TYPE_COMMUNITY );
		$uGroupMsgPerm			= Permission::findBySlugType( 'update-group-message', CmnGlobal::TYPE_COMMUNITY );
		$dGroupMsgPerm			= Permission::findBySlugType( 'delete-group-message', CmnGlobal::TYPE_COMMUNITY );

		// RBAC Mapping

		$columns = [ 'roleId', 'permissionId' ];

		$mappings = [
			[ $gsaRole->id, $gMasterPerm->id ],
			[ $gaRole->id, $gAdminPerm->id ],
			[ $gmodRole->id, $gModeratorPerm->id ],
			[ $gmemRole->id, $gMemberPerm->id ]
		];

		$this->batchInsert( $this->prefix . 'core_role_permission', $columns, $mappings );

		//Hierarchy

		$columns = [ 'parentId', 'childId', 'rootId', 'parentType', 'lValue', 'rValue' ];

		$hierarchy = [
			// Master
			[ null, null, $gMasterPerm->id, CoreGlobal::TYPE_PERMISSION, 1, 36 ],
			[ $gMasterPerm->id, $vGroupPerm->id, $gMasterPerm->id, CoreGlobal::TYPE_PERMISSION, 2, 35 ],
			[ $gMasterPerm->id, $aGroupPerm->id, $gMasterPerm->id, CoreGlobal::TYPE_PERMISSION, 3, 34 ],
			[ $gMasterPerm->id, $uGroupPerm->id, $gMasterPerm->id, CoreGlobal::TYPE_PERMISSION, 4, 33 ],
			[ $gMasterPerm->id, $dGroupPerm->id, $gMasterPerm->id, CoreGlobal::TYPE_PERMISSION, 5, 32 ],
			[ $gMasterPerm->id, $usGroupPerm->id, $gMasterPerm->id, CoreGlobal::TYPE_PERMISSION, 6, 31 ],
			[ $gMasterPerm->id, $upGroupPerm->id, $gMasterPerm->id, CoreGlobal::TYPE_PERMISSION, 7, 30 ],
			[ $gMasterPerm->id, $ustGroupPerm->id, $gMasterPerm->id, CoreGlobal::TYPE_PERMISSION, 8, 29 ],
			[ $gMasterPerm->id, $vGroupMPerm->id, $gMasterPerm->id, CoreGlobal::TYPE_PERMISSION, 9, 28 ],
			[ $gMasterPerm->id, $aGroupMPerm->id, $gMasterPerm->id, CoreGlobal::TYPE_PERMISSION, 10, 27 ],
			[ $gMasterPerm->id, $uGroupMPerm->id, $gMasterPerm->id, CoreGlobal::TYPE_PERMISSION, 11, 26 ],
			[ $gMasterPerm->id, $apGroupMPerm->id, $gMasterPerm->id, CoreGlobal::TYPE_PERMISSION, 12, 25 ],
			[ $gMasterPerm->id, $bGroupMPerm->id, $gMasterPerm->id, CoreGlobal::TYPE_PERMISSION, 13, 24 ],
			[ $gMasterPerm->id, $rGroupMPerm->id, $gMasterPerm->id, CoreGlobal::TYPE_PERMISSION, 14, 23 ],
			[ $gMasterPerm->id, $vGroupMsgPerm->id, $gMasterPerm->id, CoreGlobal::TYPE_PERMISSION, 15, 22 ],
			[ $gMasterPerm->id, $aGroupMsgPerm->id, $gMasterPerm->id, CoreGlobal::TYPE_PERMISSION, 16, 21 ],
			[ $gMasterPerm->id, $uGroupMsgPerm->id, $gMasterPerm->id, CoreGlobal::TYPE_PERMISSION, 17, 20 ],
			[ $gMasterPerm->id, $dGroupMsgPerm->id, $gMasterPerm->id, CoreGlobal::TYPE_PERMISSION, 18, 19 ],

			// Admin
			[ null, null, $gAdminPerm->id, CoreGlobal::TYPE_PERMISSION, 1, 32 ],
			[ $gAdminPerm->id, $vGroupPerm->id, $gAdminPerm->id, CoreGlobal::TYPE_PERMISSION, 2, 31 ],
			[ $gAdminPerm->id, $aGroupPerm->id, $gAdminPerm->id, CoreGlobal::TYPE_PERMISSION, 3, 30 ],
			[ $gAdminPerm->id, $usGroupPerm->id, $gAdminPerm->id, CoreGlobal::TYPE_PERMISSION, 4, 29 ],
			[ $gAdminPerm->id, $upGroupPerm->id, $gAdminPerm->id, CoreGlobal::TYPE_PERMISSION, 5, 28 ],
			[ $gAdminPerm->id, $ustGroupPerm->id, $gAdminPerm->id, CoreGlobal::TYPE_PERMISSION, 6, 27 ],
			[ $gAdminPerm->id, $vGroupMPerm->id, $gAdminPerm->id, CoreGlobal::TYPE_PERMISSION, 7, 26 ],
			[ $gAdminPerm->id, $aGroupMPerm->id, $gAdminPerm->id, CoreGlobal::TYPE_PERMISSION, 8, 25 ],
			[ $gAdminPerm->id, $uGroupMPerm->id, $gAdminPerm->id, CoreGlobal::TYPE_PERMISSION, 9, 24 ],
			[ $gAdminPerm->id, $apGroupMPerm->id, $gAdminPerm->id, CoreGlobal::TYPE_PERMISSION, 10, 23 ],
			[ $gAdminPerm->id, $bGroupMPerm->id, $gAdminPerm->id, CoreGlobal::TYPE_PERMISSION, 11, 22 ],
			[ $gAdminPerm->id, $rGroupMPerm->id, $gAdminPerm->id, CoreGlobal::TYPE_PERMISSION, 12, 21 ],
			[ $gAdminPerm->id, $vGroupMsgPerm->id, $gAdminPerm->id, CoreGlobal::TYPE_PERMISSION, 13, 20 ],
			[ $gAdminPerm->id, $aGroupMsgPerm->id, $gAdminPerm->id, CoreGlobal::TYPE_PERMISSION, 14, 19 ],
			[ $gAdminPerm->id, $uGroupMsgPerm->id, $gAdminPerm->id, CoreGlobal::TYPE_PERMISSION, 15, 18 ],
			[ $gAdminPerm->id, $dGroupMsgPerm->id, $gAdminPerm->id, CoreGlobal::TYPE_PERMISSION, 16, 17 ],

			// Moderator - without Owner Filter
			[ null, null, $gModeratorPerm->id, CoreGlobal::TYPE_PERMISSION, 1, 10 ],
			[ $gModeratorPerm->id, $vGroupMsgPerm->id, $gModeratorPerm->id, CoreGlobal::TYPE_PERMISSION, 2, 9 ],
			[ $gModeratorPerm->id, $aGroupMsgPerm->id, $gModeratorPerm->id, CoreGlobal::TYPE_PERMISSION, 3, 8 ],
			[ $gModeratorPerm->id, $uGroupMsgPerm->id, $gModeratorPerm->id, CoreGlobal::TYPE_PERMISSION, 4, 7 ],
			[ $gModeratorPerm->id, $dGroupMsgPerm->id, $gModeratorPerm->id, CoreGlobal::TYPE_PERMISSION, 5, 6 ],

			// Member - with Owner Filter
			[ null, null, $gMemberPerm->id, CoreGlobal::TYPE_PERMISSION, 1, 10 ],
			[ $gMemberPerm->id, $vGroupMsgPerm->id, $gMemberPerm->id, CoreGlobal::TYPE_PERMISSION, 2, 9 ],
			[ $gMemberPerm->id, $aGroupMsgPerm->id, $gMemberPerm->id, CoreGlobal::TYPE_PERMISSION, 3, 8 ],
			[ $gMemberPerm->id, $uGroupMsgPerm->id, $gMemberPerm->id, CoreGlobal::TYPE_PERMISSION, 4, 7 ],
			[ $gMemberPerm->id, $dGroupMsgPerm->id, $gMemberPerm->id, CoreGlobal::TYPE_PERMISSION, 5, 6 ]
		];

		$this->batchInsert( $this->prefix . 'core_model_hierarchy', $columns, $hierarchy );
	}

    public function down() {

        echo "m160623_110601_community_data will be deleted with m160621_014408_core.\n";
    }
}

?>