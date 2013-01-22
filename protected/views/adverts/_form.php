<?php
/* @var $this AdvertsController */
/* @var $model Adverts */
/* @var $form CActiveForm */
?>
<div class="summary"></div>
<div class="avatar">
                <?php 
               
    $this->widget('core.extensions.EAjaxUpload.EAjaxUpload', array(
        'id' => 'uploadFile',
        'config' => array(
            'action' => Yii::app()->createUrl('adverts/uploadImage'),
            'allowedExtensions' => array("jpg", "png", "gif", "jpeg"), //array("jpg","jpeg","gif","exe","mov" and etc...
            'sizeLimit' => 1 * 1024 * 1024, // maximum file size in bytes
            'minSizeLimit' => 1, // minimum file size in bytes
            'onComplete' => "js:function(id, fileName, responseJSON){ $('.uploadFile img').attr('src', \"".Yii::app()->params['tagsBaseUrl'].Adverts::IMAGE_TEMP_PATH."/0/\"+fileName); $('.uploadFile').clone().appendTo('.summary').removeClass('uploadFile').show() }",
            'messages' => array(
                'typeError' => "{file} has invalid extension. Only {extensions} are allowed.",
                'sizeError' => "{file} is too large, maximum file size is {sizeLimit}.",
                'minSizeError' => "{file} is too small, minimum file size is {minSizeLimit}.",
                'emptyError' => "{file} is empty, please select files again without it.",
                'onLeave' => "The files are being uploaded, if you leave now the upload will be cancelled."
            ),
            'showMessage' => "js:function(message){ alert(message); }"
        )
    ));
    ?>
</div>
<div class="avatar">аватар</div>
<div class="form">
	<div class="b-news-comments__reply-form">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'adverts-form',
			'enableAjaxValidation'=>false,
		)); ?>

			<?php echo $form->errorSummary($model); ?>

			

			<figure class="author-img">
				<a href="<?= Yii::app()->params->socialBaseUrl  ?>/user"><img src="<?= Yii::app()->params->socialBaseUrl  ?>/images/users/<?= 0//Yii::app()->user->id ?>/avatar_50x50.jpg" width="50" height="50" alt="<?= Yii::app()->user->name ?>" /></a>
			</figure>
			<p class="author"><a href="<?= Yii::app()->params->socialBaseUrl  ?>/user"><?= Yii::app()->user->name ?></a>, ваш комментарий:</p>
			<div class="b-news-comments__reply-form-editor">
				<?php echo $form->textArea($model,'text', array('class'=>"txt-editor", 'maxlength'=>'560', 'id'=>"author-message-1", 'cols' => 30, 'rows' => 5)); ?>
				<small class="info">Некорректные объявления не публикуются.</small>
				<div class="row">
					<?php echo $form->labelEx($model,'title'); ?>
					<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>200)); ?>
				</div>
				<button class="button_yellow btn-submit-1" type="submit">Опубликовать</button>
			</div>
			<br/>
		<?php $this->endWidget(); ?>

	</div>
</div><!-- form -->

<div class="uploadFile" style="display:none; float:left;">
	<?= CHtml::image('') ?>
</div>





		

	

