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
use cmsgears\core\common\models\entities\User;
use cmsgears\community\common\models\base\CmnTables;

/**
 * Follower represents interest of one model in another model.
 *
 * @property integer $id
 * @property integer $modelId
 * @property integer $parentId
 * @property string $type
 * @property boolean $active
 * @property integer $createdAt
 * @property integer $modifiedAt
 * @property string $data
 *
 * @since 1.0.0
 */
class UserFollower extends \cmsgears\core\common\models\base\Follower {

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
	 * Return corresponding followed user.
	 *
	 * @return \cmsgears\core\common\models\entities\User
	 */
	public function getParent() {

		return $this->hasOne( User::class, [ 'id' => 'parentId' ] );
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
