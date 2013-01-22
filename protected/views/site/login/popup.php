<div class="auth form">
    <div class="panel signin">
    <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'formLogin',
                'enableAjaxValidation'=>true,
                'enableClientValidation'=>false,
    //            'focus'=>array($model,'email'),
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                    'inputContainer' => 'div',
                    'afterValidate' => 'js:function(form, data, hasError){ $(form).validateAttrs(data); return true; }',
                    'afterValidateAttribute' => 'js:function(form, attribute, data, hasError){ $(form).validateAttrs(data); return true; }',
                    'hideErrorMessage' => true,
                ),
    )); ?>
                <label>
                    <div><?= Yii::t('Login', 'Вход на сайт'); ?></div>
                    <?= $form->emailField($model,'email', array('placeholder' => Yii::t('Login', 'Электронная почта'))); ?>
                    <?php echo $form->error($model,'email', array(), true, true); ?>
                </label>
                <p>
                    <?= $form->passwordField($model,'password', array('placeholder' => Yii::t('Login', 'Пароль'))); ?>
                    <?= $form->error($model,'password'); ?>
                </p>
                <p class="buttons">
                    <button id="login"><?= Yii::t('Login', 'Войти'); ?></button>
                </p>

    <?php $this->endWidget(); ?>
     </div>
</div>