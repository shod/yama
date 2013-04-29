<div class="b-market__top">
	<dl class="b-market__top-reg">
		<!--<dt>Регион:</dt>
		<dd>
			<a href="#">вся Беларусь</a>
		</dd>-->
	</dl>
	<figure class="b-market__top-logo">
		<a href="<?= Yii::app()->getBaseUrl(true) ?>"><?= CHtml::image('/images/market_logo_1.png', 'yama.migom.by', array('width' => 95, 'height' => 40)) ?></a>
	</figure>
	<dl class="b-market__top-par">
		<!--<dt>
			<a href="#">Все разделы<i class="icon"></i></a>
		</dt>
		<dd>Электроника<small>23401 товар</small><i class="icon arr"></i></dd>-->
	</dl>
	<div class="b-market__top-search">
		<form action="" method="" id="">
			<?= CHtml::textField('searchYama', $query, array('size' => '100', 'class' => 'search', 'placeholder' => Yii::t('Yama', 'Искать'))) ?>
			<button class="btn-search" type="submit" title="Поиск" onclick="return false;" onsubmit="return false;"><span>Поиск</span></button>  
		</form>
	</div>
	<?= CHtml::link(Yii::t('Yama', 'Создать объявление') . '<i class="icon"></i>', array('/ahimsa/create'), array('class' => 'add-item-btn')); ?>
	<!--<?php if(!Yii::app()->user->isGuest): ?>
		<?= CHtml::link(Yii::t('Yama', 'Мои объявления'), array('/site/index', 'user' => Yii::app()->user->id), array('style' => 'float:right;')); ?>
	<?php endif; ?>-->
	<!-- <a href="#" class="add-link"></a> -->
</div>