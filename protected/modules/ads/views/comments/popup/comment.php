<div style="border: 2px solid; margin: 5px; padding: 5px;">
    <div>
        <b><?php echo $model->user->login; ?></b>
    </div>
    <?php echo $model->text; ?>
    <?php if($model->parent): ?>
        <?php $this->renderPartial('popup/comment', array('model' => $model->parent)); ?>
    <?php endif; ?>
</div>