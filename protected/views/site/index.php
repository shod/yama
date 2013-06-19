<div class="body">
	<?php 
		//Yii::app()->clientScript->registerScriptFile('/js/jquery.lazyload.js'); 
	?>
	



    <!--Market-->
    
    <script type="text/javascript">
        $(document).ready(function(){
			
		
            if($('.videoteaser').length){
                $('.videoteaser .close-btn').click(function(e){
                    e.preventDefault();
                    $(this).parent().remove();
                    $('.b-main-page__col-1 .b-main-page__banner-1').addClass('m-t')
                });
            }

            if($('.tags-list').length){
                $('.tags-list li a').click(function(e){
                    e.preventDefault();
                    if($(this).parent('li').hasClass('active')){
                        return false;
                    }else{
                        $('.tags-list li.active').removeClass('active');
                        $(this).parents('li').addClass('active');
                    }
                });
            }
			
           $(window).load(function(){
			//alert('init');
                $('.b-market__middle-i').masonry({
                    itemSelector: '.b-market__item-preview'
                })
            });
			
			
        });
    </script>
    <div class="b-market">
        <?php Widget::create('YamaTop', 'yamatop', array('query' => $query, 'region' => $region, 'category' => $category))->html() ?>
		<!--
        <aside class="b-market__banner-1">
            <a href="#">Купить баннер в разделе «Электроника» с 11 по 17 марта</a>
        </aside>
		-->
        <div class="b-market__middle">
            <div class="b-market__middle-i">
				<?php	$this->renderPartial('list', array('model' => $model, 'users' => $users, 'else' => $else, 'aViews' => $aViews)); ?>
            </div>
			<a href="javascript:void(0)" class="more-items-btn" offset-value="<?= $offset ?>" <?php if(!$else): ?>style="display:none;"<?php endif; ?>><span>Ещё объявления</span></a>
        </div>
        <div class="b-market__bottom" <?php if(!Yii::app()->request->getParam('q')): ?>style="display:none;"<?php endif; ?>>
            <figure class="b-market__bottom-logo">
                <a href="<?= Yii::app()->getBaseUrl(true) ?>">
					<?= CHtml::image('/images/market_logo_2.png', 'migom.by', array('width' => 77, 'height' => 34)) ?>
                </a>    
            </figure>
            <div class="b-market__bottom-sub">
				<label for="" class="success" style="display:none;"><?= Yii::t('Yama', 'Вы получите уведомления о всех новый объявлениях в разделе'); ?> "<span></span>"</label>
                <form action="" method="" class="">
                    <label>Подписаться на фильтр "<span><?= Yii::app()->request->getParam('q') ?></span>"</label>
					<div class="sub">
					<?php if(Yii::app()->user->isGuest): ?>
						<?= Widget::create('EAuthWidget', 'eauth', array('action' => Yii::app()->params['socialBaseUrl'].'/login', 'mini' => true), true) ?>
					<?php else: ?>
						<button class="button_yellow btn-submit-1" onclick="subscribe(); return false;" type="submit">Подписаться</button>
					<?php endif; ?>
					</div>
                    <!--<input class="sub" type="text" name="" placeholder="example@gmail.com" />
                    <button class="button_yellow btn-submit-1" type="submit">Подписаться</button>-->
                </form>   
            </div>   
        </div>
        
    </div>         
</div>

<?php
			$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id' => 'itemWindow',
                    'options' => array(
						'dialogClass' => 'b-market__item',
                        'autoOpen' => false,
						'modal' => true,
						'width' => '715px',
						'resizable' => false,
						'closeOnEscape' => false,
						'position' => array('my' => 'top', 'at' => 'top', 'of' => 'header.orange'),
						//'beforeClose'=>'js:function(){YamaBy.index.closeModal("advert", "itemWindow")}',
                    ),
                ));
                ?>
	<div class="content"></div>

<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php WComments::registerWidgetScripts(); ?>

<?php 

	$js = '';
	if(Yii::app()->user->isGuest){
		$js = "jQuery('#itemWindow').on('click', '.auction', function(){
			window.location = '" . Yii::app()->params['socialBaseUrl'] . '/login' . "'
		})";
	} else {
		$js = "jQuery('#itemWindow').on('click', '.auction', function(){
			if(!$('.b-market__item-form-i .auction-price').attr('value')){
				return false;
			}
			$.post('" . Yii::app()->getBaseUrl(true) . '/ahimsa/auction' . "', 
						{
							price: $('.b-market__item-form-i .auction-price').attr('value'), 
							id: $('.b-market__item-form-i .auction-ahimsa').attr('value')
						}, function(data){
							res = $.parseJSON(data)
							if(res.success == true){
								$('.offer-list').css({ opacity: 1 });
								$('.offer-list').html(res.content)
								$('.b-market__item-form-i').html('<p>" . Yii::t('Yama', 'Ваша ставка принята') . "</p>')
							}
						}
				)
			return false;
		}) ";
	}

	Yii::app()->clientScript->registerScript('auction', $js, CClientScript::POS_END);
