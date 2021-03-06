<?php

namespace app\components\comment;

use Yii;
use yii\base\Widget;
use app\models\extend\Comment;
use app\components\comment\CommentAsset;

class CommentWidget extends Widget {

    public $title;
    public $type;
    public $vid;

    public function run() {
        $model = new Comment();
        $model->type = $this->type;
        $model->vid = $this->vid;
        $model->uid = Yii::$app->user->isGuest ? 0 : Yii::$app->user->identity->id;
        
        if (is_array($this->type) && in_array(3, $this->type) && $this->vid != $model->uid) {
            $this->type = 2;
        }
        $query = Comment::find()->where(['type' => $this->type, 'vid' => $this->vid]);
        //($this->type == 2 && $this->vid == $model->uid) ? $query->andWhere(['in', 'status', [1, 2]]) : $query->andWhere(['status' => 1]);

        $commentList = $query->orderBy('id desc')->all();

        $view = $this->getView();
        CommentAsset::register($view);

        return $this->render('comment', [
                    'model' => $model,
                    'commentList' => $commentList,
                    'title' => $this->title,
        ]);
    }

}
