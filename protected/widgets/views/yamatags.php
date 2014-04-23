<?php if($tags): ?>
	<?php if(!Yii::app()->request->isAjaxRequest): ?>
	<ul class="b-market__tags-line">
	<?php endif; ?>
	<?php foreach($tags as $tag): ?>
		<li><?= $tag->name ?></li>
	<?php endforeach;?>
	<?php if(count($tags) == 14): ?>
		<li class="last"><a href="#">Еще уточнения</a></li>
	<?php endif; ?>
	<?php if(!Yii::app()->request->isAjaxRequest): ?>
	</ul>
	<?php endif; ?>
<?php endif; ?>