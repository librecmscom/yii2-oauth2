<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/*
 * @var yii\web\View $this
 */

$this->title = Yii::t('oauth2', 'Show App: ') . ' ' . $model->name;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('oauth2', 'Apps'),
    'url' => ['index']
];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->client_id]];
$this->params['breadcrumbs'][] = Yii::t('oauth2', 'Show');
?>

<div class="row">
    <div class="col-md-2">
        <?= $this->render('@yuncms/user/views/_profile_menu') ?>
    </div>
    <div class="col-md-10">
        <h2 class="h3 profile-title"><?= Yii::t('oauth2', 'Show App: ') . ' ' . $model->name ?></h2>
        <div class="row">
            <div class="col-md-12">
        <p>
            <?= Html::a(Yii::t('oauth2', 'Update'), ['update', 'id' => $model->client_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('oauth2', 'Delete'), ['delete', 'id' => $model->client_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('oauth2', 'Are you sure you want to delete this app?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name',
                'domain',
                'provider',
                'icp',

            ],
        ]) ?>

    </div>
</div></div></div>