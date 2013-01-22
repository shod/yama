<!doctype html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <META http-equiv="Content-Language" CONTENT="RU">
	<link rel="SHORTCUT ICON" href="http://static.migom.by/img/favicon.ico">
    <meta http-equiv="Pragma" content="no-cache" />

    <title>Добро пожаловать</title>
    <link rel="stylesheet" type="text/css" href="css/default.css">
    <link rel="SHORTCUT ICON" href="/favicon.ico">

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.form.js"></script>
    <script type="text/javascript" src="js/jquery.validate.js"></script>

    <link rel="stylesheet" type="text/css" media="all" href="css/chosen.css" />
    <script type="text/javascript" src="js/chosen.jquery.min.js"></script>

</head>

<body>
<div class="darker png_scale" style="display: none;"></div>

<div class="main">
    <div class="header">
        <? $this->block('top') ?>
    </div>

    <div class="outer">

        <div class="container">
            <div class="content">
                <div class="intend">
                    <?= $content ?>
                </div>
            </div><!--/content-->
        </div><!--/container-->

        <div class="sidebar">
            <? $this->block('left') ?>
        </div><!--/sidebar-->

    </div><!--/outer-->

</div>

<div class="footer">
    <div class="copy">&copy; 2006&mdash;<?= date('Y') ?> Migom.by&nbsp;<strong>Минск</strong>, <strong>Беларусь</strong>&nbsp;&nbsp;</div>
</div>
</body>
</html>