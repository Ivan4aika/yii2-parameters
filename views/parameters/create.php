<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Parameters */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Create Parameters';
$this->params['breadcrumbs'][] = ['label' => 'Parameters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="parameters-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="parameters-form">

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'type')->dropDownList([1 => 'Type 1', 2 => 'Type 2']) ?>

        <?= $form->field($model, 'icon')->fileInput() ?>

        <?= $form->field($model, 'icon_gray')->fileInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
