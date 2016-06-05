<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\extend\MetaData;
use app\models\extend\Distrinct;

$this->title = '查看个人主页';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-view">
    <div class="container">
        

        <div class="body-content">

            <div class="row">
                <div class="col-lg-3">

                    <p>
                        <?= Html::img($model->avatar, ['style'=>'wdith:240px;height:240px;']) ?>
                    </p>

                </div>
                <div class="col-lg-8">

                    <p>
                        <ul class="list-group">
                            <li class="list-group-item"><label>姓名：</label> <?= $model->nickname ?></li>
                            <li class="list-group-item"><label>性别：</label> <?= MetaData::getVal($profile->gender) ?></li>
                            <li class="list-group-item"><label>所在地区：</label> <?= implode(' ',Distrinct::getArrDistrict([$profile->province, $profile->city, $profile->county, $profile->country])) ?></li>
                            <li class="list-group-item"><label>出生日期：</label> <?= $profile->birthday ?></li>
                            <li class="list-group-item"><label>身高：</label> <?= $profile->height ?></li>
                            <li class="list-group-item"><label>体重：</label> <?= $profile->weight ?></li>
                            <li class="list-group-item"><label>可用于拍摄的时间：</label> <?= MetaData::getVal($profile->usingtime) ?></li>
                            <li class="list-group-item"><label>擅长角色：</label> <?= implode(', ',MetaData::getArrVal(explode(',', trim($profile->good_at_job)))) ?></li>
                            <li class="list-group-item"><label>表演特长：</label> <?= implode(', ',MetaData::getArrVal(explode(',', trim($profile->speciality)))) ?></li>
                            <li class="list-group-item"><label>联系方式：</label> 
                                <ul class="list-group">
                                    <li class="list-group-item"><label>电话：</label> <?= $model->mobile ?></li>
                                    <li class="list-group-item"><label>QQ：</label> <?= $profile->qq ?></li>
                                    <li class="list-group-item"><label>Email：</label> <?= $model->email ?></li>
                                    <li class="list-group-item"><label>微信：</label> <?= $profile->weixin ?></li>
                                </ul>
                            </li>
                            <li class="list-group-item"><label>其它个人说明：</label> <?= $profile->remark ?></li>
                        </ul>
                    </p>
                </div>

            </div>

        </div>
        
        <?php if(!empty($perVideo)): ?>
        <div class="row">
            <div class="container"><h3>个人作品</h3></div>
            <?php foreach ($perVideo as $video): ?>
            <div class="col-sm-6 col-md-4">
              <div class="thumbnail">
                  <a href="<?= Url::to(['video/view', 'id'=>$video->id]) ?>"><img style="height:350px; width:350px;" src="<?= $video->logo ?>" alt="<?= $video->title ?>"></a>
                <div class="caption">
                    <h3><a href="<?= Url::to(['video/view', 'id'=>$video->id]) ?>"><?= $video->title ?></a></h3>
                  <p><?= MetaData::getVal($video->type) ?>  - <?= implode(', ',MetaData::getArrVal(explode(',', trim($video->tag)))) ?></p>  
                  <p><?= $video->views ?>人气/ <?= $video->comments ?>点评/ <?= $video->support ?>赞</p>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <?= app\components\comment\CommentWidget::widget(['type'=>2,'vid' => $model->id, 'title'=>'留言']) ?>
    </div>


</div>