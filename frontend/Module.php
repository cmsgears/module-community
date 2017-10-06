<?php
namespace cmsgears\community\frontend;

use \Yii;

class Module extends \yii\base\Module {

    public $controllerNamespace = 'cmsgears\community\frontend\controllers';

    public function init() {

        parent::init();

        $this->setViewPath( '@cmsgears/module-community/frontend/views' );
    }
}