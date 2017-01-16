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
<?= $form->field($model, 'provider') ?>
<?= $form->field($model, 'icp') ?>
<?= $form->field($model, 'redirect_uri'); ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('oauth2', 'Create') : Yii::t('oauth2', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>