<?php
namespace cmsgears\community\frontend\controllers\group;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\core\frontend\config\WebGlobalCore;

use cmsgears\community\common\services\resources\GroupMessageService;
use cmsgears\community\common\services\mappers\GroupMemberService;

class MessageController extends \cmsgears\core\common\controllers\BaseController {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

		$this->layout	= WebGlobalCore::LAYOUT_PRIVATE;

        parent::__construct( $id, $module, $config );
	}

	// Instance Methods --------------------------------------------

	// yii\base\Component

    public function behaviors() {

        return [
            'rbac' => [
                'class' => Yii::$app->cmgCore->getRbacFilterClass(),
                'actions' => [
	                'all' => [ 'permission' => CoreGlobal::PERM_USER ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'all' => [ 'get' ]
                ]
            ]
        ];
    }

	// MemberController

	public function actionAll( $id ) {

		$dataProvider	= GroupMessageService::getPagination( [ 'conditions' => [ 'groupId' => $id ] ] );
		$member			= GroupMemberService::findByUserId( Yii::$app->user->getIdentity()->id );

		return $this->render( 'all', [

			'dataProvider' => $dataProvider,
			'groupId' => $id,
			'memberId' => $member->id
		] );
	}

}

?>