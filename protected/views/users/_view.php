<?php
/* @var $this UsersController */
/* @var $data Users */
?>

<a href="<?php echo Yii::app()->createUrl('users/view', array('id'=>$data->user_id))?>" class="view">

<div>

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_login')); ?>:</b>
	<?php echo CHtml::encode($data->user_login); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_full_name')); ?>:</b>
	<?php echo CHtml::encode($data->user_full_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_post')); ?>:</b>
	<?php echo CHtml::encode($data->user_post); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_phone')); ?>:</b>
	<?php echo CHtml::encode($data->user_phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_faculty')); ?>:</b>
	<?php echo CHtml::encode($data->user_faculty); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('user_depart')); ?>:</b>
	<?php echo CHtml::encode($data->user_depart); ?>
	<br />

	*/ ?>

</div>

</a>