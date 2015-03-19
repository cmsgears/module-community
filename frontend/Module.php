<?php
namespace cmsgears\modules\community\frontend;

use \Yii;

class Module extends \yii\base\Module {

    public $controllerNamespace = 'cmsgears\modules\community\frontend\controllers';

    public function init() {

        parent::init();

        $this->setViewPath( '@cmsgears/modules/community/frontend/views' );
    }
}