?>
<script>

	var pageLimit = <?= Adverts::LIMIT ?>;
	
	subscribe = function(){
		$.post('<?= Yii::app()->getBaseUrl(true) . '/site/subscribe/text/' ?>' + $('.seachline-input').val())
		$(".b-market__bottom-sub form").hide()
		$(".b-market__bottom-sub label.success span").html($('.seachline-input').val())
		$(".b-market__bottom-sub label.success").show()
	}
	
	jQuery('#itemWindow').on('click', '.b-market__item-i .changeStatus', function(){
		if($(this).hasClass('unactivate')){
			$(this).removeClass('unactivate')
			$(this).addClass('activate')
			$('.b-market__item-i .tag-1').hide()
			$.post('<?= Yii::app()->getBaseUrl(true) . '/ahimsa/changeStatus/id/' ?>' + $('#itemWindow .b-market__item').attr('id'), {status: 1})
		} else {
			$(this).addClass('unactivate')
			$(this).removeClass('activate')
			$('.b-market__item-i .tag-1').show()
			$.post('<?= Yii::app()->getBaseUrl(true) . '/ahimsa/changeStatus/id/' ?>' + $('#itemWindow .b-market__item').attr('id'), {status: 2})
		}
	})
	
	jQuery('#itemWindow').on('click', '.info-1 .up', function(){
		if($(this).hasClass('unactive')){
			return false;
		}
		$.post('<?= Yii::app()->getBaseUrl(true) . '/ahimsa/up/id/' ?>' + $('#itemWindow .b-market__item').attr('id'))
		$(this).addClass('unactive')
	})
	
	jQuery('#itemWindow').on('click', '.bookmark-link', function(){
		if($(this).hasClass('active')){
			return false;
		}
		$.post('<?= Yii::app()->getBaseUrl(true) . '/ahimsa/marks/id/' ?>' + $('.b-market__item').attr('id'))
		$(this).addClass('active')
	})
	
	jQuery('#itemWindow').on('click', '.close', function(){
			$('#itemWindow').dialog('close')
			YamaBy.index.closeModal("advert", "itemWindow")
			return false; 
	})
	
	jQuery(document).on('click', '.ui-widget-overlay', function(){
			$('#itemWindow').dialog('close')
			YamaBy.index.closeModal("advert", "itemWindow")
			return false; 
	});
	
	jQuery('.btn-search').on('click', function(){
			YamaBy.index.search('<?= Yii::app()->getBaseUrl(true) ?>', $('#searchYama').val())
			
			$('.seachline-input').val($('#searchYama').val())
			
			$('.more-items-btn').attr('offset-value', pageLimit)
			if($('#searchYama').val()){
				$(".b-market__bottom").show()
				$(".b-market__bottom-sub form").show()
				$(".b-market__bottom-sub label.success").hide()
				$(".b-market__bottom-sub form label span").html($('#searchYama').val())
			} else {
				$(".b-market__bottom-sub form").hide()
				$(".b-market__bottom").hide()
			}
			
			return false;
	})

	jQuery('.seachline-input, #searchYama').on('change', function(){
			YamaBy.index.search('<?= Yii::app()->getBaseUrl(true) ?>', this.value)
			
			$('.seachline-input').val(this.value)
			$('#searchYama').val(this.value)
			
			$('.more-items-btn').attr('offset-value', pageLimit)
			if(this.value){
				$(".b-market__bottom").show()
				$(".b-market__bottom-sub form").show()
				$(".b-market__bottom-sub label.success").hide()
				$(".b-market__bottom-sub form label span").html(this.value)
			} else {
				$(".b-market__bottom-sub form").hide()
				$(".b-market__bottom").hide()
			}
			
			return false;
	})
	jQuery('.more-items-btn').on('click', function(){
		YamaBy.index.moreItems('<?= Yii::app()->getBaseUrl(true) ?>', $('.seachline-input').val(), $(this).attr('offset-value'))
		$(this).attr('offset-value', parseFloat($(this).attr('offset-value')) + pageLimit)
		return true;
	})

</script>