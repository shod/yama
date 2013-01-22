<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Комментарии' => array('comments/index'),
        'Список'
);

//$this->menu=array(
//	array('label'=>'Добавить пользователя', 'url'=>array('create')),
//);

?>



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'comments-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'selectableRows' => 1,
        'selectionChanged'=>'function(id){$.post()}',
        'rowCssClassExpression'=>'($data->status==Comments::STATUS_UNPUBLISHED)?"unpublished":(($data->status==Comments::STATUS_PUBLISHED)?"published":(($data->status==Comments::STATUS_DELETED)?"delete":"unmoderated"))',
        'cssFile'=>$this->module->assetsUrl.'/css/styles-admin.css',
	'columns'=>array(
                array(
                    'name' => 'id',
                    'htmlOptions' => array('width' => '20px'),
                ),
                array(
                    'name' => 'userLogin',
                    'type' => 'html',
                    'value' => '($data->user) ? CHtml::link($data->user->login, array("/user/index", "id" => $data->user->id)) : ""'
                ),
                array(
                    'name' => 'text',
                    
                    'value' => '$data->text'
                ),
                array(
                    'name' => 'likes',
                    'htmlOptions' => array('width' => '50px')
                ),
                array(
                    'name' => 'dislikes',
                    'htmlOptions' => array('width' => '50px')
                ),
                array(
                        'name'=>'status',
                        'value'=>'Comments::$statuses[$data->status]',
                        'filter' => CHtml::activeDropDownList($model, 'status', Comments::$statuses, array('empty' => '')),
                        'htmlOptions' => array('width' => '90px'),
                    ),
//		'date_add',
//		'date_edit',
		array(
			'class'=>'CButtonColumn',
                        'template' => '{approove} {show} {deleteButton}',
                        'buttons' => array(
                            'approove' => array(
                                'label'=>'',     // text label of the button
//                                'imageUrl'=>$this->module->assetsUrl.'/images/update.png',  // make sure you have an image
                                'url'=>'Yii::app()->createUrl("ads/comments/approove", array("model" => "' . $modelTitle . '", "id"=>$data->id))',
                                'options' => array( 'ajax' => array('type' => 'post', 'url'=>'js:$(this).attr("href")', 'success' => 'js:function(data) { $.fn.yiiGridView.update("comments-grid")}'), 'class' => 'approove'),
                            ),
                            'show' => array(
                                'label'=>'',     // text label of the button
//                                'imageUrl'=>$this->module->assetsUrl.'/images/update.png',  // make sure you have an image
                                'url'=>'Yii::app()->createUrl("ads/comments/tree", array("model" => "' . $modelTitle . '", "id"=>$data->id))',
                                'options' => array( 'ajax' => array('type' => 'post', 'url'=>'js:$(this).attr("href")', 'success' => 'js:function(data) { $("#viewModalContent").html(data); $("#viewModal").dialog("open"); return false;}'), 'class' => 'show'),
                            ),
                            'deleteButton' => array(
                                'label'=>'',     // text label of the button
//                                'imageUrl'=>$this->module->assetsUrl.'/images/update.png',  // make sure you have an image
                                'url'=>'Yii::app()->createUrl("ads/comments/delete", array("model" => "' . $modelTitle . '", "id"=>$data->id))',
                                'options' => array( 'ajax' => array('type' => 'post', 'url'=>'js:$(this).attr("href")', 'success' => 'js:function(data) { $.fn.yiiGridView.update("comments-grid")}'), 'class' => 'deleteButton'),
                            )
                        ),
		),
	),
)); ?>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'viewModal',
    'options'=>array(
        'title'=>'Comment View',
        'width'=>800,
        'height'=>600,
        'autoOpen'=>false,
        'resizable'=>false,
        'modal'=>true,
        'overlay'=>array(
            'backgroundColor'=>'#000',
            'opacity'=>'0.5'
        ),
        'buttons'=>array(
            'Approove'=>'js:function(){
                jQuery.ajax({"id":"approoveLink","type":"POST","url":$("#approoveUrl").attr("value"),"cache":false,"data":jQuery("#comments-form").serialize()}).done(function(){$.fn.yiiGridView.update("comments-grid")});
                $(this).dialog("close");}',
            'Save'=>'js:function(){
                jQuery.ajax({"id":"saveLink","type":"POST","url":$("#saveUrl").attr("value"),"cache":false,"data":jQuery("#comments-form").serialize()});
                $(this).dialog("close"); $.fn.yiiGridView.update("comments-grid");}',
            'Delete'=>'js:function(){
                jQuery.ajax({"id":"deleteUrl","type":"POST","url":$("#deleteUrl").attr("value"),"cache":false}).done(function(){$.fn.yiiGridView.update("comments-grid")});
                $(this).dialog("close");}',
            'Cancel'=>'js:function(){
                $(this).dialog("close"); $.fn.yiiGridView.update("comments-grid");}',
        ),
    ),
));

    echo '<div id="viewModalContent"></div>';
    
$this->endWidget('zii.widgets.jui.CJuiDialog');

?>