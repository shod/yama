<?php
/* @var $this AdvertsController */
/* @var $model Adverts */

$this->breadcrumbs=array(
	'Adverts'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Adverts', 'url'=>array('index')),
	array('label'=>'Create Adverts', 'url'=>array('create')),
	array('label'=>'Update Adverts', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Adverts', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Adverts', 'url'=>array('admin')),
);
?>

<h1>View Adverts #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'text',
	),
)); ?>
