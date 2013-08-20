<div class="body">
<!--Market-add-item-->
	<?php $form = $this->beginWidget('CActiveForm', array(
      'id'=>'createForm',
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>true,
	  'htmlOptions' => array(
		'enctype'=>'multipart/form-data',
	  ),
      'clientOptions'=>array(
		'validateOnSubmit'=>true,
		'inputContainer' => 'div',
		'afterValidate' => 'js:function(form, data, hasError){ return !$(form).validateAttrs(data) }',
		'afterValidateAttribute' => 'js:function(form, attribute, data, hasError){ return !$(form).validateAttrs(data) }',
		'hideErrorMessage' => true,
	),
  )); ?>
<div class="b-market__add-item">
	<div class="b-market__add-item-top">
		<figure class="logo">
			<a href="<?= Yii::app()->getBaseUrl(true) ?>"><?= CHtml::image('/images/market_logo_1.png', 'migom.by', array('width' => 95, 'height' => 40)) ?></a>
		</figure>
		<!--
		<a href="#" class="add-link">Все разделы<i class="icon"></i></a>
		-->
		<h1 class="title-1">Новое объявление за 2 минуты</h1>
		
	</div>
	<div class="b-market__add-item-form">
		<form action="" method="" id="">
			<!--<div class="b-market__add-item-form-i email">
				<dl>
					<dt>Продукт:</dt>
					<dd>Введите id продукта или ссылку на продукт с migom.by. Например: http://www.migom.by/Canon-EOS-700D-332675/</dd>
				</dl>
				<?= CHtml::textField('product', ($model->product_id) ? $model->product_id : '', array('class' => 'value-5')); ?>
				<?php echo $form->hiddenField($model,'product_id'); ?>
			</div>-->
			<div class="b-market__add-item-form-i description cfix">
				<dl>
					<dt>Текст объявления: <sup>*</sup></dt>
					<dd>Поставьте себя на место покупателя и напишите ту, информацию, которую бы вы хотели получить от продавца.</dd>
				</dl>
				<dl class="hint">
					<dt><b>Примечание:</b><i class="icon"></i></dt>
					<dd>В тексте объявления запрещено указывать номер телефона. Для этого есть отдельное поле.<i class="icon"></i></dd>
				</dl>
				<?php if($model->product_id): ?>
				<div class="from-catalog">
					<figure>
						<?= CHtml::image(ProdImgService::getUrl($model->product_id, $infoProd->section_id, 'small', $infoProd->name), $infoProd->name) ?>
					</figure>
					<a href="<?= Yii::app()->getBaseUrl(true) . '/' . $model->product_id ?>"><?= $infoProd->name ?></a>
					<p>от <a href="<?= Yii::app()->getBaseUrl(true) . '/' . $model->product_id ?>"><?= $infoProd->cost ?></a>$ <small>в каталоге</small>
					</p>
					<label class="checkbox-wrap"><input type="checkbox" value="" name="" id=""><span>Связать характеристики</span><i class="icon"></i></label>
				</div>
				<?php else: ?>
				<div class="from-catalog" style="display: none;">
					<figure>
						<img src="" alt="migom.by">
					</figure>
					<a href="#"></a>
					<p>от <a href="#"></a>$ <small>в каталоге</small>
					</p>
					<label class="checkbox-wrap"><input type="checkbox" value="" name="" id=""><span>Связать характеристики</span><i class="icon"></i></label>
				</div>
				<?php endif;?>
				
				<?php echo $form->textArea($model,'text', array('limited-text' => 2500, 'cols' => 30, 'rows' => 5, 'class' => 'txt-1 limited-text', 'placeholder' => Yii::t('Yama', 'Продам...'))); ?>
				<?php echo $form->error($model,'text'); ?>
				<small class="counter">Осталось <b>2500</b> знаков</small>
			</div>
			<div class="b-market__add-item-form-i short-description cfix">
				<dl>
					<dt>Заголовок объявления: <sup>*</sup></dt>
					<dd>Очень ёмко опишите свое предложение в двух словах.</dd>
				</dl>
				<!--<ul class="b-market__tags-line">
					<li>мобильный&nbsp;<i class="del" title="Удалить"></i></li>
					<li>телефон&nbsp;<i class="del" title="Удалить"></i></li>
					<li>apple&nbsp;<i class="del" title="Удалить"></i></li>
					<li>16 Gb&nbsp;<i class="del" title="Удалить"></i></li>
				</ul>-->
				<?php echo $form->textArea($model,'description', array('limited-text' => 250, 'cols' => 30, 'rows' => 5, 'class' => ($model->description) ? 'txt-2 limited-text processed' : 'txt-2 limited-text')); ?>
				<?php echo $form->error($model,'description'); ?>
				<small class="counter">Осталось <b>250</b> знаков</small>
			</div>
			<div class="b-market__add-item-form-i price cfix">
				<dl>
					<dt>Цена: <sup>*</sup></dt>
					<dd>Укажите стоимость.</dd>
				</dl>
				<div class="price-i">
					<?php if($model->price == 0) $model->price = ''; ?>
					<?php echo $form->textField($model,'price', array('class' => 'value-6')); ?>
					<?php echo $form->error($model,'price'); ?>
					<dl>
						<dt>
							<?= $form->dropDownList($model, 'currency', Adverts::$currency) ?>
							<!--<a href="#">долларов<i class="icon"></i></a>-->
						</dt>
						<dd></dd>
					</dl>
					<span>или</span>
					<label>
						<?php if(!$model->isNewRecord && !$model->price && get_class($model) == 'Adverts') $model->free = true; ?>
						<?php echo $form->checkBox($model,'free'); ?>
						<?php echo $form->error($model,'free'); ?>
						<span>отдать даром</span>
					</label>
				</div>
			</div>
			<div class="b-market__add-item-form-i images with-hint cfix">
				<dl>
					<dt>Фотографии:</dt>
					<dd>Загрузите фото. Котов в мешке покупают единицы.</dd>
				</dl>
				<dl class="hint">
					<dt><b>Как добавить фото?</b><i class="icon"></i></dt>
					<dd>Нажать на кнопку и выбрать фото.<i class="icon"></i></dd>
					<dd>Перетащить фото на кнопку.<i class="icon"></i></dd>
					<dd>Выделить несколько и загрузить сразу.<i class="icon"></i></dd>
					<dd><a href="javaScript:void(0)" onclick="toggleForm(this); return false">Вставить ссылку</a>.<i class="icon"></i></dd>
				</dl>
				<?php echo $form->hiddenField($model,'image'); ?>
				<?php 
					$template = '<div class="qq-uploader images-wrap">
						<div class="qq-upload-button cfix qq-upload-drop-area">
						<div class="qq-upload-drop-zone"><span>Drop files here to upload</span></div>
						<div id="sortable" class="images-wrap-i qq-upload-list" >';
					$count = 8;
					if($model->image){
						$template .= '<div class="img"><span class="del-icon"></span><span class="rot-icon"></span>';
						$template .= Chtml::image(Yii::app()->getBaseUrl(true) . '/images/ahimsa/' . $model->id . '/mini/' . $model->image);
						$template .= '</div>';
						$count = 7;
					}
					for($i = 0; $i < $count; $i++){
						if(isset($images[$i])){
							$template .= '<div class="img"><span class="del-icon"></span><span class="rot-icon"></span>';
							$template .= Chtml::image(Yii::app()->getBaseUrl(true) . '/images/ahimsa/' . $model->id . '/mini/' . $images[$i]);
							$template .= '</div>';
						} else {
							$template .= '<div class="img free"><div class="size"></div></div>';
						}
					}
					$template .= '
							</div>
							<p>Упрощенная <a href="#" onclick="toggleForm(this); return false">форма добавления</a></p>
							<small href="#" class="main-img">Главное фото <i class="icon"></i></small>   
						</div>
					</div>';
				
				?>
