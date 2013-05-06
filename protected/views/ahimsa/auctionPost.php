<?php foreach($auctions as $auction): ?>
<li><a href="<?= Yii::app()->params['socialBaseUrl'] . '/user/' . $auction->user_id ?>"><?= $users[$auction->user_id]->name ?></a> <?= Yii::t('Yama', 'купит за') ?> <b><?= $auction->price ?></b> $</li>
<?php endforeach; ?>