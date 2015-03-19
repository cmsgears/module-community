<?php
namespace cmsgears\modules\community\admin\models\forms;

// Yii Imports
use \Yii;
use yii\base\Model;

class GroupCategoryBinderForm extends Model {

	public $groupId;
	public $bindedData;

	// yii\base\Model

	public function rules() {

        return [
            [ [ 'groupId', 'bindedData' ], 'required' ],
            [ 'groupId', 'compare', 'compareValue' => 0, 'operator' => '>' ]
        ];
    }
}

?>