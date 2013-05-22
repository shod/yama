<?php if(!count($model)): ?>
		<div class="nothing">По запросу "<?= Yii::app()->request->getParam('q') ?>" ничего не найдено</div>
<?php 
	endif;

	foreach($model as $m){
		$this->renderPartial('_item', array('data' => $m, 'users' => $users, 'aViews' => $aViews));
	}