<?php

use yii\helpers\Url;
use app\models\extend\Video;
use app\util\CommonUtil;
use app\models\extend\Games;
use yii\helpers\Html;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '参与比赛', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .game_content{
        min-height: 220px;
    }
    .game_menu{
        padding-right: 150px;
    }
    .game-tips{
        font-size: 14px;
    }
    .gamestatus,.gamenum{
        color:red; 
        font-weight: bold;
        font-style: italic;
        font-family: fantasy;
    }
    .gametime{
        color: #00c66b;
    }
    .title {
        margin-top: 35px; 
        margin-bottom: 20px;
        line-height: 30px;
    }
    .list-titile{
        color: #00c66b; 
        font-weight: bold; 
        font-size: 28px;   
        margin-right: 20px;
    }
    .modal-dialog{
        margin: 130px auto;
    }
    .gamestatus a{
        text-decoration: underline;
    }
</style>

<div class="games-view container">     
    <h2 style="color: #00c66b;"><?= $model->name ?></h2>
    <div class="row">
        <div class="col-md-8 game_content">
            <blockquote>
                <p><span class="gamestatus"><?= Games::getStatusArr(false, $model->status) ?>.....，<a href="#vote">查看作品</a></span></p>
            </blockquote>
            <p><?= $model->content ?></p>
        </div>
        <div class="col-md-4 game_menu">
            <p class="text-right"><a <?php if($model->status!=0): ?>disabled="disabled"<?php endif; ?> class="btn btn-success btn-small" href="<?php if($model->status==0): ?><?= Url::toRoute(['game/apply', 'game_id'=>$model->id]) ?><?php else: ?>javascript:;<?php endif;?>" role="button"> 申请资金资助 &raquo;</a></p>
            <p class="text-right"><a <?php if($model->status!=0): ?>disabled="disabled"<?php endif; ?> class="btn btn-success btn-small" href="<?php if($model->status==0): ?><?= Url::toRoute(['video/create', 'game_id'=>$model->id]) ?><?php else: ?>javascript:;<?php endif;?>" role="button">上传参赛作品 &raquo;</a></p>
            <!--
            <p class="text-right"><a <?php if($model->status!=1): ?>disabled="disabled"<?php endif; ?> class="btn btn-success btn-small" href="<?php if($model->status==1): ?>#vote<?php else: ?>javascript:;<?php endif;?>" role="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;群众投票 &raquo;</a></p>
            -->
            <p class="text-right"><a <?php if($model->status!=3): ?>disabled="disabled"<?php endif; ?> class="btn btn-success btn-small" href="<?php if($model->status==3): ?><?= Url::toRoute(['game/result', 'id'=>$model->id]) ?><?php else: ?>javascript:;<?php endif;?>" role="button">名次奖项公布 &raquo;</a></p>
        </div>
    </div>
    
    
   <a name="vote"></a>    
   <div class="row">
       <div class="container title">
           <div class="row">
            <div class="col-lg-6">
                <span class="list-titile"><?php if(isset($_GET['search'])): ?>搜索参赛作品<?php else: ?>当前参赛作品<?php endif; ?></span>
            </div>
            <div class="col-lg-4">
              <div class="input-group">
                <input type="text" class="search-game-video form-control" placeholder="搜索:ID/作品名称">
                <span class="input-group-btn">
                  <button class="btn btn-default search-btn" type="button">Go!</button>
                </span>
              </div>
            </div>
            <div class="col-lg-1"></div>
            <div class="col-lg-2">               
                <?= Html::dropDownList('sort', $sort, ['id'=>'按参赛时间排序', 'votes'=>'按得票排序'], ['id'=>'list-sort', 'class'=>'btn btn-success form-control']) ?>              
            </div>            
          </div>
       </div>
       <?php if(!empty($dataProvider->models)): ?>
        <?php foreach ($dataProvider->models as $gameVideo): ?>
        <?php $video = Video::findOne($gameVideo->video_id)  ?>
        <div class="col-sm-6 col-md-3">
          <div class="thumbnail">
            <a href="<?= Url::to(['video/view', 'id'=>$video->id]) ?>"><img src="<?= CommonUtil::cropImgLink($video->logo) ?>" alt="<?= $video->title ?>"><div class="duration"><?= $video->duration ?></div></a>
            <div class="caption">
              <h4><a data-toggle="tooltip" data-placement="bottom" title="<?= $video->title ?>" href="<?= Url::to(['video/view', 'id'=>$video->id]) ?>"><?= CommonUtil::cutstr($video->title,22) ?></a></h4>
              <p>ID：<?= $gameVideo->id ?></p>
              <?php if($model->status>0): ?>
              <p>得票数：<span class="gamenum" id="votes_<?= $gameVideo->id ?>"><?= $gameVideo->votes ?></span></p>              
              <p class="text-left">
                  <?= Html::hiddenInput('video_id'.$gameVideo->video_id, $gameVideo->video_id, ['id'=>''.$gameVideo->video_id]) ?>
                  <?php if($model->status!=1): ?>
                  <button disabled="disabled" type="button" class="btn btn-primary btn-small game_vote">投一票</button>
                  <?php else: ?>
                  <a tabindex="0" class="btn btn-primary btn-small game_vote" <?php if($model->status!=1): ?>disabled="disabled"<?php endif; ?>  role="button" data-placement="top" data-html="true" data-toggle="popover" data-trigger="focus" title="微信扫一扫投票" data-content="<span style='color:red;'>加载中，请等候...<img src='/image/loading.gif'/></span>">投一票</a>
                  <?php endif; ?>
              </p>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
             <div class="alert alert-info">
                 <h3><?php if(isset($_GET['search'])): ?>没有搜索到参赛作品...<?php else: ?>暂时没有参赛作品...<?php endif; ?></h3>
             </div>
      <?php endif; ?>
   </div>
    
    
    <?= \yii\widgets\LinkPager::widget([
        'pagination' => $dataProvider->pagination,
    ]);
    ?>
