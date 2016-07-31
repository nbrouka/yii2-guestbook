<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Administration Guestbook';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="guestbook-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Guestbook', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'ip',
            'browser',
            'name',
            'email:email',
            // 'homepage',
            // 'message:ntext',
            // 'msgputtime',
            // 'image',
            // 'file',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
