<div class="body">
<?= CHtml::link(Yii::t('Sell', 'Добавить объявление'), array('/adverts/create')); ?>
<?php 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$model->search(),
		'itemView'=>'_item',
	)); 

?>
</div>