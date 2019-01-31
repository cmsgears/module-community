<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

// CMG Imports
use cmsgears\core\common\models\resources\Stats;
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

		$columns = [ 'tableName', 'type', 'count' ];

		$tableData = [
			[ $this->prefix . 'cmn_friend', 'rows', 0 ],
			[ $this->prefix . 'cmn_friend_invite', 'rows', 0 ],
			[ $this->prefix . 'cmn_user_follower', 'rows', 0 ],
			[ $this->prefix . 'cmn_user_post', 'rows', 0 ],
			[ $this->prefix . 'cmn_user_post_meta', 'rows', 0 ],
			[ $this->prefix . 'cmn_chat', 'rows', 0 ],
			[ $this->prefix . 'cmn_chat_member', 'rows', 0 ],
			[ $this->prefix . 'cmn_chat_message', 'rows', 0 ],
			[ $this->prefix . 'cmn_chat_message_report', 'rows', 0 ],
			[ $this->prefix . 'cmn_group', 'rows', 0 ],
			[ $this->prefix . 'cmn_group_meta', 'rows', 0 ],
			[ $this->prefix . 'cmn_group_follower', 'rows', 0 ],
			[ $this->prefix . 'cmn_group_post', 'rows', 0 ],
			[ $this->prefix . 'cmn_group_post_meta', 'rows', 0 ],
			[ $this->prefix . 'cmn_group_member', 'rows', 0 ],
			[ $this->prefix . 'cmn_group_invite', 'rows', 0 ],
			[ $this->prefix . 'cmn_group_message', 'rows', 0 ],
			[ $this->prefix . 'cmn_group_message_report', 'rows', 0 ]
		];

		$this->batchInsert( $this->prefix . 'core_stats', $columns, $tableData );
	}

	public function down() {

		Stats::deleteByTableName( CmnTables::getTableName( CmnTables::TABLE_FRIEND ) );
		Stats::deleteByTableName( CmnTables::getTableName( CmnTables::TABLE_FRIEND_INVITE ) );

		Stats::deleteByTableName( CmnTables::getTableName( CmnTables::TABLE_USER_FOLLOWER ) );
		Stats::deleteByTableName( CmnTables::getTableName( CmnTables::TABLE_USER_POST ) );
		Stats::deleteByTableName( CmnTables::getTableName( CmnTables::TABLE_USER_POST_META ) );

		Stats::deleteByTableName( CmnTables::getTableName( CmnTables::TABLE_CHAT ) );
		Stats::deleteByTableName( CmnTables::getTableName( CmnTables::TABLE_CHAT_MEMBER ) );
		Stats::deleteByTableName( CmnTables::getTableName( CmnTables::TABLE_CHAT_MESSAGE ) );
		Stats::deleteByTableName( CmnTables::getTableName( CmnTables::TABLE_CHAT_MESSAGE_REPORT ) );

		Stats::deleteByTableName( CmnTables::getTableName( CmnTables::TABLE_GROUP ) );
		Stats::deleteByTableName( CmnTables::getTableName( CmnTables::TABLE_GROUP_META ) );
		Stats::deleteByTableName( CmnTables::getTableName( CmnTables::TABLE_GROUP_FOLLOWER ) );
		Stats::deleteByTableName( CmnTables::getTableName( CmnTables::TABLE_GROUP_POST ) );
		Stats::deleteByTableName( CmnTables::getTableName( CmnTables::TABLE_GROUP_POST_META ) );
		Stats::deleteByTableName( CmnTables::getTableName( CmnTables::TABLE_GROUP_MEMBER ) );
		Stats::deleteByTableName( CmnTables::getTableName( CmnTables::TABLE_GROUP_INVITE ) );
		Stats::deleteByTableName( CmnTables::getTableName( CmnTables::TABLE_GROUP_MESSAGE ) );
		Stats::deleteByTableName( CmnTables::getTableName( CmnTables::TABLE_GROUP_MESSAGE_REPORT ) );
	}

}
