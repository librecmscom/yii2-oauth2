<?php
use yii\helpers\Html;
use xutl\inspinia\ActiveForm;

/* @var \yii\web\View $this */
/* @var yuncms\oauth2\models\Client $model */
/* @var ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['layout' => 'horizontal', 'enableAjaxValidation' => true, 'enableClientValidation' => false,]); ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
<div class="hr-line-dashed"></div>

<?= $form->field($model, 'domain')->textInput(['maxlength' => true]) ?>
<div class="hr-line-dashed"></div>

<?= $form->field($model, 'provider')->textInput(['maxlength' => true]) ?>
<div class="hr-line-dashed"></div>

<?= $form->field($model, 'icp')->textInput(['maxlength' => true]) ?>
<div class="hr-line-dashed"></div>

<?= $form->field($model, 'redirect_uri')->textInput(['maxlength' => true]) ?>
<div class="hr-line-dashed"></div>

<?= $form->field($model, 'grant_type')->dropDownList(['authorization_code' => 'Authorization Code', 'password' => 'Password'], [
    'prompt' => Yii::t('oauth2', 'All Type')
]); ?>

<?= $form->field($model, 'scope')->textarea(['rows' => 6]) ?>
<div class="hr-line-dashed"></div>




<div class="form-group">
    <div class="col-sm-4 col-sm-offset-2">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

