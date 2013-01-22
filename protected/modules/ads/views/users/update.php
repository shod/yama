<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Users'=>array('admin'),
	'Update',
);

$this->menu=array(
	array('label'=>'Все пользователи', 'url'=>array('admin')),
        array('label'=>'Комментарии пользователя', 'url'=>array('admin')),
);
?>

<h1>Update Users <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>