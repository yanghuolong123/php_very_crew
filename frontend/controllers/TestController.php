<?php

namespace app\controllers;

use Yii;

class TestController extends \app\util\BaseController {

    public function actionIndex() {
        $collection = Yii::$app->mongodb->getCollection('customer');
        $collection->insert(['name' => 'John Smith', 'status' => 1]);
    }

}
