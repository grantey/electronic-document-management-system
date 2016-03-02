
<h2><?php echo $model->user_full_name; ?></h2>

<!--<div class="form">

<?php /*$form=$this->beginWidget('CActiveForm', array(
    'id'=>'about-form',
    'enableAjaxValidation'=>false,
)); */?>

<div class="row">
    <?php /*echo $form->labelEx($model,'user_full_name'); */?>
    <?php /*echo $form->textField($model,'user_full_name',array('size'=>50,'maxlength'=>200)); */?>
    <?php /*echo $form->error($model,'user_full_name'); */?>
</div>

<div class="row">
    <?php /*echo $form->labelEx($model,'user_post'); */?>
    <?php /*echo $form->textField($model,'user_post',array('size'=>50,'maxlength'=>200)); */?>
    <?php /*echo $form->error($model,'user_post'); */?>
</div>


    <?php /*$this->endWidget(); */?>

</div><!-- form -->

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        //'user_id',
        //'user_login',
        //'user_password',
        'user_full_name',
        'user_post',
        'user_phone',
        'user_faculty',
        'user_depart',
    ),
)); ?>