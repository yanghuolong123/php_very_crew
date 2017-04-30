<?php 

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = '找回密码';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php if (Yii::$app->session->hasFlash('retrievePasswordHasSendEmail')): ?>
<div class="alert alert-success">
    <h4>重置密码邮件已发出</h4>
    <p class="text-success center-block">一封包含了重设密码链接的邮件已经发送到您的注册邮箱，按照邮件中的提示，即可重设您的密码</p>
</div>
<?php else: ?>
<div class="site-register">
     
        <?php
        $form = ActiveForm::begin(['id' => 'register-form',
                    'options' => ['class' => 'form-horizontal'],
                    //'enableAjaxValidation' => true,
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-offset-2 col-lg-6\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-2 control-label'],
                    ],
        ]);
        ?>
    
        <div class="form-group ">
            <div class="col-lg-8 col-md-offset-1">
        <p class="text-danger center-block">将会发送一个找回密码的特别链接到您的邮箱，通过该链接可以进入重置密码的页面</p>
            </div>
        </div>
    
        <?= $form->field($model, 'username')->textInput(['autofocus' => true,'placeholder'=>'邮箱或手机号']) ?>
    
        <?= $form->field($model, 'email')->label('验证邮箱') ?>
        
         
        <div class="form-group">
            <div class="col-sm-2 col-lg-offset-2">
            <?= Html::submitButton('找回密码', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
            
</div>
<?php endif; ?>

