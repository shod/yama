<p style="color:blue; font-size:16px;"><?= CHtml::link('LinkNew', Yii::app()->params['migomBaseUrl'].'/?news_id='.$model->entity_id); ?></p>
<?php if($model->parent): ?>
    <?php $this->renderPartial('popup/comment', array('model' => $model->parent)); ?>
<?php endif; ?>

<div class="form">
    
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comments-form',
	'enableAjaxValidation'=>false,
)); ?>
        <?php echo CHtml::hiddenField('approoveUrl', $this->createUrl('approove', array('model' => $modelTitle, 'id' => $model->id)), array('id' => 'approoveUrl')); ?>
        <?php echo CHtml::hiddenField('deleteUrl', $this->createUrl('delete', array('model' => $modelTitle, 'id' => $model->id)), array('id' => 'deleteUrl')); ?>
        <?php echo CHtml::hiddenField('saveUrl', $this->createUrl('save', array('model' => $modelTitle, 'id' => $model->id)), array('id' => 'saveUrl')); ?>
        <div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php echo $form->textArea($model,'text',array('maxlength' => 255, 'rows' => 6, 'cols' => 66)); ?>
		<?php echo $form->error($model,'text'); ?>
	</div>
    
<?php $this->endWidget(); ?>

</div>