<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля помеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_login'); ?>
		<?php echo $form->textField($model,'user_login',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'user_login'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_password'); ?>
		<?php echo $form->textField($model,'user_password',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'user_password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_full_name'); ?>
		<?php echo $form->textField($model,'user_full_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'user_full_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_post'); ?>
		<?php echo $form->textField($model,'user_post',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'user_post'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_phone'); ?>
		<?php echo $form->textField($model,'user_phone',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'user_phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_faculty'); ?>
		<?php echo $form->textField($model,'user_faculty',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'user_faculty'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_depart'); ?>
		<?php echo $form->textField($model,'user_depart',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'user_depart'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->