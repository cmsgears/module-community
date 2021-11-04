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

use cmsgears\core\common\models\resources\ModelStats;
use cmsgears\community\common\models\base\CmnTables;

/**
 * The community stats migration insert the default row count for all the tables available in
 * community module. A scheduled console job can be executed to update these stats.
 *
 * @since 1.0.0
 */
class m160910_111782_community_stats extends \cmsgears\core\common\base\Migration {

	// Public Variables

	public $options;

	// Private Variables

	private $prefix;

	public function init() {

		// Table prefix
		$this->prefix = Yii::$app->migration->cmgPrefix;

		// Get the values via config
		$this->options = Yii::$app->migration->getTableOptions();

		// Default collation
		if( $this->db->driverName === 'mysql' ) {

			$this->options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}
	}

	public function up() {

		// Table Stats
		$this->insertTables();
	}

	private function insertTables() {

		$columns = [ 'parentId', 'parentType', 'name', 'type', 'count' ];

		$tableData = [
			[ 1, CoreGlobal::TYPE_SITE, $this->prefix . 'cmn_friend', 'rows', 0 ],
			[ 1, CoreGlobal::TYPE_SITE, $this->prefix . 'cmn_friend_invite', 'rows', 0 ],
			[ 1, CoreGlobal::TYPE_SITE, $this->prefix . 'cmn_user_follower', 'rows', 0 ],
			[ 1, CoreGlobal::TYPE_SITE, $this->prefix . 'cmn_user_post', 'rows', 0 ],
			[ 1, CoreGlobal::TYPE_SITE, $this->prefix . 'cmn_user_post_meta', 'rows', 0 ],
			[ 1, CoreGlobal::TYPE_SITE, $this->prefix . 'cmn_chat', 'rows', 0 ],
			[ 1, CoreGlobal::TYPE_SITE, $this->prefix . 'cmn_chat_member', 'rows', 0 ],
			[ 1, CoreGlobal::TYPE_SITE, $this->prefix . 'cmn_chat_message', 'rows', 0 ],
			[ 1, CoreGlobal::TYPE_SITE, $this->prefix . 'cmn_chat_message_report', 'rows', 0 ],
			[ 1, CoreGlobal::TYPE_SITE, $this->prefix . 'cmn_group', 'rows', 0 ],
			[ 1, CoreGlobal::TYPE_SITE, $this->prefix . 'cmn_group_meta', 'rows', 0 ],
			[ 1, CoreGlobal::TYPE_SITE, $this->prefix . 'cmn_group_follower', 'rows', 0 ],
			[ 1, CoreGlobal::TYPE_SITE, $this->prefix . 'cmn_group_post', 'rows', 0 ],
			[ 1, CoreGlobal::TYPE_SITE, $this->prefix . 'cmn_group_post_meta', 'rows', 0 ],
			[ 1, CoreGlobal::TYPE_SITE, $this->prefix . 'cmn_group_member', 'rows', 0 ],
			[ 1, CoreGlobal::TYPE_SITE, $this->prefix . 'cmn_group_invite', 'rows', 0 ],
			[ 1, CoreGlobal::TYPE_SITE, $this->prefix . 'cmn_group_message', 'rows', 0 ],
			[ 1, CoreGlobal::TYPE_SITE, $this->prefix . 'cmn_group_message_report', 'rows', 0 ]
		];

		$this->batchInsert( $this->prefix . 'core_model_stats', $columns, $tableData );
	}

	public function down() {

		ModelStats::deleteByTable( CmnTables::getTableName( CmnTables::TABLE_FRIEND ) );
		ModelStats::deleteByTable( CmnTables::getTableName( CmnTables::TABLE_FRIEND_INVITE ) );

		ModelStats::deleteByTable( CmnTables::getTableName( CmnTables::TABLE_USER_FOLLOWER ) );
		ModelStats::deleteByTable( CmnTables::getTableName( CmnTables::TABLE_USER_POST ) );
		ModelStats::deleteByTable( CmnTables::getTableName( CmnTables::TABLE_USER_POST_META ) );

		ModelStats::deleteByTable( CmnTables::getTableName( CmnTables::TABLE_CHAT ) );
		ModelStats::deleteByTable( CmnTables::getTableName( CmnTables::TABLE_CHAT_MEMBER ) );
		ModelStats::deleteByTable( CmnTables::getTableName( CmnTables::TABLE_CHAT_MESSAGE ) );
		ModelStats::deleteByTable( CmnTables::getTableName( CmnTables::TABLE_CHAT_MESSAGE_REPORT ) );

		ModelStats::deleteByTable( CmnTables::getTableName( CmnTables::TABLE_GROUP ) );
		ModelStats::deleteByTable( CmnTables::getTableName( CmnTables::TABLE_GROUP_META ) );
		ModelStats::deleteByTable( CmnTables::getTableName( CmnTables::TABLE_GROUP_FOLLOWER ) );
		ModelStats::deleteByTable( CmnTables::getTableName( CmnTables::TABLE_GROUP_POST ) );
		ModelStats::deleteByTable( CmnTables::getTableName( CmnTables::TABLE_GROUP_POST_META ) );
		ModelStats::deleteByTable( CmnTables::getTableName( CmnTables::TABLE_GROUP_MEMBER ) );
		ModelStats::deleteByTable( CmnTables::getTableName( CmnTables::TABLE_GROUP_INVITE ) );
		ModelStats::deleteByTable( CmnTables::getTableName( CmnTables::TABLE_GROUP_MESSAGE ) );
		ModelStats::deleteByTable( CmnTables::getTableName( CmnTables::TABLE_GROUP_MESSAGE_REPORT ) );
	}

}
