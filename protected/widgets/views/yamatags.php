<?php if(!Yii::app()->request->isAjaxRequest): ?>
<ul class="b-market__tags-line">
<?php endif; ?>
<?php foreach($tags as $tag): ?>
	<li><?= $tag->name ?></li>
<?php endforeach;?>
	<!--<li class="last"><a href="#">Еще 120 уточнений</a></li>-->
<?php if(!Yii::app()->request->isAjaxRequest): ?>
</ul>
<?php endif; ?>