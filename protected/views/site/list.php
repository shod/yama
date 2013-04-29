<?php 
	foreach($model as $m){
		$this->renderPartial('_item', array('data' => $m, 'users' => $users));
	}
?>