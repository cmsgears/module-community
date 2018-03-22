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
use cmsgears\core\common\models\entities\User;
use cmsgears\community\common\models\base\CmnTables;

/**
 * Follower represents interest of one model in another model.
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
class UserFollower extends Follower {

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

	// UserFollower --------------------------

	/**
	 * Return corresponding user.
	 *
	 * @return \cmsgears\core\common\models\entities\User
	 */
	public function getModel() {

		return $this->hasOne( User::class, [ 'id' => 'modelId' ] );
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmnTables::getTableName( CmnTables::TABLE_USER_FOLLOWER );
	}

	// CMG parent classes --------------------

	// UserFollower --------------------------

	// Read - Query -----------

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------

}
