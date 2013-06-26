<?php 
	$noTop = true;
	foreach($data as $m){
		$noTop = false;
		$this->renderPartial('_item', array('data' => $m, 'users' => $users, 'aViews' => $aViews));
	}
?>
<?php if($noTop): ?>
	<div class="nothing">По запросу "<?= Yii::app()->request->getParam('q') ?>" полных совпадений не найдено</div>
<?php endif; ?>