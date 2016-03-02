<?php
/* @var $this SettingsController */
/* @var $model Settings */
$this->menu=array(
    array('label'=>'Шаблоны получателей', 'url'=>array('template')),
);
?>

<h1>Изменить настройки</h1>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'settings-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
    )); ?>

    <p class="note">Поля помеченные <span class="required">*</span> обязательны для заполнения.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'set_alert'); ?>
        <?php echo $form->textField($model,'set_alert'); ?>
        <?php echo $form->error($model,'set_alert'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'set_old'); ?>
        <?php echo $form->textField($model,'set_old'); ?>
        <?php echo $form->error($model,'set_old'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'set_archive'); ?>
        <?php echo $form->textField($model,'set_archive'); ?>
        <?php echo $form->error($model,'set_archive'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'set_auto'); ?>
        <?php echo $form->dropDownList($model,'set_auto',
            array('0' => 'вручную', '1' => 'автоматически'));?>
        <?php echo $form->error($model,'set_auto'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить', array('class'=>'btn')); ?>
        <?php echo CHtml::button('Отмена', array('class'=>'btn', 'submit' => array('view', 'id'=>$model->set_user_id)));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->