<?php

$this->title = 'Новая вкладка в '. $model->parentName;
?>
<div class="navigation-sub-create">
    <div class="row">
        <div class="col s12">
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>
	</div>
</div>