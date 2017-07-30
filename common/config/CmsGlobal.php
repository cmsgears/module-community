<?php
namespace cmsgears\cms\common\config;

class CmsGlobal {

	// Traits - Metas, Tags, Attachments, Addresses --------------------

	const TYPE_ELEMENT			= 'element';
	const TYPE_BLOCK			= 'block';
	const TYPE_PAGE				= 'page';
	const TYPE_POST				= 'blog';
	const TYPE_MENU				= 'menu';
	const TYPE_SIDEBAR			= 'sidebar';
	const TYPE_WIDGET			= 'widget';
	const TYPE_LINK				= 'link';

	// Permissions -----------------------------------------------------

	// File
	const PERM_BLOG_ADMIN		= 'admin-blog';

	const PERM_BLOG_VIEW		= 'view-posts';
	const PERM_BLOG_ADD			= 'add-post';
	const PERM_BLOG_UPDATE		= 'update-post';
	const PERM_BLOG_DELETE		= 'delete-post';
	const PERM_BLOG_APPROVE		= 'approve-post';
	const PERM_BLOG_PRINT		= 'print-post';
	const PERM_BLOG_IMPORT		= 'import-posts';
	const PERM_BLOG_EXPORT		= 'export-posts';

	// Config ----------------------------------------------------------

	const CONFIG_BLOG			= 'blog';

	// Templates -------------------------------------------------------

	const TEMPLATE_PAGE			= 'page';
	const TEMPLATE_POST			= 'post';

	// Errors ----------------------------------------------------------

	// Model Fields ----------------------------------------------------

	// Generic Fields
	const FIELD_ELEMENT			= 'elementField';
	const FIELD_BLOCK			= 'blockField';
	const FIELD_PAGE			= 'pageField';
	const FIELD_MENU			= 'menuField';
	const FIELD_WIDGET			= 'widgetField';
	const FIELD_SIDEBAR			= 'sidebarField';
	const FIELD_URL_RELATIVE	= 'relativeUrlField';
	const FIELD_KEYWORDS		= 'keywordsField';

	// SEO
	const FIELD_SEO_NAME			= 'seoNameField';
	const FIELD_SEO_DESCRIPTION		= 'seoDescriptionField';
	const FIELD_SEO_KEYWORDS		= 'seoKeywordsField';
	const FIELD_SEO_ROBOT			= 'seoRobotField';

	// Block Fields
	const FIELD_BACKGROUND			= 'backgroundField';
	const FIELD_TEXTURE				= 'textureField';
}
