<!DOCTYPE html>
<!--[if IE 7 ]><html lang="ru" class="ie7"><![endif]-->
<!--[if IE 8 ]><html lang="ru" class="ie8"><![endif]-->
<!--[if IE 9 ]><html lang="ru" class="ie9"><![endif]-->
<!-- saved from url=(0020)http://www.migom.by/ -->
<html lang="ru" class=" js no-flexbox flexbox-legacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths"><!--<![endif]-->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!--<script type="text/javascript" async="" src="./for_delete/ef4a000df4772abf9d2e3b05819fdcdcdc45ca3a.1.js"></script>
	<script type="text/javascript" async="" src="./for_delete/i.js"></script>
	<link rel="stylesheet" type="text/css" href="./for_delete/main.css">
	<link rel="stylesheet" type="text/css" href="./for_delete/default.css">
	<script type="text/javascript" src="./for_delete/jquery.min.js"></script>
	<script type="text/javascript" src="./for_delete/main.js"></script>
	<script type="text/javascript" src="./for_delete/default.js"></script>
	<script type="text/javascript" src="./for_delete/modernizr.js"></script>
	<script type="text/javascript" src="./for_delete/html5fix.js"></script>-->
	<title> <?= $this->title ?> </title>
	<meta name="keywords" content="<?= $this->description ?>">
	<meta name="description" content="<?= $this->description ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta http-equiv="Cache-Control" content="max-age=3600, must-revalidate">
	<meta http-equiv="Cache-Control" content="no-store">
	<meta name="robots" content="INDEX,FOLLOW">
	<meta http-equiv="Last-Modified" content="Sun, 31 Mar 2013 05:32:00 GMT">
	<meta http-equiv="Expires" content="Sun, 31 Mar 2013 12:32:00 GMT">

	<meta name="yandex-verification" content="7b0ac52ad0d655c6"> 	
	<meta name="yandex-verification" content="510cd02ecc10f67c">
	<meta name="yandex-verification" content="4fd8abe117e04d03">

	<meta name="verify-v1" content="VCc17jQosV3rw+MEGRBcJTP33LDUw8KU6tkKaKlHkNc=">
	<meta name="verify-v1" content="1sqDKd0AanSP6K4mX+8TLRaaaYXbAtSo2yiLXpQIPgc=">

	
	<meta http-equiv="Content-Language" content="ru">
	
	<base href="<?= Yii::app()->getBaseUrl(true) ?>">
	
	<link title="MIGOM.by - Новости" type="application/rss+xml" rel="alternate" href="http://www.migom.by/rss/news/">
	<link title="MIGOM.by - Обзоры" type="application/rss+xml" rel="alternate" href="http://www.migom.by/rss/articles/">
	<!--[if lt IE 8]<link rel="stylesheet" media="all" type="text/css" href="http://www.migom.by/css/default.ie.css" />[endif]-->

    <link rel="shortcut icon" href="http://static.migom.by/img/favicon.ico">
    <link rel="apple-touch-icon" href="http://www.migom.by/apple-touch-icon.png">
    <!--link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png"-->
    <!--link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png"-->
	<!-- pr-cy f069a9243ce2060b2e1b5742726cd3f8 -->
	<!-- <script src="./for_delete/urchin.js" type="text/javascript"></script>-->
	<!--<script src="./for_delete/acode.js" type="text/javascript" async=""></script>-->
	
	
	<?php
        Yii::app()->getClientScript()->registerCssFile('/css/yama.css');
		Yii::app()->getClientScript()->registerCssFile('/css/fotorama.css');
        Yii::app()->clientScript->registerScriptFile('/js/form.js');
		Yii::app()->clientScript->registerScriptFile('/js/yama.js');
		Yii::app()->clientScript->registerScriptFile('/js/history.js/scripts/bundled/html4+html5/jquery.history.js');
        Yii::app()->clientScript->registerCoreScript('jquery');
        Yii::app()->clientScript->registerCoreScript('jquery.ui');
		Yii::app()->getClientScript()->registerCssFile('/css/market_page.css');
		Yii::app()->clientScript->registerScriptFile('/js/jquery.masonry.min.js');
		Yii::app()->clientScript->registerScriptFile('/js/fotorama.js');
    ?>
	<link href='http://fonts.googleapis.com/css?family=Cuprum&subset=latin,latin-ext,cyrillic' rel='stylesheet' type='text/css'>
</head>
<body cz-shortcut-listen="true" class="market-page">
    <div class="boby-container">

<!--<div class="wrapper_banner"><div class="ad ad01" style="margin-top:5px;">
<noindex>
<div id="beacon_579f25681c" style="position: absolute; left: 0px; top: 0px; visibility: hidden;"><img src="./for_delete/lg.php" width="0" height="0" alt="" style="width: 0px; height: 0px;"></div>
							
</noindex>	
</div></div>-->

<?php CController::widget('Header'); ?>

<div class="wrapper_content">

    <?php CController::widget('HeaderNavigation'); ?>
	<?php //Widget::get('Breadcrumbs')->html(); ?>
    <?= $content ?>
</div>

<?php CController::widget('Footer'); ?>
    </div>
	<script>
		YamaBy.index.init({
			modals: {
				item: {
					selector: '.b-market__item-preview .item_to',
					id: 'itemWindow'
				}
			},
			searchField: '#searchYama',
			contentBlockSelector: '.b-market__middle-i',
		});
	</script>
</body>
</html>