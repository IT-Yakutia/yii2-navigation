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
        <?php
        if (!$model->isNewRecord) {
        ?>
            <?= Html::a('Добавить вкладки', ['back-sub/create', 'parent' => $model->id], ['class' => 'btn btn-success']) ?>
        <?php
        }
        ?>
    </div>

    <?php
    if (!$model->isNewRecord) {
    ?>
        <?= GridView::widget([
            'tableOptions' => [
                'class' => 'striped bordered my-responsive-table',
                'id' => 'sortable'
            ],
            'rowOptions' => function ($model, $key, $index, $grid) {
                return ['data-sortable-id' => $model->id];
            },
            'options' => [
                'data' => [
                    'sortable-widget' => 1,
                    'sortable-url' => Url::toRoute(['sorting']),
                ]
            ],
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => SerialColumn::class],
                [
                    'attribute' => 'name',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::a(Html::tag('i', 'create', ['class' => "material-icons"]). $model->name, ['back-sub/update', 'id' => $model->id]);
                    }
                ],
                [
                    'attribute' => 'link',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::a($model->link, ['back-sub/update', 'id' => $model->id]);
                    }
                ],
                [
                    'attribute' => 'is_publish',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->is_publish ? '<i class="material-icons green-text">done</i>' : '<i class="material-icons red-text">clear</i>';
                    },
                    'filter' => [0 => 'Нет', 1 => 'Да'],
                ],
                [
                    'attribute' => 'color_switcher',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->color_switcher ? '<i class="material-icons green-text">done</i>' : '<i class="material-icons red-text">clear</i>';
                    },
                    'filter' => [0 => 'Нет', 1 => 'Да'],
                ],
                [
                    'attribute' => 'created_at',
                    'format' => 'datetime',
                ],
                [
                    'class' => MaterialActionColumn::class,
                    'template' => '{back-sub/delete}',
                    'buttons' => [
                        'back-sub/delete' => function ($url, $model, $key) {
                            $icon = Html::tag('i', 'delete', ['class' => "material-icons"]);
                            $options = [
                                'title' => Yii::t('yii', 'Удалить'),
                                'aria-label' => Yii::t('yii', 'Удалить'),
                                'data-pjax' => '0',
                                'data' => ['method' => 'post']
                            ];

                            return Html::a($icon, $url, $options);
                        }
                    ]

                ],
                [
                    'class' => Column::class,
                ],
            ],
            'pager' => [
                'class' => LinkPager::class,
                'options' => ['class' => 'pagination center'],
                'prevPageCssClass' => '',
                'nextPageCssClass' => '',
                'pageCssClass' => 'waves-effect',
                'nextPageLabel' => '<i class="material-icons">chevron_right</i>',
                'prevPageLabel' => '<i class="material-icons">chevron_left</i>',
            ],
        ]); ?>

    <?php
    }
    ?>

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