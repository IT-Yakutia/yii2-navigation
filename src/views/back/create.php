<?php

$this->title = 'Новая вкладка';
?>
<div class="navigation-create">
    <div class="row">
        <div class="col s12">
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>
	</div>
</div>
