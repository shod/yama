<div class="b-market__item <?php if($popup): ?>pop-up active<?php endif; ?>" id="<?= $model->id ?>">
	<?php if(!$popup): ?>
		<?php Widget::create('YamaTop', 'yamatop', array('category_id' => $model->category, 'region_id' => $model->region))->html(); ?>
		<?php 
			Yii::app()->clientScript->registerScript('yamatop', "
				jQuery('#searchYama').on('change', function(){
						window.location = ('" . Yii::app()->getBaseUrl(true) . "/?q=" . "' + this.value)
						return true;
				})
			");
		?>
	<?php endif; ?>
	<div class="b-market__item-i">
        <div class="b-market__item-top cfix">
            <div class="b-market__item-top-i">
                <figure>
					<?= UserService::printAvatar($users[$model->user_id]->id, $users[$model->user_id]->name, 50, true, true); ?>
                </figure>
                <!--<a href="#" class="bookmark-link" title="Добавить в закладки"></a>-->
            </div>
			<?php if($model->user_id == Yii::app()->user->id): ?>
            <ul class="add-links">
                <li>
					
					<a href="javascript:void(0)" class="changeStatus <?php if($model->status == 1): ?>activate<?php elseif($model->status == 2): ?>unactivate<?php endif;?>">[ 
						<span class="unactive"><?= Yii::t('Yama', 'не актуально'); ?></span>
						<span class="active"><?= Yii::t('Yama', 'сделать активным'); ?></span>
					 ]</a>
                </li>
                <li>
                    <a href="<?= Yii::app()->getBaseUrl(true) . '/ahimsa/update/' . $model->id ?>">[&nbsp;<?= Yii::t('Yama', 'редактировать'); ?>&nbsp;]</a>
                </li>
            </ul>
			<?php endif; ?>
            <p class="info-1">
				<?php if($model->name){
						$name = $model->name;
					} else {
						$name = $users[$model->user_id]->name;
					}
					?>
                <strong><?= $name ?></strong>
                <small>№<?= $model->id ?> <?= Yii::t('Yama', 'размещено') ?> <?= SiteService::getStrDate($model->created_at); ?></small>
                <?php if($model->user_id == Yii::app()->user->id && $model->status == 1): ?>
				<a href="javascript:void(0)" title="Объявление поднимется в выдаче, будет среди новых" class="up<?php if($model->last_up > time() - (3600 * 24)): ?> unactive<?php endif; ?>">[&nbsp;<?= Yii::t('Yama', 'поднять'); ?>&nbsp;]</a>
				<?php endif; ?>
            </p>
            <h1 class="info-2"><?= $model->description ?> [<?= Regions::model()->findByPk($model->region)->title ?>]</h1>
				<b class="tag-1" style="<?php if($model->status == 1): ?>display:none;<?php endif; ?>"><?= Yii::t('Yama', 'НЕАКТУАЛЬНО'); ?></b>
			<i class="shd"></i>
        </div>
		<?php if($model->image): ?>
        <div class="b-market__item-img">
			
        </div>
		<?php endif; ?>
        <p class="b-market__item-txt-1"><?= $model->text; ?></p>
        <!--<ul class="b-market__tags-line">
            <li>мобильный</li>
            <li>телефон</li>
            <li>apple</li>
            <li>16 Gb</li>
        </ul>-->
        <div class="b-market__item-form">
			<?php if($model->price): ?>
            
                <span class="price"><b><?= $model->price ?></b> <?= Adverts::$currencySymbol[$model->currency]; ?></span>
                <?php //if($auctFlag && Yii::app()->user->id != $model->user_id): ?>
				<div class="b-market__item-form-i">
                    <div class="input-wrap">
                        <span><?= Yii::t('Yama', 'Куплю дешевле за') ?></span>
                        <input class="auction-price" type="text" name="price" placeholder="">
						<input class="auction-ahimsa" type="hidden" name="id" value="<?= $model->id ?>">
                        <b></b>
                    </div>
                    <button class="button_yellow btn-submit-1 auction" type="submit"><?= Yii::t('Yama', 'Предложить'); ?></button>
                </div>
				<?php //endif; ?>
            
			<?php else: ?>
				<span class="price"><?= Yii::t('Yama', 'Отдаю даром'); ?></span>
			<?php endif;?>
			{{#auctions}}
        </div>
		<?php if(Yii::app()->user->id != $model->user_id): ?>
		<div class="b-market__item-bottom">
            <a target="_blank" href="<?= Yii::app()->params['socialBaseUrl'] . '/messages/send/' . $model->user_id . '?ahimsa=' . $model->id ?>" class="mes"><?= Yii::t('Yama', 'Напишите ЛС'); ?></a>
            <div class="b-market__item-bottom-i">
                <figure>
					<?= UserService::printAvatar($users[$model->user_id]->id, $users[$model->user_id]->name, 30, true, true); ?>
                </figure>
					<?php $phone = ($model->phone)?$model->phone:$users[$model->user_id]->phone?>
					<p><strong><?= $users[$model->user_id]->name ?></strong>
						<?php if($phone): ?>
							<?= Yii::t('Yama', 'или звоните '); ?> <?= preg_replace('/^(\d{2})(\d{3})(\d{2})(\d{2})$/', '<span>+375 $1</span> $2 $3 $4', $phone) ?>
						<?php endif; ?>
					</p>
            </div>
        </div>
		<?php endif; ?>
		
		{{#comments}}
		
        <!--<div class="b-market__related-items">
            <h2 class="b-market__related-items-title">Похожие объявления<i class="icon"></i></h2>
            <article>
                <small><b>_Lion_</b>1 минуту назад</small>
                <p>
                    <a href="#">Ноутбук Samsung R540-JS05Процессор ноутбука Intel Core i5 450M 2.4 ГГц... ГГ...Винчестер 250Гб, 5400 оборотов/мин., SATA, 2.5"</a>
                </p>
                <figure>
                    <img src="temp/img_34.png" alt="migom.by">
                </figure>
            </article>
            <article>
                <small><b>_Lion_</b>1 минуту назад</small>
                <p>
                    <a href="#">Ноутбук Samsung R540-JS05Процессор ноутбука Intel Core i5 450M 2.4 ГГц... ГГ...Винчестер 250Гб, 5400 оборотов/мин., SATA, 2.5"</a>
                </p>
                <figure>
                    <img src="temp/img_1.png" alt="migom.by">
                </figure>
            </article>
            <article class="last">
                <small><b>_Lion_</b>1 минуту назад</small>
                <p>
                    <a href="#">Ноутбук Samsung R540-JS05Процессор ноутбука Intel Core i5 450M 2.4 ГГц... ГГ...Винчестер 250Гб, 5400 оборотов/мин., SATA, 2.5"</a>
                </p>
                <figure>
                    <img src="temp/img_9.png" alt="migom.by">
                </figure>
            </article>
        </div>-->
		<div class="addthis_toolbox" 
			addthis:url="<?= Yii::app()->getBaseUrl(true) . '/ahimsa/' . $model->id ?>" 
			addthis:title="<?= $model->description ?> " >
        <ul class="b-market__item-socnet">
				<li>
					<a href="#" class="item-1 addthis_button_facebook"><img src="/images/icons/facebook.png" width="50" height="50" border="0" alt="Share to Facebook" /></a>
				</li>
				<li>
					<a href="#" class="item-2 addthis_button_twitter"><img src="/images/icons/twitter.png" width="50" height="50" border="0" alt="Share to Twitter" /></a>
				</li>
				<li>
					<a href="#" class="item-3 addthis_button_vk"><img src="/images/icons/vk.png" width="50" height="50" border="0" alt="Share to Vk" /></a>
				</li>
				<li>
					<a href="#" class="item-3 addthis_button_pinterest_share"><img src="/images/icons/pinterest.png" width="50" height="50" border="0" alt="Share to Pinterest" /></a>
				</li>
				<li>
					<a href="#" class="item-3 addthis_button_odnoklassniki_ru"><img src="/images/icons/odnoklassniki.png" width="50" height="50" border="0" alt="Share to Odnoklassniki" /></a>
				</li>
				<li>
					<a href="#" class="item-3 addthis_button_google_plusone_share"><img src="/images/icons/google_plus.png" width="50" height="50" border="0" alt="Share to Google+" /></a>
				</li>
				<!--<li>
					<a href="#" class="item-3 addthis_button_print"><img src="/images/icons/vk.png" width="50" height="50" border="0" alt="Print page" /></a>
				</li>-->
				

        </ul>
		</div>
		<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5177986b221d1cf3&username=Yama.by"></script>
		<?php if($popup): ?>
			<a href="#" class="close-icon icon close" title="Закрыть"></a>
		<?php endif; ?>
        <!--<ul class="b-market__item-nav">
            <li>
                <a href="#" class="left-arr">Пред.<br>объявление<i class="icon"></i></a>
            </li>
            <li>
                <a href="#" class="right-arr">След.<br>объявление<i class="icon"></i></a>
            </li>
        </ul>-->    
    </div>
</div>

<?php 

	$js = '';
	if(Yii::app()->user->isGuest){
		$js = "jQuery('.b-market__item').on('click', '.auction', function(){
			window.location = '" . Yii::app()->params['socialBaseUrl'] . '/login' . "'
		})";
	} else {
		$js = "jQuery('.b-market__item').on('click', '.auction', function(){
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
	Yii::app()->clientScript->registerScript('auction', $js . "
		
		jQuery('.b-market__item-i').on('click', '.changeStatus', function(){
			if($(this).hasClass('unactivate')){
				$(this).removeClass('unactivate')
				$(this).addClass('activate')
				$('.b-market__item-i .tag-1').hide()
				$.post('" . Yii::app()->getBaseUrl(true) . '/ahimsa/changeStatus/id/' ."' + $('.b-market__item').attr('id'), {status: 1})
			} else {
				$(this).addClass('unactivate')
				$(this).removeClass('activate')
				$('.b-market__item-i .tag-1').show()
				$.post('" . Yii::app()->getBaseUrl(true) . '/ahimsa/changeStatus/id/' ."' + $('.b-market__item').attr('id'), {status: 2})
			}
		})
		
		jQuery('.b-market__item-i').on('click', '.info-1 .up', function(){
			if($(this).hasClass('unactive')){
				return false;
			}
			$.post('" . Yii::app()->getBaseUrl(true) . '/ahimsa/up/id/' ."' + $('.b-market__item').attr('id'))
			$(this).addClass('unactive')
		})

	", CClientScript::POS_END);
?>

<script>
	$('.b-market__item-img').fotorama({
		width:640,
		height:400,
		background:"#fff",
		margin:0,
		navPosition:"bottom",
		thumbSize:67,
		thumbMargin:5,
		zoomToFit: false,
		thumbBorderColor:"#fff",
		thumbsCentered: false,
		shadows:false,
		data: [
			{
				img: '<?= Yii::app()->getBaseUrl(true) . Adverts::IMAGE_PATH . '/' . $model->id . '/view/' . $model->image ?>',
				thumb: '<?= Yii::app()->getBaseUrl(true) . Adverts::IMAGE_PATH . '/' . $model->id . '/thumbs/' . $model->image ?>',
				full: ''
			}
			<?php foreach($images as $img): ?>
			<?php if($img == $model->image) continue; ?>
			,{
				img: '<?= Yii::app()->getBaseUrl(true) . Adverts::IMAGE_PATH . '/' . $model->id . '/view/' . $img ?>',
				thumb: '<?= Yii::app()->getBaseUrl(true) . Adverts::IMAGE_PATH . '/' . $model->id . '/thumbs/' . $img ?>',
				full: ''
			}
			<?php endforeach; ?>
		],
		fullscreenIcon: true
	});

	/*$(function() {
		$('.b-market__item-img').fotorama({  
			width:640,
			//height:493,
			background:"#fff",
			margin:0,
			navPosition:"bottom",
			thumbSize:67,
			thumbMargin:5,
			zoomToFit: true,
			thumbBorderColor:"#fff",
			thumbsCentered: false,
			shadows:false
		});
	});*/
</script>