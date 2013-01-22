<?php
/* @var $this PagesController */
/* @var $model Pages */

$this->breadcrumbs=array(
	'Статические страницы'=>array('admin'),
	'Создание',
);


?>

<h1>Создание страницы</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>