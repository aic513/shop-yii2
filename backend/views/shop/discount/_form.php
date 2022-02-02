<?php

use kartik\widgets\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model shop\forms\manage\Shop\DiscountForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="discount-form">
    
    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-default">
        <div class="box-body">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'percent')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'from_date')->widget(DatePicker::class,
                [
                    'model' => $model,
                    'attribute' => 'from_date',
                    'options' => ['placeholder' => 'Select date to start discount'],
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'format' => 'yyyy-M-dd',
                        'autoclose' => true,
                    ]
                ]) ?>
            <?= $form->field($model, 'to_date')->widget(DatePicker::class,
                [
                    'model' => $model,
                    'attribute' => 'to_date',
                    'options' => ['placeholder' => 'Select date to finish discount'],
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'format' => 'yyyy-M-dd',
                        'autoclose' => true,
                    ]
                ]) ?>
            <?= $form->field($model, 'sort')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>