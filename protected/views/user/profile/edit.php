<div class="lenta">

    <?php $this->widget('UserMain', array('model' => $model, 'active' => 'profile')); ?>

    <div class="main profile">
        <div class="summary">
            <div class="avatar">
                <?php $this->widget('core.extensions.EAjaxUpload.EAjaxUpload',
                array(
                        'id'=>'uploadFile',
                        'config'=>array(
                            'action'=>  $this->createUrl('uploadAvatar'),
                            'allowedExtensions'=>array("jpg","jpeg","png"),//array("jpg","jpeg","gif","exe","mov" and etc...
                            'sizeLimit'=> 2 *1024 * 1024,// maximum file size in bytes
                //                'minSizeLimit'=>10*1024*1024,// minimum file size in bytes
                            'onComplete'=>"js:function(id, fileName, responseJSON){ tempImage = '".
                                    $model->getAvatarUrl(true)
                                ."'; $('#uploadAvatar a img').attr('src', tempImage + '?' + fileName + '&' + Math.floor((Math.random()*99999)+1)); }",
                            'template' => '<div class="qq-uploader">
                                    <div class="qq-upload-drop-area"><span>' . Yii::t('Profile', 'Перетащите файл сюда') . '</span></div>
                                    <div id="uploadAvatar" class="qq-upload-button">' . UserService::printAvatar($model->id, $model->login, 96) . '</div>
                                    <div class="qq-upload-list"></div>
                                </div>',
                            'messages'=>array(
                                    'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
                                    'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
                                    'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
                                    'emptyError'=>"{file} is empty, please select files again without it.",
                                    'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
                                ),
                            )
                ));
                ?>
            </div>
            <!--<div class="avatar"><?= UserService::printAvatar($model->id, $model->login, 96); ?></div>-->
            <div class="name">
                <strong><?= $model->login; ?></strong>
                <?= CHtml::link(Yii::t('Profile', 'Вернуться в профиль'), array('/profile')) ?>
            </div>
        </div>
        <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'profileForm',
                    'enableAjaxValidation'=>true,
                    'enableClientValidation'=>true,
                    'focus'=>array($model,'username'),
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                        'inputContainer' => 'div',
                        'afterValidate' => 'js:function(form, data, hasError){ $(form).validateAttrs(data); return true; }',
                        'afterValidateAttribute' => 'js:function(form, attribute, data, hasError){ $(form).validateAttrs(data); return true; }',
                        'hideErrorMessage' => true,
                    ),
        )); ?>
        <table>
            <caption><?= Yii::t('Profile', 'Редактирование профиля') ?></caption>
			<tr>
                <th><?php echo $form->label($model,'email'); ?>:</th>
                <td><?php echo $form->textField($model,'email', array('disabled' => 'disabled')); ?></td>
            </tr>
            <tr>
                <th><?php echo $form->label($model,'nickName'); ?>:</th>
                <td><?php echo $form->textField($model,'login'); ?></td>
                <?php echo $form->error($model,'login'); ?>
            </tr>
            <tr>
                <th><?php echo $form->label($model->profile,'name'); ?>:</th>
                <td><?php echo $form->textField($model->profile,'name'); ?></td>
            </tr>
            <tr>
                <th><?php echo $form->label($model->profile,'surname'); ?>:</th>
                <td><?php echo $form->textField($model->profile,'surname'); ?></td>
            </tr>
            <tr>
                <th><?php echo $form->label($model->profile,'sex'); ?>:</th>
                <td>
                    <label>
                        <input type="radio" name="<?= get_class($model->profile) ?>[sex]" value="1" <?php if($model->profile->sex == 1): ?>checked="checked" <?php endif;?>>
                        <span><?= Yii::t('Profile', 'мужской'); ?></span>
                    </label>
                    <label>
                        <input type="radio" value="2" name="<?= get_class($model->profile) ?>[sex]" <?php if($model->profile->sex == 2): ?>checked="checked" <?php endif;?>>
                        <span><?= Yii::t('Profile', 'женский'); ?></span>
                    </label>
                </td>
            </tr>
            <tr>
                <th><?php echo $form->label($model->profile,'birthday'); ?>:</th>
                <td class="birth">
                    <?php $birthday = explode('-', $model->profile->birthday);  ?>
                    <?= CHtml::dropDownList('birthday[day]', round($birthday[2]), $days, array('class' => 'day')) ?>
                    <?= CHtml::dropDownList('birthday[month]', $birthday[1], $month, array('class' => 'month')) ?>
                    <?= CHtml::dropDownList('birthday[year]', $birthday[0], $year, array('class' => 'year')) ?>
<!--                    <label>
                        <input type="checkbox" checked="checked">
                        <span>скрывать дату рождения</span>
                    </label>-->
                </td>
            </tr>
            <tr>
                <th><?php echo $form->label($model->profile,'city_id'); ?>:</th>
                <td><?php echo $form->dropDownList($model->profile,'city_id', CHtml::listData($regions, 'id', 'name'), array('class' => 'regions')); ?></td>
            </tr>
            <?php if(!$model->email): ?>
                <tr>
                    <th><?php echo $form->label($model,'email'); ?>:</th>
                    <td><?php echo $form->textField($model,'email'); ?><?php echo $form->error($model,'email'); ?></td>

                </tr>
                <tr>
                    <th><?php echo $form->label($model,'reemail'); ?>:</th>
                    <td><?php echo $form->textField($model,'reemail'); ?><?php echo $form->error($model,'reemail'); ?></td>

                </tr>
            <?php endif; ?>

        </table>