<?php 
    $this->widget('core.extensions.EAjaxUpload.EAjaxUpload', array(
        'id' => 'uploadFile',
        'config' => array(
			'multiple'=>'multiple',
            'action' => Yii::app()->createUrl('ahimsa/uploadImage', array('id' => $model->id)),
			'allowedExtensions'=>array("jpg","jpeg"),//array("jpg","jpeg","gif","exe","mov" and etc...
			'sizeLimit'=>2*1024*1024,// maximum file size in bytes
			'styleAndJs' => 'sell',
			//'onComplete' => "js:function(id, fileName, responseJSON){uploadImagesCallback(id, fileName, responseJSON, this)}",
			'fileTemplate' => '<div class="img"></div>',
			'template' => $template,
			'filesCount' => count($images),
			'classes' => array(
				'button' => 'qq-upload-button',
				'drop' => 'qq-upload-drop-area',
				'dropActive' => 'qq-upload-drop-area-active',
				'list' => 'qq-upload-list',

				'file' => 'qq-upload-file',
				'spinner' => 'qq-upload-spinner',
				'size' => 'size',
				'img'	=> 'free',
				'cancel' => 'qq-upload-cancel',

				// added to list item when upload completes
				// used in css to hide progress spinner
				'success' => 'qq-upload-success',
				'fail' => 'qq-upload-fail',
				
				// checkbox for main photo
				'mainPhoto' => 'qq-upload-check-main'
			),
            /*'allowedExtensions' => array("jpg", "png", "gif", "jpeg"), //array("jpg","jpeg","gif","exe","mov" and etc...
            'sizeLimit' => 1 * 1024 * 1024, // maximum file size in bytes
            'minSizeLimit' => 1, // minimum file size in bytes
            'onComplete' => "js:function(id, fileName, responseJSON){ $('.uploadFile img').attr('src', \"".Yii::app()->params['tagsBaseUrl'].Adverts::IMAGE_TEMP_PATH."/0/\"+fileName); $('.uploadFile').clone().appendTo('.summary').removeClass('uploadFile').show() }",
            'messages' => array(
                'typeError' => "{file} has invalid extension. Only {extensions} are allowed.",
                'sizeError' => "{file} is too large, maximum file size is {sizeLimit}.",
                'minSizeError' => "{file} is too small, minimum file size is {minSizeLimit}.",
                'emptyError' => "{file} is empty, please select files again without it.",
                'onLeave' => "The files are being uploaded, if you leave now the upload will be cancelled."
            ),
            'showMessage' => "js:function(message){ alert(message); }"*/
        )
    ));
