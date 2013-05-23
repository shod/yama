<?php if(!$this->update ): ?>
<ul class="offer-list" <?php if(!count($auction)): ?>style="opacity:0;"<?php endif; ?>>
<?php endif; ?>
	<?php foreach($auction as $auc): ?>
	<li>
		<a href="<?= Yii::app()->params['socialBaseUrl'] . '/user/' . $auc->user_id ?>">
			<?= $users[$auc->user_id]->name ?>
		</a> <?= Yii::t('Yama', 'купит за'); ?> <b><?= $auc->price ?></b> <?= $currency; ?>
	</li>
	<?php endforeach; ?>
<?php if(!$this->update ): ?>
</ul>
<?php endif; ?>