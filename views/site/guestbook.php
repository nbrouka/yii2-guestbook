<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
use vova07\imperavi\Widget;

$this->title = 'Guestbook';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-guestbook">
    <h1><?= Html::encode($this->title) ?></h1>
	

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
		'itemView' => '/guestbook/_list',
		'layout' => "{sorter}\n{items}\n{pager}",
    ]); ?>

    <?php $this->registerJs("
        $('#w0 ul.sorter').prepend('<li><b>Sorted by:</b></li>');
    "); ?>

    <div class="guestbook-form col-lg-6">
	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Name (*required field)') ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label('Email (*required field)') ?>
 
    <?= $form->field($model, 'message')->widget(Widget::className(), [
            'settings' => [
            'lang' => 'en',
            'minHeight' => 200,
            ]
        ]);
    ?>
    

    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div><button id="refresh-captcha">Refresh captcha</button></div>',
        'imageOptions' => ['id' => 'my-captcha-image']
    ]) ?>
    <?php $this->registerJs("
        $('#refresh-captcha').on('click', function(e){
            e.preventDefault();

            $('#my-captcha-image').yiiCaptcha('refresh');
        })
    "); ?>

    <?= $form->field($model, 'homepage')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fileImage')->fileInput()->label('Load image') ?>

	<?= $form->field($model, 'fileFile')->fileInput()->label('Load file') ?>

    <div class="form-group">
        <?= Html::submitButton('Add message', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>
</div>