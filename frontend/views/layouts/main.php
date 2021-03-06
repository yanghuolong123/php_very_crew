<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\util\CommonUtil;
use yii\helpers\Url;
use app\models\extend\Article;
use app\util\Constant;
use app\components\ext\ExtNavBar;

AppAsset::register($this);

$redis = Yii::$app->redis;
$user_msg = $redis->HGET(Constant::UserMsg, Constant::UserMsg.Yii::$app->user->id);
$user_private_msg = $redis->HGET(Constant::UserPrivateMsg, Constant::UserPrivateMsg.Yii::$app->user->id);
$user_news = $redis->HGET(Constant::UserNews, Constant::UserNews.Yii::$app->user->id);
$tips = $user_msg || $user_private_msg || $user_news ? '<span class="glyphicon glyphicon-volume-up" style="color:red;"></span>' : '';
$footerNav = Article::getByGroopKey('footer_nav');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
            <?php
            ExtNavBar::begin([
                'brandLabel' => '<img style="height:32px;" src="/image/logo.png" />',
                'brandUrl' => Yii::$app->homeUrl,
                'screenReaderToggleText' => '导航',
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-left'],
                'items' => [
                    ['label' => '首页', 'url' => ['/home/index']],
                    ['label' => '上传作品', 'url' => ['/video/create']],
                    ['label' => '发布计划', 'url' => ['/plan/create']],
                    ['label' => '参加比赛', 'url' => ['/game/index']],
                    ['label' => '搜作品', 'url' => ['/video/index']],
                    ['label' => '搜人员', 'url' => ['/user/index']],
                    ['label' => '搜计划', 'url' => ['/plan/index']],
                    ['label' => '论坛', 'url' => ['/forum-forum/index']],
                ],
            ]);

            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    [
                        'label' => !Yii::$app->user->isGuest ? '<img class="avatar" src="' . CommonUtil::cropImgLink(Yii::$app->user->identity->avatar, 50, 50) . '">  ' . Yii::$app->user->identity->nickname . ' ' . $tips : '',
                        'visible' => !Yii::$app->user->isGuest,
                        'encode' => false,
                        'linkOptions' => ['class' => 'avatar'],
                        'items' => [
                            ['label' => '<span class="glyphicon glyphicon-user"></span> 我的主页', 'url' => ['user/view', 'id' => Yii::$app->user->id], 'encode' => false],
                            ['label' => '<span class="glyphicon glyphicon-comment"></span> 我的留言 <span class="tip_num">' . ($user_msg ? '(' . $user_msg . ')' : '') . '</span>', 'url' => ['comment/my-list', 'type' => 2], 'encode' => false],
                            ['label' => '<span class="glyphicon glyphicon-envelope"></span> 我的私信 <span class="tip_num">' . ($user_private_msg ? '(' . $user_private_msg . ')' : '') . '</span>', 'url' => ['comment/my-list', 'type' => 3], 'encode' => false],
                            ['label' => '<span class="glyphicon glyphicon-bell"></span> 我的消息 <span class="tip_num">' . ($user_news ? '(' . $user_news . ')' : '') . '</span>', 'url' => ['comment/my-list', 'type' => 4], 'encode' => false],
                            '<li class="divider"></li>',
                            ['label' => '我的计划', 'url' => ['plan/my']],
                            ['label' => '我的作品', 'url' => ['video/my']],
                            ['label' => '我的帖子', 'url' => ['forum-thread/my']],
                            '<li class="divider"></li>',
                            '<li>'
                            . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
                            . Html::submitButton(
                                    '<span class="glyphicon glyphicon-log-out"></span> 安全退出', ['class' => 'btn btn-link']
                            )
                            . Html::endForm()
                            . '</li>',
                        ],
                    ],
                    [
                        'label' => '登录',
                        'url' => ['site/login'],
                        'visible' => Yii::$app->user->isGuest,
                    ],
                    [
                        'label' => '注册',
                        'url' => ['site/register'],
                        'visible' => Yii::$app->user->isGuest,
                    ],
                ],
            ]);
            ExtNavBar::end();
            ?>

            <div class="container">
            <?=
            Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ])
            ?>
                <?= $content ?>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <div class="footer_top">
                    <?php foreach ($footerNav as $article): ?>
                        <a href="<?= Url::to(['article/view', 'id' => $article->id]) ?>"><?= $article->title ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </footer>

        <?=
        $this->render('/inc/_wxshare', [
            'title' => '非常剧组',
            'content' => '拍摄爱好者自行成立并专注服务于我们拍摄者自己的平台，我们致力于利用互联网让传统的拍摄过程变得便捷、有趣、高效，让广大视频拍摄爱好者、从业者走到一起，共同营造一个高活跃度的创作圈，并与广大商家一道，挖掘视频作品的价值，构建视频营销生态链，创造新的视频营销模式，最终实现创作者与商家的共赢。',
            'logo' => '/uploads/2016/08/11/147092177573581.jpg',
            'shareUrl' => Yii::$app->request->hostInfo,
        ])
        ?>
        <?=
        $this->render('/inc/_tracerecord');
        ?>
        <?php $this->endBody() ?>
        
    </body>
</html>
<?php $this->endPage() ?>
