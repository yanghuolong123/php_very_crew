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

        $commentList = Comment::find()->where(['type' => $this->type, 'vid' => $this->vid, 'parent_id' => 0, 'status' => 1])->orderBy('id desc')->all();

        $view = $this->getView();
        CommentAsset::register($view);

        return $this->render('comment', [
                    'model' => $model,
                    'commentList' => $commentList,
                    'title' => $this->title,
        ]);
    }

}
