/* ============================= CMSGears Community ========================================= */

SET FOREIGN_KEY_CHECKS=0;

--
-- Community module roles and permissions
--

INSERT INTO `cmg_core_role` (`createdBy`,`modifiedBy`,`name`,`slug`,`homeUrl`,`type`,`icon`,`description`,`createdAt`,`modifiedAt`) VALUES 
	(1,1,'Chat Manager','chat-manager','/','system',null,'The role Chat Manager is limited to manage private chat sessions from admin.','2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(1,1,'Group Manager','group-manager','/','system',null,'The role Group Manager is limited to manage groups from admin.','2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(1,1,'Group Super Admin','group-super-admin','/','community',null,'The role Super Admin is limited to manage groups from website. Admin has full rights to create, read, update or delete Group and to manage Group Settings. Group Admin can also manage Group Members and change their roles.','2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(1,1,'Group Admin','group-admin','/','community',null,'The role Admin is limited to manage groups from website. Admin has full rights to update Group Profile. Group Admin can also manage Group Members, change their roles with less privileges than Admin.','2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(1,1,'Group Moderator','group-moderator','/','community',null,'The role Moderator is limited to manage groups from website. Moderators can update or delete Group Messages and change Group Status Message.','2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(1,1,'Group Member','group-member','/','community',null,'The role Member is limited to site users from website. Members can post on group, invite friends to join groups, share group on facebook wall, tweet about group on twitter.','2014-10-11 14:22:54','2014-10-11 14:22:54');

SELECT @rolesadmin := `id` FROM cmg_core_role WHERE slug = 'super-admin';
SELECT @roleadmin := `id` FROM cmg_core_role WHERE slug = 'admin';
SELECT @rolecm := `id` FROM cmg_core_role WHERE slug = 'chat-manager';
SELECT @rolegm := `id` FROM cmg_core_role WHERE slug = 'group-manager';
SELECT @rolegsa := `id` FROM cmg_core_role WHERE slug = 'group-super-admin';
SELECT @rolega := `id` FROM cmg_core_role WHERE slug = 'group-admin';
SELECT @rolegmd := `id` FROM cmg_core_role WHERE slug = 'group-moderator';
SELECT @rolegme := `id` FROM cmg_core_role WHERE slug = 'group-member';

INSERT INTO `cmg_core_permission` (`createdBy`,`modifiedBy`,`name`,`slug`,`type`,`icon`,`description`,`createdAt`,`modifiedAt`) VALUES
	(1,1,'community','community','system',null,'The permission community is to manage community module from admin.','2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(1,1,'community-chat','community-chat','system',null,'The permission community-chat is to manage user private offline and online chat messages from admin.','2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(1,1,'community-group','community-group','system',null,'The permission community-group is to manage community groups, group members and messages from admin.','2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(1,1,'group-create','group-create','community',null,'The permission group-create is to create group from website.','2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(1,1,'group-delete','group-delete','community',null,'The permission group-delete is to delete group from website.','2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(1,1,'group-update-settings','group-update-settings','community',null,'The permission group-update-settings is to update group settings from website.','2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(1,1,'group-update-profile','group-update-profile','community',null,'The permission group-update-profile is to update group profile from website.','2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(1,1,'group-member-role','group-member-role','community',null,'The permission group-member-role is to manage member role from website.','2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(1,1,'group-member-approve','group-member-approve','community',null,'The permission group-member-approve is to approve group member from website.','2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(1,1,'group-member-block','group-member-block','community',null,'The permission group-member-block is to block group member from website.','2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(1,1,'group-member-remove','group-member-remove','community',null,'The permission group-member-remove is to remove group member from website. It delete all member activity logs.','2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(1,1,'group-status-message','group-status-message','community',null,'The permission group-status-message is to update group status message from website.','2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(1,1,'group-message-update','group-message-update','community',null,'The permission group-message-update is to update group message from website. It allows to update message posted by all the group members.','2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(1,1,'group-message-delete','group-message-delete','community',null,'The permission group-message-delete is to delete group message from website. It allows to delete message posted by all the group members.','2014-10-11 14:22:54','2014-10-11 14:22:54');

SELECT @permadmin := `id` FROM cmg_core_permission WHERE slug = 'admin';
SELECT @permuser := `id` FROM cmg_core_permission WHERE slug = 'user';
SELECT @permcmn := `id` FROM cmg_core_permission WHERE slug = 'community';
SELECT @permcmnc := `id` FROM cmg_core_permission WHERE slug = 'community-chat';
SELECT @permcmng := `id` FROM cmg_core_permission WHERE slug = 'community-group';
SELECT @permcmngc := `id` FROM cmg_core_permission WHERE slug = 'group-create';
SELECT @permcmngd := `id` FROM cmg_core_permission WHERE slug = 'group-delete';
SELECT @permcmnus := `id` FROM cmg_core_permission WHERE slug = 'group-update-settings';
SELECT @permcmnup := `id` FROM cmg_core_permission WHERE slug = 'group-update-profile';
SELECT @permcmnmr := `id` FROM cmg_core_permission WHERE slug = 'group-member-role';
SELECT @permcmnma := `id` FROM cmg_core_permission WHERE slug = 'group-member-approve';
SELECT @permcmnmb := `id` FROM cmg_core_permission WHERE slug = 'group-member-block';
SELECT @permcmnmrv := `id` FROM cmg_core_permission WHERE slug = 'group-member-remove';
SELECT @permcmnsm := `id` FROM cmg_core_permission WHERE slug = 'group-status-message';
SELECT @permcmnmsu := `id` FROM cmg_core_permission WHERE slug = 'group-message-update';
SELECT @permcmnmsd := `id` FROM cmg_core_permission WHERE slug = 'group-message-delete';

INSERT INTO `cmg_core_role_permission` VALUES 
	(@rolesadmin,@permcmn),(@rolesadmin,@permcmnc),(@rolesadmin,@permcmng),
	(@roleadmin,@permcmn),(@roleadmin,@permcmnc),(@roleadmin,@permcmng),
	(@rolecm,@permadmin),(@rolecm,@permuser),(@rolecm,@permcmn),(@rolecm,@permcmnc),
	(@rolegm,@permadmin),(@rolegm,@permuser),(@rolegm,@permcmn),(@rolegm,@permcmng),
	(@rolegsa,@permcmngc),(@rolegsa,@permcmngd),(@rolegsa,@permcmnus),(@rolegsa,@permcmnup),(@rolegsa,@permcmnmr),(@rolegsa,@permcmnma),(@rolegsa,@permcmnmb),(@rolegsa,@permcmnmrv),(@rolegsa,@permcmnsm),(@rolegsa,@permcmnmsu),(@rolegsa,@permcmnmsd),
	(@rolega,@permcmnus),(@rolega,@permcmnup),(@rolega,@permcmnmr),(@rolega,@permcmnma),(@rolega,@permcmnmb),(@rolega,@permcmnmrv),(@rolega,@permcmnsm),(@rolega,@permcmnmsu),(@rolega,@permcmnmsd),
	(@rolegmd,@permcmnmsu),(@rolegmd,@permcmnmsd);