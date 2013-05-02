<article class="b-market__item-preview <?php if($data->premium): ?>outline<?php endif; ?>">
	<a href="<?= Yii::app()->getBaseUrl(true). $this->createUrl('/ahimsa/view', array('id' => $data->id)) ?>" class="item_to">
		<?php if($data->image): ?>
		<figure>
			<?= CHtml::image(Yii::app()->getBaseUrl(true) . '/images/ahimsa/' . $data->id . '/index/' .$data->image, $data->description); ?>
		</figure>
		<?php endif; ?>

		<p class="txt"><?= $data->description ?></p>
		<div class="info cfix">
			<span class="price">
				<?php if($data->price): ?>
					<b><?= $data->price ?></b> <?= Adverts::$currencySymbol[$data->currency]; ?>
				<?php else: ?>
					<?= Yii::t('Yama', 'Отдаю даром'); ?>
				<?php endif; ?>
			</span>
			<!--<span class="up">1 <b>UP</b></span>-->
			<!--<span class="comments">214<i class="icon"></i></span>-->
			<i class="icon arr"></i>
		</div>
		<div class="author">
			<figure>
				<?= UserService::printAvatar($data->user_id, $users[$data->user_id]->name, 30, true); ?>
			</figure>
			<strong><?= $users[$data->user_id]->name ?></strong>
			<small><?= SiteService::getStrDate($data->created_at); ?><!--добавил 1 минуту назад--></small>
		</div>
	</a>      
</article>