<?php

/*
 * @var yii\web\View $this
 */
$this->title = Yii::t('oauth2', 'Update App: ') . ' ' . $model->name;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('oauth2', 'Apps'),
    'url' => ['index']
];
$this->params['breadcrumbs'][] = ['label' => $model->client_id, 'url' => ['view', 'id' => $model->client_id]];
$this->params['breadcrumbs'][] = Yii::t('oauth2', 'Update');
?>
<div class="row">
    <div class="col-md-2">
        <?= $this->render('@yuncms/user/views/_profile_menu') ?>
    </div>
    <div class="col-md-10">
        <h2 class="h3 profile-title"><?= Yii::t('oauth2', 'Update App: ') . ' ' . $model->name ?></h2>
        <div class="row">
            <div class="col-md-12">
                <?= $this->render('_form', ['model' => $model]) ?>
            </div>
        </div>
    </div>
</div>