<?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'formReg',
            'action' => array('/site/registration'),
            'enableAjaxValidation'=>true,
            'enableClientValidation'=>false,
            'focus'=>array($model,'username'),
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
                'inputContainer' => 'div',
                'afterValidate' => 'js:function(form, data, hasError){ $(form).validateAttrs(data); return true; }',
                'afterValidateAttribute' => 'js:function(form, attribute, data, hasError){ $(form).validateAttrs(data); return true; }',
                'hideErrorMessage' => true,
            ),
)); ?>

        <div class="header"><?= Yii::t('Login', 'Регистрация в 1 клик'); ?></div>
		<label>
			<div class="hint"><?= Yii::t('Login', 'Больше ничего<br> не надо будет вводить'); ?></div>
			<span><?= Yii::t('Login', 'Укажите электронную почту'); ?></span>
            <?= $form->emailField($model,'email', array('placeholder' => Yii::t('Login', 'Например: ivanov@gmail.com'))); ?>
            <?= $form->error($model,'email'); ?>
		</label>
		<p><em><?= Yii::t('Login', 'У нас есть <a href="/rules">правила</a>, ознакомьтесь перед нажатием'); ?></em></p>
		<p><button>Создать профиль</button></p>

<?php $this->endWidget(); ?>