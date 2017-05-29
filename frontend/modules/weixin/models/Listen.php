<?php

namespace app\modules\weixin\models;

abstract class Listen {

    public $params;
    public $access_token;

    public function __construct($token, $params = array()) {
        $this->params = $params;
        $this->access_token = $token;
    }

    abstract public function listen();
    
    public function sendMsg($arr, $is_save = FALSE, $other = array()) {
        $xmlStr = arrToXmlStr($arr);
        echo $xmlStr;
        if ($is_save) {
            $mongo = Yii::$app->mongodb;
            $arr['create_datetime'] = isset($arr['CreateTime']) ? date('Y-m-d H:i:s', $arr['CreateTime']) : date('Y-m-d H:i:s', TIMESTAMP);
            $arr['other'] = $other;
            $mongo->selectCollection('weixin_send')->insert($arr);
            $mongo->close();
        }
        exit(0);
    }
}
