<?php

$this->title = 'Редактирование: ' . $model->title;
?>
<div class="navigation-update">
    <div class="row">
        <div class="col s12">
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>
	</div>
</div>