<!--        <table class="collapsible">
            <caption><p><span>Настройки ленты</span></p></caption>
            <tr>
                <th></th>
                <td>
                    <label>
                        <input type="checkbox" checked="checked">
                        <span>Новые комментарии</span>
                    </label>
                </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <label>
                        <input type="checkbox" checked="checked">
                        <span>Снижение цены</span>
                    </label>
                </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <label>
                        <input type="checkbox" checked="checked">
                        <span>Появление в продаже</span>
                    </label>
                </td>
            </tr>
        </table>-->

        <table class="collapsible <?php if($model->getError('password') || $model->getError('repassword')): ?>expanded<?php endif; ?>">
            <caption><p><span><?= Yii::t('Profile', 'Изменение пароля'); ?></span></p></caption>
<!--            <tr>
                <th><?php echo $form->label($model,'old_password'); ?>:</th>
                <td><?php echo $form->passwordField($model,'old_password', array('disabled' => 'disabled')); ?></td>
            </tr>-->
            <tr>
                <th><?php echo $form->label($model,'password'); ?>:</th>
                <td><?php $model->newpassword = ''; echo $form->passwordField($model, 'newpassword', array('disabled' => 'disabled')); ?></td>
            </tr>
            <tr>
                <th><?php echo $form->label($model,'repassword'); ?>:</th>
                <td><?php echo $form->passwordField($model,'repassword', array('disabled' => 'disabled')); ?>
                    <?= $form->error($model,'repassword'); ?>
                </td>
            </tr>
        </table>
		
		<table class="collapsible">
            <caption><p><span><?= Yii::t('Profile', 'Настройки уведомлений'); ?></span></p></caption>
            <tr>
                <th><?php echo CHtml::checkbox('comments_activity', isset($news->disable_notify['comments_activity'])); ?></th>
                <td class="checkbox_info"><?php echo CHtml::label(Yii::t('Profile', 'Отключить уведомления об ответах на комментарии'), 'comments_activity'); ?></td>
            </tr>
            <tr>
                <th><?php echo CHtml::checkbox('all_activity', isset($news->disable_notify['all_activity'])); ?></th>
                <td class="checkbox_info"><?php echo CHtml::label(Yii::t('Profile', 'Отключить ежедневные уведомления о полезности комментариев'), 'all_activity'); ?></td>
            </tr>
        </table>

        <div class="buttons">
            <button id="save" class="button_yellow search-button">Сохранить</button>
            <div class="cancel-link">
                <?= CHtml::link(Yii::t('Profile', 'Отмена, вернуться в профиль'), $this->createUrl('/profile')) ?>
            </div>
        </div>
    </div>

    <?php $this->endWidget(); ?>
    <?php
        $cs = Yii::app()->getClientScript();
		
        $cs->registerScript(
            'calendar',
            '
            sYear = $(".year").val();
            sMonth = $(".month").val();
            date = new Date(sYear, sMonth, 0);
            sDay = $(".day").val();
            sDay++;
            $(".day").html($(createDateOptions(0, date.getDate())));
            $(".day :nth-child("+sDay+")").attr("selected", "selected");

            $(".month").change(function(){
                sDay = $(".day").val();
                sDay++;
                sMonth = $(this).val();
                sYear = $(".year").val();
                date = new Date(sYear, sMonth, 0);
                $(".day").html($(createDateOptions(0, date.getDate())));
                $(".day :nth-child("+sDay+")").attr("selected", "selected");

            })

            $(".year").change(function(){
                sDay = $(".day").val();
                sDay++;
                sYear = $(this).val();
                sMonth = $(".month").val();
                date = new Date(sYear, sMonth, 0);
                $(".day").html($(createDateOptions(0, date.getDate())));
                $(".day :nth-child("+sDay+")").attr("selected", "selected");
            })

            function createDateOptions(from, to){
                html = \'<option value="0">'. Yii::t('Profile', 'дд') .'</option>\';
                for(i = ++from; i <= to; i++){
                    if(i < 10){
                       i = \'0\'+i;
                    }
                    html += \'<option>\' + i + \'</option>\';
                }
                return html;
            }',
          CClientScript::POS_END
        );

        $cs->registerScript(
            'showOptions',
            '$(".collapsible").on("click", "caption", function(e) {
                $(e.delegateTarget).toggleClass("expanded")
				if($(e.delegateTarget).hasClass("expanded")){
					$(e.delegateTarget).find("input").prop("disabled", false)
				} else {
					$(e.delegateTarget).find("input").val("");
					$(e.delegateTarget).find("input").prop("disabled", true)
					$(e.delegateTarget).find("input").attr("disabled", "disabled")
					$(e.delegateTarget).find("input").removeClass("error")
				}
            });',
          CClientScript::POS_END
        );
        // TODO:: чек основных городов
        $cs->registerScript(
            'ajaxRegions',
            'jQuery(function($){$(\'body\').on(\'change\',\'.regions\',function(){ var block = this;  $.post("'.
                    CController::createUrl('/ajax/regions', array('parent_id' => ''))
                .'"+$(this).val()).success(function(data) { $(block).next("td").remove(); $(data).insertAfter($(block));  });   return false;}); });',
          CClientScript::POS_END
        );

    ?>
</div>