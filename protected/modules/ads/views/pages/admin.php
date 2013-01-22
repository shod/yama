<?php
/* @var $this PagesController */
/* @var $model Pages */

$this->breadcrumbs=array(
	'Статические страницы',
);

$this->menu=array(
	array('label'=>'Создать страницу', 'url'=>array('create')),
);
?>

<h1>Управление статическими страницами</h1>

<p>
При поиске вы можите использовать символы (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
или <b>=</b>) перед тем как указвать значение.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'pages-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'cssFile'=>$this->module->assetsUrl.'/css/styles-admin.css',
	'columns'=>array(
		'id',
		'title',
		'url',
		array(
			'class'=>'CButtonColumn',
                        'viewButtonUrl'=>'Yii::app()->createUrl("/" . $data->url)',
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
