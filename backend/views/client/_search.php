<?php

use yii\helpers\Html;
use xutl\inspinia\ActiveForm;

/* @var $this yii\web\View */
/* @var $model yuncms\oauth2\backend\models\ClientSearch */
/* @var $form ActiveForm */
?>

<div class="client-search pull-right">

    <?php $form = ActiveForm::begin([
        'layout' => 'inline',
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'client_id', [
        'inputOptions' => [
            'placeholder' => $model->getAttributeLabel('client_id'),
        ],
    ]) ?>

    <?= $form->field($model, 'client_secret', [
        'inputOptions' => [
            'placeholder' => $model->getAttributeLabel('client_secret'),
        ],
    ]) ?>

    <?= $form->field($model, 'user_id', [
        'inputOptions' => [
            'placeholder' => $model->getAttributeLabel('user_id'),
        ],
    ]) ?>

    <?php // echo $form->field($model, 'redirect_uri') ?>

    <?php // echo $form->field($model, 'grant_type') ?>

    <?php // echo $form->field($model, 'scope') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'domain') ?>

    <?php // echo $form->field($model, 'provider') ?>

    <?php // echo $form->field($model, 'icp') ?>

    <?php // echo $form->field($model, 'registration_ip') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('oauth2', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('oauth2', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
