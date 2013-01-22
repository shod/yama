<?php
/* @var $this AdvertsController */
/* @var $dataProvider CActiveDataProvider */
?>

<h1>Adverts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
