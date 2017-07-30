<?php
// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\Site;
use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\entities\Role;
use cmsgears\core\common\models\entities\Permission;
use cmsgears\core\common\models\resources\Form;
use cmsgears\core\common\models\resources\FormField;

use cmsgears\cms\common\models\entities\Page;

use cmsgears\core\common\services\base\EntityService;

use cmsgears\core\common\utilities\DateUtil;

class m160621_065213_cms_data extends \yii\db\Migration {

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

		// Create RBAC and Site Members
		$this->insertRolePermission();

		// Create post permission groups and CRUD permissions
		$this->insertPostPermissions();

		// Create various config
		$this->insertBlogConfig();

		// Init default config
		$this->insertDefaultConfig();

		// Init system pages
		$this->insertSystemPages();
	}

	private function insertRolePermission() {

		// Roles

		$columns = [ 'createdBy', 'modifiedBy', 'name', 'slug', 'adminUrl', 'homeUrl', 'type', 'icon', 'description', 'createdAt', 'modifiedAt' ];

		$roles = [
			[ $this->master->id, $this->master->id, 'Blog Admin', 'blog-admin', 'dashboard', NULL, CoreGlobal::TYPE_SYSTEM, NULL, 'The role blog admin is limited to manage site content and blog posts from admin.', DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'core_role', $columns, $roles );

		$superAdminRole		= Role::findBySlugType( 'super-admin', CoreGlobal::TYPE_SYSTEM );
		$adminRole			= Role::findBySlugType( 'admin', CoreGlobal::TYPE_SYSTEM );
		$blogAdminRole		= Role::findBySlugType( 'blog-admin', CoreGlobal::TYPE_SYSTEM );

		// Permissions

		$columns = [ 'createdBy', 'modifiedBy', 'name', 'slug', 'type', 'icon', 'description', 'createdAt', 'modifiedAt' ];

		$permissions = [
			[ $this->master->id, $this->master->id, 'Admin Blog', 'admin-blog', CoreGlobal::TYPE_SYSTEM, null, 'The permission admin blog is to manage elements, blocks, pages, page templates, posts, post templates, post categories, post tags, menus, sidebars and widgets from admin.', DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'core_permission', $columns, $permissions );

		$adminPerm			= Permission::findBySlugType( 'admin', CoreGlobal::TYPE_SYSTEM );
		$userPerm			= Permission::findBySlugType( 'user', CoreGlobal::TYPE_SYSTEM );
		$blogAdminPerm		= Permission::findBySlugType( 'admin-blog', CoreGlobal::TYPE_SYSTEM );

		// RBAC Mapping

		$columns = [ 'roleId', 'permissionId' ];

		$mappings = [
			[ $superAdminRole->id, $blogAdminPerm->id ],
			[ $adminRole->id, $blogAdminPerm->id ],
			[ $blogAdminRole->id, $adminPerm->id ], [ $blogAdminRole->id, $userPerm->id ], [ $blogAdminRole->id, $blogAdminPerm->id ]
		];

		$this->batchInsert( $this->prefix . 'core_role_permission', $columns, $mappings );
	}

	private function insertPostPermissions() {

		// Permissions
		$columns = [ 'createdBy', 'modifiedBy', 'name', 'slug', 'type', 'icon', 'group', 'description', 'createdAt', 'modifiedAt' ];

		$permissions = [
			// Permission Groups - Default - Website - Individual, Organization
			[ $this->master->id, $this->master->id, 'Manage Posts', 'manage-posts', CoreGlobal::TYPE_SYSTEM, NULL, true, 'The permission manage posts allows user to manage posts from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Post Author', 'post-author', CoreGlobal::TYPE_SYSTEM, NULL, true, 'The permission post author allows user to perform crud operations of post belonging to respective author from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],

			// Post Permissions - Hard Coded - Website - Individual, Organization
			[ $this->master->id, $this->master->id, 'View Posts', 'view-posts', CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission view posts allows users to view their posts from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Add Post', 'add-post', CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission add post allows users to create post from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Update Post', 'update-post', CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission update post allows users to update post from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Delete Post', 'delete-post', CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission delete post allows users to delete post from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Approve Post', 'approve-post', CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission approve post allows user to approve, freeze or block post from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Print Post', 'print-post', CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission print post allows user to print post from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Import Posts', 'import-posts', CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission import posts allows user to import posts from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Export Posts', 'export-posts', CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission export posts allows user to export posts from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'core_permission', $columns, $permissions );

		// Permission Groups
		$postManagerPerm	= Permission::findBySlugType( 'manage-posts', CoreGlobal::TYPE_SYSTEM );
		$postAuthorPerm		= Permission::findBySlugType( 'post-author', CoreGlobal::TYPE_SYSTEM );

		// Permissions
		$vPostsPerm		= Permission::findBySlugType( 'view-posts', CoreGlobal::TYPE_SYSTEM );
		$aPostPerm		= Permission::findBySlugType( 'add-post', CoreGlobal::TYPE_SYSTEM );
		$uPostPerm		= Permission::findBySlugType( 'update-post', CoreGlobal::TYPE_SYSTEM );
		$dPostPerm		= Permission::findBySlugType( 'delete-post', CoreGlobal::TYPE_SYSTEM );
		$apPostPerm		= Permission::findBySlugType( 'approve-post', CoreGlobal::TYPE_SYSTEM );
		$pPostPerm		= Permission::findBySlugType( 'print-post', CoreGlobal::TYPE_SYSTEM );
		$iPostsPerm		= Permission::findBySlugType( 'import-posts', CoreGlobal::TYPE_SYSTEM );
		$ePostsPerm		= Permission::findBySlugType( 'export-posts', CoreGlobal::TYPE_SYSTEM );

		//Hierarchy

		$columns = [ 'parentId', 'childId', 'rootId', 'parentType', 'lValue', 'rValue' ];

		$hierarchy = [
			// Post Manager - Organization
			[ null, null, $postManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 1, 18 ],
			[ $postManagerPerm->id, $vPostsPerm->id, $postManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 2, 17 ],
			[ $postManagerPerm->id, $aPostPerm->id, $postManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 3, 16 ],
			[ $postManagerPerm->id, $uPostPerm->id, $postManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 4, 15 ],
			[ $postManagerPerm->id, $dPostPerm->id, $postManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 5, 14 ],
			[ $postManagerPerm->id, $apPostPerm->id, $postManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 6, 13 ],
			[ $postManagerPerm->id, $pPostPerm->id, $postManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 7, 12 ],
			[ $postManagerPerm->id, $iPostsPerm->id, $postManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 8, 11 ],
			[ $postManagerPerm->id, $ePostsPerm->id, $postManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 9, 10 ],

			// Post Author- Individual
			[ null, null, $postAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 1, 16 ],
			[ $postAuthorPerm->id, $vPostsPerm->id, $postAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 2, 15 ],
			[ $postAuthorPerm->id, $aPostPerm->id, $postAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 3, 14 ],
			[ $postAuthorPerm->id, $uPostPerm->id, $postAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 4, 13 ],
			[ $postAuthorPerm->id, $dPostPerm->id, $postAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 5, 12 ],
			[ $postAuthorPerm->id, $pPostPerm->id, $postAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 6, 11 ],
			[ $postAuthorPerm->id, $iPostsPerm->id, $postAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 7, 10 ],
			[ $postAuthorPerm->id, $ePostsPerm->id, $postAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 8, 9 ]
		];

		$this->batchInsert( $this->prefix . 'core_model_hierarchy', $columns, $hierarchy );
	}

	private function insertBlogConfig() {

		$this->insert( $this->prefix . 'core_form', [
			'siteId' => $this->site->id,
			'createdBy' => $this->master->id, 'modifiedBy' => $this->master->id,
			'name' => 'Config Blog', 'slug' => 'config-blog',
			'type' => CoreGlobal::TYPE_SYSTEM,
			'description' => 'Blog configuration form.',
			'successMessage' => 'All configurations saved successfully.',
			'captcha' => false,
			'visibility' => Form::VISIBILITY_PROTECTED,
			'active' => true, 'userMail' => false,'adminMail' => false,
			'createdAt' => DateUtil::getDateTime(),
			'modifiedAt' => DateUtil::getDateTime()
		]);

		$config	= Form::findBySlug( 'config-blog', CoreGlobal::TYPE_SYSTEM );

		$columns = [ 'formId', 'name', 'label', 'type', 'compress', 'validators', 'order', 'icon', 'htmlOptions' ];

		$fields	= [
			[ $config->id, 'page_comment','Page Comment', FormField::TYPE_TOGGLE, false, 'required', 0, NULL, '{"title":"Enable/disable comments on pages. It can also be set for individual pages from Edit Page."}' ],
			[ $config->id, 'post_comment','Post Comment', FormField::TYPE_TOGGLE, false, 'required', 0, NULL, '{"title":"Enable/disable comments on posts. It can also be set for individual pages from Edit Post."}' ],
			[ $config->id, 'post_limit','Post Limit', FormField::TYPE_TEXT, false, 'required,number', 0, NULL, '{"title":"Number of posts displayed on a page.","placeholder":"Post limit"}' ]
		];

		$this->batchInsert( $this->prefix . 'core_form_field', $columns, $fields );
	}

	private function insertDefaultConfig() {

		$columns = [ 'modelId', 'name', 'label', 'type', 'valueType', 'value' ];

		$metas	= [
			[ $this->site->id, 'page_comment', 'Page Comment', 'blog', 'flag', '0' ],
			[ $this->site->id, 'post_comment', 'Post Comment', 'blog', 'flag', '1' ],
			[ $this->site->id, 'post_limit', 'Post Limit', 'blog', 'text', EntityService::PAGE_LIMIT ]
		];

		$this->batchInsert( $this->prefix . 'core_site_meta', $columns, $metas );
	}

	private function insertSystemPages() {

		$columns = [ 'siteId', 'createdBy', 'modifiedBy', 'name', 'slug', 'type', 'status', 'visibility', 'icon', 'order', 'featured', 'comments', 'createdAt', 'modifiedAt' ];

		$pages	= [
			[ $this->site->id, $this->master->id, $this->master->id, 'Home', 'home', CmsGlobal::TYPE_PAGE, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, null, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Login', 'login', CmsGlobal::TYPE_PAGE, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, null, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Register', 'register', CmsGlobal::TYPE_PAGE, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, null, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Confirm Account', 'confirm-account', CmsGlobal::TYPE_PAGE, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, null, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Activate Account', 'activate-account', CmsGlobal::TYPE_PAGE, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, null, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Forgot Password', 'forgot-password', CmsGlobal::TYPE_PAGE, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, null, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Reset Password', 'reset-password', CmsGlobal::TYPE_PAGE, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, null, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'About Us', 'about-us', CmsGlobal::TYPE_PAGE, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, null, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Terms', 'terms', CmsGlobal::TYPE_PAGE, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, null, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Privacy', 'privacy', CmsGlobal::TYPE_PAGE, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, null, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->site->id, $this->master->id, $this->master->id, 'Blog', 'blog', CmsGlobal::TYPE_PAGE, Page::STATUS_ACTIVE, Page::VISIBILITY_PUBLIC, null, 0, false, false, DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'cms_page', $columns, $pages );

		$summary = "Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It\'s also called placeholder (or filler) text. It\'s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation, eg typography, font, or layout. Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero.";
		$content = "Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It\'s also called placeholder (or filler) text. It\'s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation, eg typography, font, or layout. Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero.";

		$columns = [ 'parentId', 'parentType', 'seoName', 'seoDescription', 'seoKeywords', 'seoRobot', 'views', 'referrals', 'summary', 'content', 'publishedAt' ];

		$pages	= [
			[ Page::findBySlugType( 'home', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, 0, 0, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'login', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, 0, 0, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'register', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, 0, 0, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'confirm-account', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, 0, 0, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'activate-account', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, 0, 0, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'forgot-password', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, 0, 0, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'reset-password', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, 0, 0, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'about-us', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, 0, 0, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'terms', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, 0, 0, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'privacy', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, 0, 0, $summary, $content, DateUtil::getDateTime() ],
			[ Page::findBySlugType( 'blog', CmsGlobal::TYPE_PAGE )->id, CmsGlobal::TYPE_PAGE, null, null, null, null, 0, 0, $summary, $content, DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'cms_model_content', $columns, $pages );
	}

	public function down() {

		echo "m160621_065213_cms_data will be deleted with m160621_014408_core and m160621_065204_cms.\n";

		return true;
	}
}
