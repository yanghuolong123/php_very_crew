<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\extend\GameApply */

$this->title = 'Create Game Apply';
$this->params['breadcrumbs'][] = ['label' => 'Game Applies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-apply-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
