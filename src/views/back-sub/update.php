<?php

$this->title = 'Редактирование: ' . $model->name;
?>
<div class="navigation-sub-update">
    <div class="row">
        <div class="col s12">
		    <?= $this->render('_form', [
				'model' => $model,
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider
		    ]) ?>
		</div>
	</div>
</div>