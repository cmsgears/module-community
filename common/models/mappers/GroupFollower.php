<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\community\common\models\mappers;

// CMG Imports
use cmsgears\core\common\models\base\Follower;
use cmsgears\community\common\models\base\CmnTables;
use cmsgears\community\common\models\entities\Group;

/**
 * GroupFollower represents interest of user in group.
 *
 * @property int $id
 * @property int $modelId
 * @property int $followerId
 * @property string $type
 * @property boolean $active
 * @property int $createdAt
 * @property int $modifiedAt
 *
 * @since 1.0.0
 */
class GroupFollower extends Follower {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Model ---------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// GroupFollower -------------------------

	/**
	 * Return corresponding group.
	 *
	 * @return \cmsgears\community\common\models\entities\Group
	 */
	public function getParent() {

		return $this->hasOne( Group::class, [ 'id' => 'modelId' ] );
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmnTables::getTableName( CmnTables::TABLE_GROUP_FOLLOWER );
	}

	// CMG parent classes --------------------

	// GroupFollower -------------------------

	// Read - Query -----------

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------

}
