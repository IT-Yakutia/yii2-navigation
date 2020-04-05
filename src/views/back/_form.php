<?php

use uraankhayayaal\materializecomponents\checkbox\WCheckbox;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use ityakutia\navigation\models\Navigation;

$navigation = $model->isNewRecord 
    ? ArrayHelper::map(Navigation::find()->where(['parent_id' => null])->all(), 'id', 'name')
    : ArrayHelper::map(Navigation::find()->where(['!=', 'id', $model->id])->andWhere(['parent_id' => null])->all(), 'id', 'name');

?>

<div class="navigation-form">

    <?php $form = ActiveForm::begin([
        'errorCssClass' => 'red-text',
    ]); ?>

    <?= WCheckbox::widget(['model' => $model, 'attribute' => 'is_publish']); ?>

    <div class="row">
        <div class="col s12 m4 l6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col s12 m4 l6">
            <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col s12 m4 l6">
            <?= $form->field($model, 'parent_id')->dropDownList($navigation, ['prompt' => 'Выберите']) ?>
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