<div class="b-market__top">
	<?php Yii::app()->clientScript->registerScriptFile('/js/bootstrap.min.js'); ?>
	<?php Yii::app()->getClientScript()->registerCssFile('/css/bootstrap.min.css'); ?>
	
	<dl class="b-market__top-reg">
		<dt><?= Yii::t('Yama', 'Регион'); ?>:</dt>
		<dd>
			<!--<a href="#">вся Беларусь</a>-->
			    <div class="dropdown">
					<a class="dropdown-toggle" param="region" data-toggle="dropdown" href="#"><?= Yii::app()->request->getParam('region', $this->regionTitle, 'string') ?></a>
					<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
					<?php foreach($regions as $region):?>
						<li><?= $region['title'] ?></li>
					<?php endforeach; ?>
					</ul>
				</div>
				<script>
					$('.dropdown-toggle').dropdown()
				</script>
		</dd>
	</dl>
	<figure class="b-market__top-logo">
		<a href="<?= Yii::app()->getBaseUrl(true) ?>"><?= CHtml::image('/images/market_logo_1.png', 'yama.migom.by', array('width' => 95, 'height' => 40)) ?></a>
	</figure>
	<dl class="b-market__top-par">
		<dt>
			<span><i class="icon"></i></span>
		</dt>
		<dd>
			<!--<a href="" >Электроника</a><small>23401 товар</small><i class="icon arr"></i>-->
			<div class="dropdown">
				<a class="dropdown-toggle-cat" param="category" data-toggle="dropdown" href="#"><?= Yii::app()->request->getParam('category', $this->categoryTitle, 'string') ?></a>
				<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
				<?php foreach($categories as $cat):?>
					<li><?= $cat['title'] ?></li>
				<?php endforeach; ?>
				</ul>
			</div>
			<script>
				$('.dropdown-toggle-cat').dropdown()
			</script>
		</dd>
	</dl>
	<div class="right">
		<div class="b-market__top-search">
			<form action="" method="" id="">
				<?= CHtml::textField('searchYama', $query, array('size' => '100', 'id' => 'searchYama', 'class' => 'search ', 'placeholder' => Yii::t('Yama', 'Искать'))) ?>
				<input class="seachline-dis searchYama-dis" value="" dir="ltr">
				<button class="btn-search" type="submit" title="Поиск" onclick="return false;" onsubmit="return false;"><span>Поиск</span></button>  
			</form>
		</div>
		<?= CHtml::link(Yii::t('Yama', 'Создать объявление') . '<i class="icon"></i>', array('/ahimsa/create'), array('class' => 'add-item-btn')); ?>
		<!--<?php if(!Yii::app()->user->isGuest): ?>
			<?= CHtml::link(Yii::t('Yama', 'Мои объявления'), array('/site/index', 'user' => Yii::app()->user->id), array('style' => 'float:right;')); ?>
		<?php endif; ?>-->
		<!-- <a href="#" class="add-link"></a> -->
	</div>
</div>