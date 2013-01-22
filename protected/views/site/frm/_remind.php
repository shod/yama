<div class="popup password-recover">
    <div class="close">&times;</div>
    <h1><?= Yii::t('Login', 'Забыли пароль?'); ?></h1>
    <p><?= Yii::t('Login', 'Не расстраивайтесь. Мы вышлем вам новый пароль на указанную электронную почту в ближайшее время.'); ?></p>
    <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'formRemind',
                'action' => array('/site/RemindPass'),
                'enableAjaxValidation'=>true,
                'enableClientValidation'=>false,
                'focus'=>array($model,'email'),
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                    'inputContainer' => 'div',
                    'afterValidate' => 'js:function(form, data, hasError){ if(hasError){$(form).validateAttrs(data); return true;} else {$(form).remove(); $(".password-recover p").html(data["message"])} }',
                    'afterValidateAttribute' => 'js:function(form, attribute, data, hasError){ $(form).validateAttrs(data); return true; }',
                    'hideErrorMessage' => true,
                ),
    )); ?>
                <p>
                    <?= $form->emailField($model,'email', array('placeholder' => Yii::t('Login', 'Электронная почта'))); ?>
                    <?php echo $form->error($model,'email', array(), true, true); ?>
                </p>
                <div class="buttons">
                    <button name="remind"><?= Yii::t('Logo', 'Восстановить пароль'); ?></button>
                    <span class="cancel-link"><a href="#"><?= Yii::t('Logo', 'Отмена, закрыть окно'); ?></a></span>
                </div>
    <?php $this->endWidget(); ?>
</div>