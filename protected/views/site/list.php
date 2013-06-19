<?php if(!count($model)): ?>
		<div class="nothing">По запросу "<?= Yii::app()->request->getParam('q') ?>" ничего не найдено</div>
<?php 
	endif;

	foreach($model as $m){
		$this->renderPartial('_item', array('data' => $m, 'users' => $users, 'aViews' => $aViews));
	}
?>
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