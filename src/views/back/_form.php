<?php

use uraankhayayaal\materializecomponents\checkbox\WCheckbox;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use ityakutia\navigation\models\Navigation;
use uraankhayayaal\materializecomponents\grid\MaterialActionColumn;
use uraankhayayaal\sortable\grid\Column;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>

<div class="navigation-form">

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
        <div class="col s12 m4 l4">
            <div class='form-group field-attribute-parentId'>
                <?= Html::label('Родительский элемент', 'parent', ['class' => 'control-label']); ?>
                <?= Html::dropdownList(
                    'Navigation[parentId]',
                    $model->parentId,
                    $model::getNodes($model->id),
                    ['prompt' => 'Нет родительских элементов', 'class' => 'form-control']
                ); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m6 l6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col s12 m6 l6">
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