<?php
namespace cmsgears\community\admin;

// Yii Imports
use \Yii;

class Module extends \yii\base\Module {

    public $controllerNamespace = 'cmsgears\community\admin\controllers';

    public function init() {

        parent::init();

        $this->setViewPath( '@cmsgears/module-community/admin/views' );
    }

	public function getSidebarHtml() {

		$path	= Yii::getAlias( "@cmsgears" ) . "/module-community/admin/views/sidebar.php";

		return $path;
	}
}
