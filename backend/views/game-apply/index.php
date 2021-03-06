<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\GameApplySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Game Applies';
$this->params['breadcrumbs'][] = ['label' => '大赛管理', 'url' => ['games/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-apply-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Create Game Apply', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
//            'user_id',
//            'game_id',
//            'username',
            [
                'attribute' => 'username',
                'format' => 'raw',
                'value' => function($data) {
                    return Html::a($data->username,Yii::$app->params['frontendHost'].'user/view?id='.$data->user_id, ['target'=>'_blank']);// Html::a($data->username,['user/view', 'id' => $data->user_id]);
                },
            ],
            'amount',
            'summary',
            'join_num',
            'star_num',
            // 'len_minute',
            // 'len_second',
            // 'condition',
            // 'ability',
            // 'advantage',
            // 'status',
             'create_time:datetime',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ],
        ],
    ]); ?>
</div>
