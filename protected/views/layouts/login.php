<!doctype html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<link rel="SHORTCUT ICON" href="http://static.migom.by/img/favicon.ico">
	<?php
	Yii::app()->getClientScript()->registerCssFile('/css/default.css');
	Yii::app()->clientScript->registerCoreScript('jquery');
	Yii::app()->clientScript->registerCoreScript('jquery.ui');
	$assetUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('core.widgets.assets'));
    Yii::app()->getClientScript()->registerCssFile($assetUrl.'/css/tooltipError.css');
    Yii::app()->clientScript->registerScriptFile($assetUrl.'/js/tooltipError.js');
    ?>
</head>
<body>
    <?= $content ?>
</body>
</html>