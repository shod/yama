<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id'                   => 'users-form',
        'enableAjaxValidation' => false,
            ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'login'); ?>
<?php echo $form->textField($model, 'login', array('size'      => 60, 'maxlength' => 255)); ?>
<?php echo $form->error($model, 'login'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->profile, 'name'); ?>
        <?php echo $form->textField($model->profile, 'name', array('size'      => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model->profile, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->profile, 'surname'); ?>
        <?php echo $form->textField($model->profile, 'surname', array('size'      => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model->profile, 'surname'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->profile, 'avatar'); ?>
        <?php echo CHtml::image(Yii::app()->getBaseUrl() . Users::AVATAR_PATH . DIRECTORY_SEPARATOR . $model->id . DIRECTORY_SEPARATOR . 'avatar.jpg'); ?>
<?php echo CHtml::checkBox('Users_Profile[delImage]', false); ?>
<?php echo 'Удалить'; ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->profile, 'sex'); ?>
<?php echo $form->dropDownList($model->profile, 'sex', Users_Profile::$sexs); ?>
<?php echo $form->error($model->profile, 'sex'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->profile, 'birthday'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model'     => $model->profile,
            'attribute' => 'birthday',
            // additional javascript options for the date picker plugin
            'options'   => array(
                'showAnim'        => 'fold',
                'showButtonPanel' => true,
                'autoSize'        => true,
                'dateFormat'      => 'dd.mm.yy',
            //                            'defaultDate'=>$model->profile->birthday,
            ),
        ));
        ?>
<?php echo $form->error($model->profile, 'birthday'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'role'); ?>
<?php echo $form->dropDownList($model, 'role', Users::$roles); ?>
<?php echo $form->error($model, 'role'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
<?php echo $form->textField($model, 'email', array('size'      => 60, 'maxlength' => 255)); ?>
<?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'status'); ?>
<?php echo $form->dropDownList($model, 'status', Users::$statuses); ?>
<?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row">
<?php echo $form->labelEx($model, 'date_add'); ?>
<?php echo Yii::app()->dateFormatter->formatDateTime($model->date_add, 'long'); ?>
    </div>

    <div class="row">
<?php echo $form->labelEx($model, 'date_edit'); ?>
<?php echo Yii::app()->dateFormatter->formatDateTime($model->date_edit, 'long'); ?>
    </div>

    <div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->