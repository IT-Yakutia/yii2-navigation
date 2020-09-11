<?php

use yii\helpers\Html;

?>

<div class="box-drag--item" id="navitem_<?= $model->id ?>">
    <div class="box-drag--title child-ident">
        <?= $model->name ?>
    </div>
    <div class="box-drag--others">
        <div class="box-drag--alias">
            Ссылка: <?= Html::a($model->link, $model->link); ?>
        </div>
        <div class="box-drag--list">
            <?= Html::a('<i class="material-icons">edit</i>', ['update', 'id' => $model->id]); ?>
            <?= Html::a('<i class="material-icons">delete</i>', ['delete', 'id' => $model->id], [
                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'data-method' => 'post',
            ]); ?>
        </div>
    </div>

    <div id="model-<?= $model->id ?>" class="box-drag--item--internal box-drag">
        <?php foreach ($model->children(1)->all() as $key => $subItem) { ?>
            <?= $this->render('_item_view', [
                'model' => $subItem
            ]); ?>
        <?php } ?>
    </div>
</div>