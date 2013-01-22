<div class="auth-question">
	<div class="logo"></div>
    <?php
        $attrs = $identity->getAttributes();
        $login = '';
        if(isset($attrs['name'])){
            $login = $attrs['name'];
        }
        if(isset($attrs['surname'])){
            $login .= ' ' . $attrs['surname'];
        }
        if(!$login && isset($attrs['login'])){
            $login = $attrs['login'];
        }
    ?>
	<p><?= Yii::t('Login', 'Вы сможете входить на сайт migom.by без ввода пароля через свой аккаунт <strong class="{class}">{name}</strong>', array('{class}' => $service, '{name}' => $login)); ?></p>
    <button onclick="window.location = '<?= $this->createUrl('site/login', array('reg_ask' => 1, 'service' => $service, 'user' => 'new')); ?>'"><?= Yii::t('Login', 'Я новый пользователь') ?></button>
	<button onclick="window.location = '<?= $this->createUrl('site/login', array('reg_ask' => 1, 'service' => $service, 'user' => 'haveALogin')); ?>'"><?= Yii::t('Login', 'У меня уже есть аккаунт') ?></button>
</div>
