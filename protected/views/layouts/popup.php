<!doctype html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<link rel="SHORTCUT ICON" href="http://static.migom.by/img/favicon.ico">
	<?php
    Yii::app()->getClientScript()->registerCssFile('/css/default.css');
    Yii::app()->clientScript->registerScriptFile('/js/form.js');
    Yii::app()->clientScript->registerCoreScript('jquery');
	Yii::app()->clientScript->registerCoreScript('jquery.ui');
    ?>
</head>
<body>

    <?= $content ?>

</body>
</html>