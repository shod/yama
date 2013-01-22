<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Пользователи'
);

//$this->menu=array(
//	array('label'=>'Добавить пользователя', 'url'=>array('create')),
//);

?>

<h1>Управление пользователями</h1>

<p>
При поиске вы можите использовать символы (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
или <b>=</b>) перед тем как указвать значение.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'users-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'cssFile'=>$this->module->assetsUrl.'/css/styles-admin.css',
	'columns'=>array(
                array(
//                    'name' => '',
                    'type' => 'html',
                    'value' => 'CHtml::image("/images/users/".$data->id."/avatar_100x100.jpg")',
                    'htmlOptions' => array('width' => '50px', 'height' => '50px'),
                ),
                array(
                    'name' => 'id',
                    'htmlOptions' => array('width' => '20px'),
                ),
		'login',
                array(
                        'name'=>'role',
                        'value'=>'Users::$roles[$data->role]',
                        'filter' => CHtml::activeDropDownList($model, 'role', Users::$roles, array('empty' => '')),
                        'htmlOptions' => array('width' => '90px'),
                    ),
		'email',
//                array(
//                        'name'=>'status',
//                        'value'=>'Users::$statuses[$data->status]',
//                    ),
                array(
                        'name'=>'status',
                        'value'=>'Users::$statuses[$data->status]',
                        'filter' => CHtml::activeDropDownList($model, 'status', Users::$statuses, array('empty' => '')),
                        'htmlOptions' => array('width' => '70px'),
                    ),
//		'date_add',
//		'date_edit',
		array(
			'class'=>'CButtonColumn',
                        'viewButtonUrl'=>'Yii::app()->createUrl("user/index", array("id" => $data->id))',
                        'template' => '{view} {update} {delete}',
                        'buttons' => array(
                            'view' => array(
                                'label' => '',
                                'imageUrl'=>false,  // make sure you have an image
                            ),
                            'update' => array(
                                'label' => '',
                                'imageUrl'=>false,  // make sure you have an image
                            ),
                            'delete' => array(
                                'label' => '',
                                'imageUrl'=>false,  // make sure you have an image
                                'options' => array('class' => 'deleteButton'),
                            ),
                        ),
		),
	),
)); ?>
