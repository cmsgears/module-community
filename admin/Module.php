<?php
namespace cmsgears\modules\community\admin;

// Yii Imports
use \Yii;

class Module extends \yii\base\Module {

    public $controllerNamespace = 'cmsgears\modules\community\admin\controllers';

    public function init() {

        parent::init();

        $this->setViewPath( '@cmsgears/modules/community/admin/views' );
    }
}

?>