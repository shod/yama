<?php
/* @var $this AdvertsController */
/* @var $model Adverts */

$this->breadcrumbs=array(
	'Adverts'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Adverts', 'url'=>array('index')),
	array('label'=>'Create Adverts', 'url'=>array('create')),
	array('label'=>'View Adverts', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Adverts', 'url'=>array('admin')),
);
?>

<h1>Update Adverts <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>