</div>

<?php $this->beginBlock('game-video-vote-Js') ?> 

$(function(){
    $(document).on("click","a.game_vote",function(e){        
        var videoId = $(this).prev().val();
        var vote = $(this);
        if(vote.attr("disabled") == "disabled") {
            vote.popover("destroy");
            return;
        }
        var imgUrl;
        $.ajax({
        	url:"<?= Url::to(['game/ajax-vote']) ?>",
        	async:false,
        	type: "POST",
        	data: {videoId: videoId},
        	success: function(e){
                    if(e.success == false) {           
                        alerting({title:"消息提示",msg:e.msg});
                        return;
                    }
                    
                    imgUrl = e.data;
                    //vote.attr("data-content","<span class=\"text-center\"><img height=\"150px\" width=\"150px\" src='"+imgUrl+"' /></span>");
        	}
        });
        // imgUrl = "http://my.frontend.verycrew.com/image/logo.png";
        vote.attr("data-content","<span class=\"text-center\"><img height=\"150px\" width=\"150px\" src='"+imgUrl+"' /></span>");
        vote.popover("show");
        
    }); 
    
    $('[data-toggle="popover"]').popover();

    $("#list-sort").change(function(){
        var val = $(this).val();
        var url = "<?= Url::to(['game/view','id'=>$model->id]) ?>&sorting="+val + "#vote";
        location.href = url;
    }); 
    
    $(".search-btn").click(function(){
        var val = $.trim($(".search-game-video").val());
        
        if(val == "") {
            location.href = "<?= Url::to(['game/view','id'=>$model->id]) ?>" + "#vote";
            return;
        }
        
        location.href = "<?= Url::to(['game/view','id'=>$model->id]) ?>&search=" + val + "#vote";
    });
    
 
});

<?php $this->endBlock() ?> 
<?php $this->registerJs($this->blocks['game-video-vote-Js'], \yii\web\View::POS_END); ?>

<?=
$this->render('/inc/_wxshare', [
    'title' => $model->name,
    'content' => strip_tags($model->content),
    'logo' => '/uploads/2016/08/11/147092177573581.jpg',
    'shareUrl' => CURRENTURL,
])
?>