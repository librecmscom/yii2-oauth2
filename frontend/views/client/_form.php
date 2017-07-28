<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model yuncms\oauth2\models\Client */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin([
    'layout' => 'horizontal',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'validateOnBlur' => false,
]); ?>
<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'domain') ?>
<?= $form->field($model, 'provider') ?>
<?= $form->field($model, 'icp') ?>
<?= $form->field($model, 'grant_type')->dropDownList(['authorization_code' => 'Authorization Code', 'password' => 'Password'], [
    'prompt' => Yii::t('oauth2', 'All Type')
]); ?>
<?= $form->field($model, 'redirect_uri'); ?>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('oauth2', 'Create') : Yii::t('oauth2', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>