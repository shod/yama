<?php
/* @var $this PagesController */
/* @var $model Pages */

$this->breadcrumbs=array(
	'Статические страницы'=>array('admin'),
	$model->title=>array('/'.$model->url),
	'Редактирование',
);

$this->menu=array(
	array('label'=>'Создание', 'url'=>array('create')),
);
?>

<h1>Редактирование старинцы " <?php echo $model->title; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>