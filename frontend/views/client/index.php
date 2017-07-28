<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

/*
 * @var yii\web\View $this
 */

$this->title = Yii::t('oauth2', 'App Manage');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-2">
        <?= $this->render('@yuncms/user/frontend/views/_profile_menu') ?>
    </div>
    <div class="col-md-10">
        <h2 class="h3 profile-title"><?= Yii::t('oauth2', 'Apps') ?>
            <div class="pull-right">
                <a class="btn btn-primary" href="<?= Url::to(['create']) ?>"><?= Yii::t('oauth2', 'Create') ?></a>
            </div>
        </h2>
        <div class="row">
            <div class="col-md-12">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => "{items}\n{pager}",
                    'columns' => [
                        [
                            'label' => Yii::t('oauth2', 'App Name'),
                            'value' => function ($model) {
                                return Html::a(Html::encode($model->name), ['/oauth2/client/view', 'id' => $model->client_id]);
                            },
                            'format' => 'html'
                        ],
                        'domain',
                        'provider',
                        'created_at:datetime',
                        'updated_at:datetime',
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
