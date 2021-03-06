<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\extend\Video;
use app\util\CommonUtil;
use app\util\Constant;

/**
 * php yii convert-video/index
 */
class ConvertVideoController extends Controller {

    public $list_key = Constant::ConvertVideoList;

    public function actionIndex() {
        //var_dump(Yii::$app->redis->LRANGE($this->list_key, 0, 10));
        $vido_id = Yii::$app->redis->RPOP($this->list_key);
        if (empty($vido_id)) {
            return;
        }

        $model = Video::findOne(['id' => $vido_id]);
        if (!empty($model)) {
            $filePath = Yii::getAlias("@app/web") . $model->file;
            $newFile = strstr($model->file, '.', true) . '.mp4';
            $newFile = dirname($newFile) . '/code_' . basename($newFile);
            $newFilePath = Yii::getAlias("@app/web") . $newFile;
            //$cmd = 'ffmpeg -i ' . $filePath . ' -y -vcodec libx264 -ar 22050 ' . $newFilePath;
            $cmd = '/var/work/tool/ffmpeg/ffmpeg -i ' . $filePath . ' -vf "movie=' . Yii::getAlias("@app/web") . '/image/logo.png,scale= 100:50 [logo]; [in][logo] overlay=10:10 [out]" -y -vcodec libx264 -b 1500000 -ar 22050 ' . $newFilePath;
            echo "\n================== 转码开始 =========================\n";
            exec('ls -a', $out1);
            var_dump($out1);
            exec($cmd, $out, $code);
            echo "$cmd\n";
            echo "output:\n";
            var_dump($out);
            echo "\n^^^^^^^^^^^^^^^^^ code:" . $code;
            
            if ($code == 0) {
                $model->updateAttributes(['status' => ($model->status == -2 ? 2 : 1), 'file' => $newFile]);

                $videoInfo = CommonUtil::video_info($newFilePath);
                //print_r($videoInfo);
                if (isset($videoInfo['duration'])) {
                    $model->updateAttributes(['duration' => strstr($videoInfo['duration'], '.', true)]);

                    //rename($filePath, "/var/work/tmp/".basename($model->file));
                    unlink($filePath);
                }
            } else {
                $model->updateAttributes(['status' => -3]);
                echo "\n================= 转码失败 ！！！！！！！！！！！ ==========================\n";
            }
            echo "\n================= 转码结束 ==========================\n";
        }
    }

}
