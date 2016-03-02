<?php
/* @var $this OrdersController */
/* @var $model Orders */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'orders-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<p class="note">Поля помеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary(array($model)); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'order_header'); ?>
        <?php echo $form->textField($model,'order_header',array('size'=>50,'maxlength'=>200)); ?>
        <?php echo $form->error($model,'order_header'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_text'); ?>
		<?php echo $form->textArea($model,'order_text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'order_text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_date'); ?>
        <?php if ($model->isNewRecord) $model->order_data_from = date('Y-m-d'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'order_data_from',
            'model' => $model,
            'value' => $model->order_data_from,
            'attribute' => 'order_data_from',
            'language' => 'ru',
            'options' => array(
                'dateFormat'=>'yy-mm-dd',
            ),
            'htmlOptions' => array(
                'style' => 'height:20px;',
                'id'=>'date1',
            ),
        ));?>
		<?php echo $form->error($model,'order_data_from'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_date_to'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'order_data_to',
            'model' => $model,
            'attribute' => 'order_data_to',
            'language' => 'ru',
            'options' => array(
                'dateFormat'=>'yy-mm-dd',
            ),
            'htmlOptions' => array(
                'style' => 'height:20px;',
                'id'=>'date2',
            ),
        ));?>
		<?php echo $form->error($model,'order_data_to'); ?>
	</div>

    <div class="row">
    <?php
    echo $form->dropDownList($model,'order_type',
        Category::All(),
        array('empty' => '--- Тип документа ---')
    );?>
    <?php echo $form->error($model,'order_type'); ?>
    </div>

<!--	<div class="row">
		<?php echo $form->labelEx($model,'order_status'); ?>
		<?php echo $form->textField($model,'order_status'); ?>
		<?php echo $form->error($model,'order_status'); ?>
	</div> -->

    <div class="row">
    <?php
    $this->widget('CMultiFileUpload', array(
        'model'=>$files,
        'name'=>'upfiles',
        'attribute'=>'upfiles',
        'accept'=>'jpg|gif|png|pdf|doc',
        'options'=>array(
            // 'onFileSelect'=>'function(e, v, m){ alert("onFileSelect - "+v) }',
            // 'afterFileSelect'=>'function(e, v, m){ alert("afterFileSelect - "+v) }',
            // 'onFileAppend'=>'function(e, v, m){ alert("onFileAppend - "+v) }',
            // 'afterFileAppend'=>'function(e, v, m){ alert("afterFileAppend - "+v) }',
            // 'onFileRemove'=>'function(e, v, m){ alert("onFileRemove - "+v) }',
            // 'afterFileRemove'=>'function(e, v, m){ alert("afterFileRemove - "+v) }',
        ),
        'denied'=>'File is not allowed',
        'max'=>10, // max 10 files
    ));
    ?>
    </div>

    <?php if (!Yii::app()->request->isAjaxRequest): ?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', array('class'=>'btn')); ?>
	</div>

    <?php else: ?>
        <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
            <div class="ui-dialog-buttonset">
                <?php
                $this->widget('zii.widgets.jui.CJuiButton', array(
                    'name'=>'submit_'.rand(),
                    'caption'=>$model->isNewRecord ? 'Создать' : 'Сохранить',
                    'htmlOptions'=>array(
                        'ajax' => array(
                            'url'=>$model->isNewRecord ? $this->createUrl('create') : $this->createUrl('update', array('id'=>$model->order_id)),
                            'type'=>'post',
                            'data'=>'js:jQuery(this).parents("form").serialize()',
                            'success'=>'function(r){
                            if(r=="success") {
                                window.location.reload();
                            }
                            else{
                                $("#create").html(r).dialog("open"); return false;
                            }
                        }',
                        ),
                    ),
                ));
                ?>
            </div>
        </div>
    <?php endif; ?>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php

Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $('#date1').datepicker(jQuery.extend(jQuery.datepicker.regional['ru'],{'dateFormat':'yy-mm-dd'}));
    $('#date2').datepicker(jQuery.extend(jQuery.datepicker.regional['ru'],{'dateFormat':'yy-mm-dd'}));
}
");