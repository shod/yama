<div class="related">
	<?= Yii::t('UserNews', 'title:'.$model->name); ?> <a href="<?= $model->link ?><?= $model->entity_id ?>"><?= ($model->title)? $model->title : Yii::t('Site', 'Новость') ; ?></a><div id="<?= $model->name . '_' . $model->id ?>_delete" class="close ajaxNewDelete">
            </div></div>
<div class="message">
		Вы уверены, что хотите удалить эту запись? Эта запись не будет показываться в ленте. 
		<?= CHtml::link(Yii::t('Social', 'Отмена'), CController::createUrl('/ajax/undeletenew', array('entity' => $model->name . '_' . $model->id )), array('class' => 'ajaxUndeleted')) ?>
</div>