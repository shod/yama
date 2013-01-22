<?php
/* @var $this PagesController */
/* @var $model Pages */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pages-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		
		<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50, 'class' => 'redactor_text')); ?>
		<?php 
		$this->widget('ImperaviRedactorWidget', array(
			// селектор для textarea
			'selector' => '.redactor_text',
			// немного опций, см. http://imperavi.com/redactor/docs/
			'options' => array(
						'lang' => 'ru',
						'buttons'=>array(
                            'formatting', '|', 'bold', 'italic', 'deleted', '|',
                            'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
                            'image', 'video', 'link', '|', 'html',
                        ),
					),
		));

		
		?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'meta_descriptions'); ?>
		<?php echo $form->textArea($model,'meta_descriptions',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'meta_descriptions'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'meta_keywords'); ?>
		<?php echo $form->textField($model,'meta_keywords',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'meta_keywords'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->