?>			
				<div class="simple-uploader" style="display: none;">
					<input type="file" name="file1">
					<input type="file" name="file2">
					<input type="file" name="file3">
					<input type="file" name="file4">
					<input type="file" name="file5">
					<input type="file" name="file6">
					<input type="file" name="file7">
					<input type="file" name="file8">
					<p>Основная <a href="#" onclick="toggleForm(this); return false">форма добавления</a></p>
				</div>
			</div>
			<div class="b-market__add-item-form-i cfix region with-hint">
				<dl class="val-2">
					<dt>Рубрика: <small></small></dt>
					<dd>
						Ваше объявление будет добавлено в этот раздел
					</dd>
				</dl>
				<dl class="hint" style="display:none;">
					<dt><b>Например:</b><i class="icon"></i></dt>
					<dd>.<i class="icon"></i></dd>
				</dl>
				<div class="region-i">
					<?= $form->dropDownList($model,'category', CHtml::listData(Categories::model()->findAll(array('order' => 'sort ASC')), 'id', 'title')); ?>
				</div>
			</div>
			<div class="b-market__add-item-form-i region cfix">
				<dl class="val-1">
					<dt>Регион:</dt>
					<dd>
						Укажите, где вы находитесь
					</dd>
				</dl>
				<div class="region-i">
					<?= $form->dropDownList($model,'region', CHtml::listData($regions, 'id', 'title'), array('class' => 'regions')); ?>
				</div>
			</div>
			<div class="b-market__add-item-form-i phone cfix">
				<dl>
					<dt>Номер телефона:</dt>
					<dd>Укажите контактный номер мобильного телефона.</dd>
				</dl>
				<div class="phone-i">
					<span>+375</span>
					<?php $phone = ($model->phone) ? $model->phone : Yii::app()->user->phone ?>
					<?php $prefix = substr($phone, 0, 2) ?>
					<?php $phone = substr($phone, 2) ?>
					<?= CHtml::dropDownList('phone_prefix', $prefix, array('' => '', 29 => 29, 25 => 25, 33 => 33, 44 => 44)) ?>
					<?php echo $form->textField($model,'phone_postfix', array('class' => 'value-4', 'maxlength' => 7, 'value' => $phone)); ?>
					<?php echo $form->error($model,'phone_postfix'); ?>
				</div>
				<figure>
					<div>
						<?= UserService::printAvatar(Yii::app()->user->id, Yii::app()->user->name, 30, true); ?>
					</div>
					<figcaption><?= Yii::app()->user->name ?></figcaption>
					<a href="javascript:void(0)" onclick="$('.another-name').toggle(); return false;">или на другое имя</a>
				</figure>
			</div>
			<div class="b-market__add-item-form-i email another-name" style="display:none;">
				<dl>
					<dt>Другое имя:</dt>
					<dd>Имя продавца к которому будут обращаться</dd>
				</dl>
				<?php if(!$model->name) $model->name = Yii::app()->user->name ?>
				<?php echo $form->textField($model,'name', array('class' => 'value-5')); ?>
			</div>
			<div class="b-market__add-item-form-i email">
				<dl>
					<dt>Электронная почта:</dt>
					<dd>Альтернативный способ связи.</dd>
				</dl>
				<?php if(Yii::app()->user->email) $model->email = Yii::app()->user->email; ?>
				<?php echo $form->textField($model,'email', array('class' => 'value-5')); ?>
				<?php echo $form->error($model,'email'); ?>
			</div>
			
			<?php echo $form->hiddenField($model,'id'); ?>
			<div class="b-market__add-item-form-i submit">
				<button type="submit" class="add-item-btn"><span><?= ($model->isNewRecord) ? 'Добавить объявление' : 'Сохранить объявление' ?><i class="icon"></i></span></button>
			</div>
		</form>
	</div>
