<?php

use yii\helpers\Html;
use yii\grid\GridView;

/*
 * @var yii\web\View $this
 */

$this->title = Yii::t('oauth2', 'Client Manage');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-2">
        <?= $this->render('@yuncms/user/views/setting/_menu') ?>
    </div>
    <div class="col-md-10">
        <h2 class="h3 profile-title"><?= Yii::t('oauth2', 'Clients') ?></h2>
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
                        ['class' => 'yii\grid\ActionColumn', 'template' => '{delete}'],
                    ],
                ]);
                ?>
                <div class="form-group">
                    <div class="edu-btn">
                        <?= Html::a(Yii::t('user', 'Create'), ['create'], ['class' => 'btn btn-primary btn-block']) ?>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
