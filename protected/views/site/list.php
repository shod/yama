<?php if(!Yii::app()->request->getParam('offset', 0, 'int') || Yii::app()->request->getParam('m', 0, 'int')): //ON REPLACE ?>
	<?php if(!count($model)): ?>
			<div class="nothing">По запросу "<?= Yii::app()->request->getParam('q') ?>" ничего не найдено</div>
	<?php endif; ?>
	<?php
		$top = array();
		$models = array();
		foreach($model as $m){
			if($m->top){
				$top[] = $m;
			} else {
				$models[] = $m;
			}
		}
	?>
	<?php if(Yii::app()->request->getParam('q')): ?>
		<div class="b-market__middle-i">
		<?php
			$this->renderPartial('_iterate', array('data' => $top, 'users' => $users, 'aViews' => $aViews));
		?>
		</div>
	<?php endif; ?>
	<div class="b-market__middle-i">
	<?php
		if(count($models)){
			$this->renderPartial('_iterate', array('data' => $models, 'users' => $users, 'aViews' => $aViews));
		}
	?>
	</div>
<?php else: //ON UPPEND ?>
	<?php $this->renderPartial('_iterate', array('data' => $model, 'users' => $users, 'aViews' => $aViews)); ?>
<?php endif; ?>
<script>
	$('.b-market__middle-i').masonry()
	$("img.lazyload")
		 .lazyload({
			 event: "lazyload",
			 effect: "fadeIn",
			 effectspeed: 2000
		   })
		 .trigger("lazyload")
</script>