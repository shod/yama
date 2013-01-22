<?php $this->beginContent('/layouts/main'); ?>
<div class="container">
	<div class="<?= ($this->menu)?'span-19':'span-24'; ?>">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
        <?php if($this->menu): ?>
            <div class="span-5 last">
                    <div id="sidebar">
                    <?php
                            $this->beginWidget('zii.widgets.CPortlet', array(
                                    'title'=>'Доступные действия',
                            ));
                            $this->widget('zii.widgets.CMenu', array(
                                    'items'=>$this->menu,
                                    'htmlOptions'=>array('class'=>'operations'),
                            ));
                            $this->endWidget();
                    ?>
                    </div> 
            </div>
        <?php endif; ?>
</div>
<?php $this->endContent(); ?>