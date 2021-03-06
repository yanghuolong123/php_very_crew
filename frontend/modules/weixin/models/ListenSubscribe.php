<?php

namespace app\modules\weixin\models;

use app\models\extend\GameVideo;

class ListenSubscribe extends Listen {

    public function __construct($params = array()) {
        parent::__construct($params);
    }

    public function listen() {
        if (($this->params['MsgType'] == 'event') && ($this->params['Event'] == 'subscribe')) {
            if (!empty($this->params['EventKey'])) {
                // 参赛作品投票
                $videoId = ltrim($this->params['EventKey'], 'qrscene_');
                $msg = GameVideo::gameVote($videoId, $this->params['FromUserName']);
            }

            $msgArr['ToUserName'] = $this->params['FromUserName'];
            $msgArr['FromUserName'] = $this->params['ToUserName'];
            $msgArr['CreateTime'] = TIMESTAMP;
            $msgArr['MsgType'] = 'text';
            $msgArr['Content'] = $msg . '谢谢你的关注' ? $msg : '亲，您好，感谢你的关注';

            $this->sendMsg($msgArr);
        }

        return;
    }

}
