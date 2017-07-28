<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

/*
 * @var yii\web\View $this
 */

$this->title = Yii::t('oauth2', 'Show App: ') . ' ' . $model->name;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('oauth2', 'App Manage'),
    'url' => ['index']
];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->client_id]];
$this->params['breadcrumbs'][] = Yii::t('oauth2', 'Show');
?>

<div class="row">
    <div class="col-md-2">
        <?= $this->render('@yuncms/user/frontend/views/_profile_menu') ?>
    </div>
    <div class="col-md-10">
        <h2 class="h3 profile-title"><?= Yii::t('oauth2', 'Show App: ') . ' ' . $model->name ?>
            <div class="pull-right">
                <?= Html::a(Yii::t('oauth2', 'Update'), ['update', 'id' => $model->client_id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('oauth2', 'Delete'), ['delete', 'id' => $model->client_id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('oauth2', 'Are you sure you want to delete this app?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        </h2>
        <div class="row">
            <div class="col-md-12">


                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'name',
                        'domain',
                        'provider',
                        'client_id',
                        'client_secret',
                        'redirect_uri',
                        [
                            'label' => Yii::t('oauth2', 'Grant type'),
                            'value' => function ($model) {
                                if(empty($model->grant_type)){
                                    return Yii::t('oauth2', 'All Type');
                                }
                                return $model->grant_type;
                            }
                        ],
                        'scope',
                        'created_at:datetime',
                        'updated_at:datetime',

                    ],
                ]) ?>

            </div>
        </div>
    </div>
</div>