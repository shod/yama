<h1>View Adverts #<?php echo $model->id; ?></h1>

<?php if(count($images)): ?>
<div class="photos">
	<div class="big">
		<?= CHtml::image(Yii::app()->getBaseUrl(true) . Adverts::IMAGE_PATH . '/' . $model->id . '/'. $model->image, '', array('width' => '300px')) ?>
	</div>
	<div class="clear" style="clear:both"></div>
	<div class="small">
		<?php foreach($images as $image): ?>
			<div class="smallitem" style="float:left; margin:2px; border: 1px solid #ccc;">
				<?= CHtml::image(Yii::app()->getBaseUrl(true) . Adverts::IMAGE_PATH . '/' . $model->id . '/public/100_100_'. $image) ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>
<?php endif; ?>


<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'text',
	),
)); ?>
