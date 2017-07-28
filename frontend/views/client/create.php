<?php
/*
 * @var yii\web\View $this
 */
$this->title = Yii::t('oauth2', 'Create App');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('oauth2', 'App Manage'),
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-2">
        <?= $this->render('@yuncms/user/frontend/views/_profile_menu') ?>
    </div>
    <div class="col-md-10">
        <h2 class="h3 profile-title"><?= Yii::t('oauth2', 'Create App') ?></h2>
        <div class="row">
            <div class="col-md-12">
                <?= $this->render('_form', ['model' => $model]) ?>
            </div>
        </div>
    </div>
</div>