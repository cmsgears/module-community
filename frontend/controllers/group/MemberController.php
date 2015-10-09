<?php
namespace cmsgears\community\frontend\controllers\group;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;  

// CMG Imports
use cmsgears\core\common\config\CoreGlobal; 
use cmsgears\core\frontend\config\WebGlobalCore; 
use cmsgears\core\common\services\RoleService;

use cmsgears\community\common\config\CmnGlobal;
use cmsgears\community\common\services\GroupMemberService;   
use cmsgears\community\common\services\GroupService; 
use cmsgears\community\common\models\entities\GroupMember;

class MemberController extends \cmsgears\core\common\controllers\BaseController {

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
		 
		$dataProvider	= GroupMemberService::getPagination( [ 'conditions' => [ 'groupId' => $id ] ] );
		$user			= Yii::$app->user->getIdentity();  
		$group			= GroupService::findById( $id );
		$statusNew		= GroupMember::STATUS_NEW;
		$statusActive	= GroupMember::STATUS_ACTIVE;
		$statusBlocked	= GroupMember::STATUS_BLOCKED; 
		$roleList		= RoleService::getIdNameList( [ 'conditions' => [ 'type' => CmnGlobal::TYPE_COMMUNITY ] ] );		 
		 		
		return $this->render( 'all', [
			
			'dataProvider' => $dataProvider,
			'user' => $user,
			'statusNew' => $statusNew,
			'statusActive' => $statusActive,
			'statusBlocked' => $statusBlocked,
			'group' => $group,
			'roleList' => $roleList
		] );
	} 
   
}

?>