</div>
<!--/Market-add-item-->

	<?php $this->endWidget(); ?>		
</div>

<?php 
	$cs = Yii::app()->getClientScript();
		
	$cs->registerScript(
		'ajaxRegions',
		'jQuery(function($){$(\'body\').on(\'change\',\'.regions\',function(){ var block = this;  $.post("'.
				CController::createUrl('/ahimsa/regions', array('name' => get_class($model), 'parent_id' => ''))
			.'"+$(this).val()).success(function(data) { $(block).next("select").remove(); $(data).insertAfter($(block));  });   return false;}); });',
	  CClientScript::POS_END
	);
		
	$cs->registerScript(
		'getProduct',
		'
			$("#createForm #product").on("focusout", function(event){
				jQuery.get("'.Yii::app()->getBaseUrl(true).'/ahimsa/getProduct", {url: $(this).val()}, function(data){
					jsonData = jQuery.parseJSON(data)
					if(!jsonData.success || !jsonData.id){
						return
					}
					
					$("#createForm #Adverts_Temp_product_id").val(jsonData.id)
					$("#createForm #Adverts_Temp_product_section_id").val(jsonData.section)
					$("#createForm .from-catalog img").attr("src", jsonData.image)
					$("#createForm .from-catalog a").html(jsonData.title)
					$("#createForm .from-catalog a").attr("href", "http://www.migom.by/" + jsonData.id)
					$("#createForm .from-catalog p a").html(jsonData.cost)
					$("#createForm .from-catalog").show("slow")
					
				})
			});
			
			$("#createForm .txt-1").on("keyup", function(){
				if(!$("#createForm .txt-2").hasClass("processed")){
					$("#createForm .txt-2").val($(this).val())
					textLimited($("#createForm .txt-2"))
				}
			})
			$("#createForm .txt-2").on("keyup", function(){
				$(this).addClass("processed")
			})
			
			$(".limited-text").on("keyup", function(){
				textLimited(this)
			})
			
			var textLimited = function(el){
				counter = $(el).attr("limited-text") - $(el).val().length
				if(counter < 1){
					counter = 0;
					$(el).val($(el).val().substr(0, $(el).attr("limited-text")))
				}
				$(el).parent().find(".counter b").html(counter)
			}
			
			toggleForm = function(){
				$(".qq-uploader").toggle(); 
				$(".simple-uploader").toggle();
			}
			
			$("#createForm").on("click", ".qq-uploader .img span.rot-icon", function(){
				image = $(this).parent().find("img")
				image.animate({
					opacity: 0.2
				}, 200);
				$.post("'.Yii::app()->getBaseUrl(true).'/ahimsa/rotateImage", {
					url: $(this).parent().find("img").attr("src"),
					id: '. $model->id .'
				}, function(data){
					image.attr("src", data)
					image.animate({
						opacity: 1
					}, 5000);
					if(document.getElementById("'. get_class($model) .'_image")){
						value = $("#createForm .qq-uploader .img:first img:first").attr("src")
						if(!value){
							document.getElementById("'. get_class($model) .'_image").value = ""
						} else {
							document.getElementById("'. get_class($model) .'_image").value = value
						}
					}
				})
			})
			
			$("#createForm").on("click", ".qq-uploader .img span.del-icon", function(){
				$.post("'.Yii::app()->getBaseUrl(true).'/ahimsa/dellImage", {
					url: $(this).parent().find("img").attr("src"),
					id: '. $model->id .'
				})
				parent = $(this).parent()
				parent.addClass("free");
				//var div = document.createElement("div")
				//div.setAttribute("class", "size")
				parent.html("");
				parent.append("<div class=\"size\"></div>")
				if(document.getElementById("'. get_class($model) .'_image")){
					value = $("#createForm .qq-uploader .img img:first").attr("src")
					if(!value){
						document.getElementById("'. get_class($model) .'_image").value = ""
					} else {
						document.getElementById("'. get_class($model) .'_image").value = value
					}
				}
				
			})
			
			$(".region-i select").change(function(){
				arr = {
						0: "Ваше объявление не подходит ни под один раздел? Выберите раздел \"Другое\"",
						1: "Ремонт(одежа, обувь, авто...), выгул собак...",
						3: "Телефон, эл.бритва, эл.двигатель, розетка, ноутбук, монитор...",
						4: "Пылесос, двери, окна ПВХ, ковер, ламинат...",
						5: "Автомобиль, авто запчасти, шины, магнитолы...",
						6: "Коляска, игрушка, плюшевый мишка, подгузники...",
						7: "Ошейники, корма, аквариумы, кормушки...",
						8: "Мячи, теннисные ракетки, бутсы, коньки...",
						9: "Джинсы, кроссовки, галстук, часы, портфель...",
						10: "...",
					}
				$(this).val()
				$(".b-market__add-item-form-i.region .hint").show("slow")
				$(".b-market__add-item-form-i.region .hint dd").html(arr[$(this).val()])
			})
			
			uploadImagesCallback = function(id, fileName, responseJSON, e){
				$(".qq-upload-list .img.free:first").append("<img src=\'"+responseJSON.fullname+"\'>")
			}
		',
	  CClientScript::POS_END
	  //js:function(id, fileName, responseJSON){ }
	);