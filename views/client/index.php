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
        <?= $this->render('@yuncms/user/views/_profile_menu') ?>
    </div>
    <div class="col-md-10">
        <h2 class="h3 profile-title"><?= Yii::t('oauth2', 'Apps') ?>
            <div class="pull-right">
                <a class="btn btn-primary" href="<?= Url::to(['create']) ?>"><?=Yii::t('oauth2', 'Create')?></a>
            </div>
        </h2>
        <div class="row">
            <div class="col-md-12">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => "{items}\n{pager}",
                    'columns' => [
                        'client_id',
                        'client_secret',
                        'redirect_uri',
                        'grant_type',
                        'scope',
                        'created_at:datetime',
                        'updated_at',
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
