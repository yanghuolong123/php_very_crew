<?php

namespace app\controllers;

use Yii;

class HomeController extends \app\components\ext\BaseController {

    public function actionCropImg() {
        $width = Yii::$app->request->get('width');
        $height = Yii::$app->request->get('height');
        $mode = Yii::$app->request->get('mode');
        $src = Yii::$app->request->get('src');
        if (empty($src) || empty($width) || empty($height) || empty($mode)) {
            throw new \yii\web\NotFoundHttpException('not found the correct param.');
        }

        $etag = md5($src . $width . $height . $mode);
        $src = Yii::$app->basePath . '/web' . base64_decode($src);
        $pathInfo = pathinfo($src);
        $dst = Yii::$app->basePath . '/web/assets/' . $etag . '.' . $pathInfo['extension'];

        $inm = explode(',', getenv("HTTP_IF_NONE_MATCH"));
        foreach ($inm as $i) {
            if (trim($i) == $etag) {
                header("HTTP/1.0 304 Not Modified");
                header('Etag:' . $etag, true, 304);
                header('Last Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
                header('Expires: ' . gmdate("D, d M Y H:i:s", time() + 3600) . ' GMT');
                header('Cache-Control: max-age=3600');
                exit();
            }
        }

        if (!file_exists($dst)) {
            ini_set('memory_limit', '256M');
            \app\util\CommonUtil::cropImg($src, $dst, $width, $height, $mode);
        }

        header('Last Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        header('Expires: ' . gmdate("D, d M Y H:i:s", time() + 3600) . ' GMT');
        header('Pragma: Cache');
        header('Etag: ' . $etag);
        header('Cache-Control: max-age=3600');
        header("Content-type: image/jpeg");

        echo fread(fopen($dst, "r"), filesize($dst));
    }

}
