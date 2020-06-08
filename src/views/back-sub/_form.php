<?php

use uraankhayayaal\materializecomponents\checkbox\WCheckbox;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="navigation-sub-form">

    <?php $form = ActiveForm::begin([
        'errorCssClass' => 'red-text',
    ]); ?>

    <div class="row">
        <div class="col s12 m4 l4">
            <?= WCheckbox::widget(['model' => $model, 'attribute' => 'is_publish']); ?>
        </div>
        <div class="col s12 m4 l4">
            <?= WCheckbox::widget(['model' => $model, 'attribute' => 'color_switcher']); ?>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m4 l6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col s12 m4 l6">
            <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn']) ?>
    </div>

    <div class="fixed-action-btn">
        <?= Html::submitButton('<i class="material-icons">save</i>', [
            'class' => 'btn-floating btn-large waves-effect waves-light tooltipped',
            'title' => 'Сохранить',
            'data-position' => "left",
            'data-tooltip' => "Сохранить",
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>