<?php

use ityakutia\navigation\assets\NavSortAsset;
use yii\helpers\Html;

NavSortAsset::register($this);

$this->title = 'Редактирование: ' . $model->name;
?>
<div class="navigation-update">
    <div class="row">
        <div class="col s12">
            <p>
                <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <div class="fixed-action-btn">
                <?= Html::a('<i class="material-icons">add</i>', ['create'], [
                    'class' => 'btn-floating btn-large waves-effect waves-light tooltipped',
                    'title' => 'Сохранить',
                    'data-position' => "left",
                    'data-tooltip' => "Добавить",
                ]) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="box-drag--wpr">
                <div id="stbList" class="box-drag">
                    <?= $this->render('_item_view', [
                        'model' => $model,
                    ]); ?>
                </div>
            </div>
		</div>
	</div>
</div>