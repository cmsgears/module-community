/* ============================= CMSGears Community ========================================= */

SET FOREIGN_KEY_CHECKS=0;

--
-- Dumping data for table `cmg_core_role`
--

INSERT INTO `cmg_core_role` VALUES 
	(2001,1,1,'Chat Manager','chat-manager','The role Chat Manager is limited to manage private chat sessions from admin.','/','system',null,'2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(2002,1,1,'Group Manager','group-manager','The role Group Manager is limited to manage groups from admin.','/','system',null,'2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(2003,1,1,'Group Super Admin','group-super-admin','The role Super Admin is limited to manage groups from website. Admin has full rights to create, read, update or delete Group and to manage Group Settings. Group Admin can also manage Group Members and change their roles.','/','community',null,'2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(2004,1,1,'Group Admin','group-admin','The role Admin is limited to manage groups from website. Admin has full rights to update Group Profile. Group Admin can also manage Group Members, change their roles with less privileges than Admin.','/','community',null,'2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(2005,1,1,'Group Moderator','group-moderator','The role Moderator is limited to manage groups from website. Moderators can update or delete Group Messages and change Group Status Message.','/','community',null,'2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(2006,1,1,'Group Member','group-member','The role Member is limited to site users from website. Members can post on group, invite friends to join groups, share group on facebook wall, tweet about group on twitter.','/','community',null,'2014-10-11 14:22:54','2014-10-11 14:22:54');

--
-- Dumping data for table `cmg_core_permission`
--

INSERT INTO `cmg_core_permission` VALUES 
	(2001,1,1,'community','community','The permission community is to manage community module from admin.','system',null,'2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(2002,1,1,'community-chat','community-chat','The permission community-chat is to manage user private offline and online chat messages from admin.','system',null,'2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(2003,1,1,'community-group','community-group','The permission community-group is to manage community groups, group members and messages from admin.','system',null,'2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(2004,1,1,'group-create','group-create','The permission group-create is to create group from website.','community',null,'2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(2005,1,1,'group-delete','group-delete','The permission group-delete is to delete group from website.','community',null,'2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(2006,1,1,'group-update-settings','group-update-settings','The permission group-update-settings is to update group settings from website.','community',null,'2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(2007,1,1,'group-update-profile','group-update-profile','The permission group-update-profile is to update group profile from website.','community',null,'2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(2008,1,1,'group-member-role','group-member-role','The permission group-member-role is to manage member role from website.','community',null,'2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(2009,1,1,'group-member-approve','group-member-approve','The permission group-member-approve is to approve group member from website.','community',null,'2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(2010,1,1,'group-member-block','group-member-block','The permission group-member-block is to block group member from website.','community',null,'2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(2011,1,1,'group-member-remove','group-member-remove','The permission group-member-remove is to remove group member from website. It delete all member activity logs.','community',null,'2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(2012,1,1,'group-status-message','group-status-message','The permission group-status-message is to update group status message from website.','community',null,'2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(2013,1,1,'group-message-update','group-message-update','The permission group-message-update is to update group message from website. It allows to update message posted by all the group members.','community',null,'2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(2014,1,1,'group-message-delete','group-message-delete','The permission group-message-delete is to delete group message from website. It allows to delete message posted by all the group members.','community',null,'2014-10-11 14:22:54','2014-10-11 14:22:54');

--
-- Dumping data for table `cmg_core_role_permission`
--

INSERT INTO `cmg_core_role_permission` VALUES 
	(1,2001),(1,2002),(1,2003),
	(2,2001),(2,2002),(2,2003),
	(2001,1),(2001,2),(2001,2001),(2001,2002),
	(2002,1),(2002,2),(2002,2001),(2002,2003),
	(2003,2004),(2003,2005),(2003,2006),(2003,2007),(2003,2008),(2003,2009),(2003,2010),(2003,2011),(2003,2012),(2003,2013),(2003,2014),
	(2004,2006),(2004,2007),(2004,2008),(2004,2009),(2004,2010),(2004,2011),(2004,2012),(2004,2013),(2004,2014),
	(2005,2013),(2005,2014);