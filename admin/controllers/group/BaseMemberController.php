<?php
namespace cmsgears\community\admin\controllers\group;

// Yii Imports
use \Yii;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\community\common\models\entities\GroupMember;

use cmsgears\community\admin\services\GroupService;
use cmsgears\community\admin\services\GroupMemberService;

class BaseMemberController extends \cmsgears\core\admin\controllers\BaseController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// BaseMemberController ------------------

	public function actionAll( $id, $sidebar = [] ) {

		// Find Model
		$model		= GroupService::findById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			$dataProvider = GroupMemberService::getPaginationByGroupId( $id );

			return $this->render( '@cmsgears/module-community/admin/views/group/member/all', [
				'dataProvider' => $dataProvider,
				'group' => $model,
				'sidebar' => $sidebar
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionDelete( $gid, $id, $sidebar = [] ) {

		// Find Model
		$group	= GroupService::findById( $gid );
		$model	= GroupMemberService::findById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			if( $model->load( Yii::$app->request->post(), 'GroupMember' ) ) {

				if( GroupMemberService::delete( $model ) ) {

					return $this->redirect( [ 'all?id=' . $gid ] );
				}
			}

			return $this->render( '@cmsgears/module-community/admin/views/group/member/delete', [
				'group' => $group,
				'model' => $model,
				'statusMap' => GroupMember::$statusMap,
				'sidebar' => $sidebar
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}
