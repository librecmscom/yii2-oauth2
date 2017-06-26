<?php

use yii\helpers\Html;
use xutl\inspinia\Box;
use xutl\inspinia\Toolbar;
use xutl\inspinia\Alert;

/* @var $this yii\web\View */
/* @var $model yuncms\oauth2\models\Client */

$this->title = Yii::t('oauth2', 'Create Client');
$this->params['breadcrumbs'][] = ['label' => Yii::t('oauth2', 'Manage Client'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 client-create">
            <?= Alert::widget() ?>
            <?php Box::begin([
                'header' => Html::encode($this->title),
            ]); ?>
            <div class="row">
                <div class="col-sm-4 m-b-xs">
                    <?= Toolbar::widget(['items' => [
                        [
                            'label' => Yii::t('oauth2', 'Manage Client'),
                            'url' => ['index'],
                        ],
//                        [
//                            'label' => Yii::t('oauth2', 'Create Client'),
//                            'url' => ['create'],
//                        ],
                    ]]); ?>
                </div>
                <div class="col-sm-8 m-b-xs">

                </div>
            </div>

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
            <?php Box::end(); ?>
        </div>
    </div>
</div>
