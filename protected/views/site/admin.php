
<div class="headline">
    <h1>Управление документами</h1>
</div>

<div class="tabs">
    <input id="tab1" type="radio" name="tabs" checked>
    <label for="tab1" title="Поиск">Поиск</label>

    <input id="tab2" type="radio" name="tabs">
    <label for="tab2" title="Документы">Документы</label>

    <!--<input id="tab3" type="radio" name="tabs">
    <label for="tab3" title="Состояние"></label>-->

    <section id="content2">
    <!--<script> alert('1');</script>-->
        <br>
            <div class="section-header">Новые</div>
            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'orders-grid1',
                'dataProvider'=>$model->search(1),
                'afterAjaxUpdate' => 'reinstallDatePicker',
                'summaryText' => "Документы {start} - {end} из {count}",
                'htmlOptions'=>array('style'=>'cursor: pointer;'),
                'columns'=>array(
                    array(
                        'name'=>'order_id',
                        'htmlOptions'=>array('width'=>'40px'),
                    ),
                    array(
                        'type'=>'raw',
                        'name'=>'order_header',
                    ),
                    array(
                        'name'=>'order_date',
                        'header'=>'Создан',
                        'value'=>'$data->traces[0]->trace_date',
                        /*'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model'=>$model,
                            'htmlOptions'=>array('id'=>'date1'),
                            'attribute'=>'order_date',
                            'language'=>'ru',
                            'options'=>array(
                                'dateFormat'=>'yy-mm-dd',
                            ),
                        ),true),*/
                    ),
                    array(
                        'name'=>'order_date_to',
                        'header'=>'Выполнить до',
                        'value'=>'$data->traces[0]->trace_date_to',
                        /*'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model'=>$model,
                            'htmlOptions'=>array('id'=>'date2'),
                            'attribute'=>'order_date_to',
                            'language'=>'ru',
                            'options'=>array(
                                'dateFormat'=>'yy-mm-dd',
                            ),
                        ),true),*/
                    ),
                    array(
                        'name' => 'order_type',
                        'filter' => CHtml::listData(Category::model()->findAll(), 'category_id', 'category_type'),
                        'value' => '$data->category->category_type',
                        'htmlOptions'=>array('width'=>'150px'),
                    ),
                    array(
                        'class'=>'CButtonColumn',
                        'htmlOptions'=>array('width'=>'90px','style'=>'white-space: pre; padding-left: 10px;'),
                        'template'=>'{about}  {update}  {delete}  {copy}',
                        'buttons' => array(
                            'about' => array(
                                'label'=>'Просмотр',
                                'url'=>'Yii::app()->createUrl("orders/view", array("id"=>$data->order_id))',
                                'imageUrl'=>Yii::app()->baseUrl.'/css/view.png',
                            ),
                            'update' => array(
                                'url'=>'Yii::app()->createUrl("orders/update", array("id"=>$data->order_id))',
                                'imageUrl'=>Yii::app()->baseUrl.'/css/update.png',
                            ),
                            'delete' => array(
                                'url'=>'Yii::app()->createUrl("orders/delete", array("id"=>$data->order_id))',
                                'imageUrl'=>Yii::app()->baseUrl.'/css/delete.png',
                            ),
                            'copy' => array(
                                'label'=>'Копировать',
                                'url'=>'Yii::app()->createUrl("orders/copy", array("id"=>$data->order_id))',
                                'imageUrl'=>Yii::app()->baseUrl.'/css/copy.png',
                                'options'=>array(
                                    'confirm'=>'Копировать этот документ ?',
                                ),
                            ),
                        ),
                    ),
                ),
            ));
            ?>

        <br>
            <div class="section-header">В работе</div>
            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'orders-grid2',
                'dataProvider'=>$model->search(2),
                'afterAjaxUpdate' => 'reinstallDatePicker',
                'summaryText' => "Документы {start} - {end} из {count}",
                'columns'=>array(
                    array(
                        'name'=>'order_id',
                        'htmlOptions'=>array('width'=>'40px'),
                    ),
                    array(
                        'type'=>'raw',
                        'name'=>'order_header',
                    ),
                    array(
                        'name'=>'order_date',
                        'header'=>'Создан',
                        'value'=>'$data->traces[0]->trace_date',
                    ),
                    array(
                        'name'=>'order_date_to',
                        'header'=>'Выполнить до',
                        'value'=>'$data->traces[0]->trace_date_to',
                    ),
                    array(
                        'name' => 'order_type',
                        'filter' => CHtml::listData(Category::model()->findAll(), 'category_id', 'category_type'),
                        'value' => '$data->category->category_type',
                        'htmlOptions'=>array('width'=>'150px'),
                    ),
                    array(
                        'class'=>'CButtonColumn',
                        'htmlOptions'=>array('width'=>'40px','style'=>'white-space: pre; padding-left: 15px;'),
                        'template'=>'{about}  {copy}',
                        'buttons' => array(
                            'about' => array(
                                'label'=>'Просмотр',
                                'url'=>'Yii::app()->createUrl("orders/view", array("id"=>$data->order_id))',
                                'imageUrl'=>Yii::app()->baseUrl.'/css/view.png',
                            ),
                            'copy' => array(
                                'label'=>'Копировать',
                                'url'=>'Yii::app()->createUrl("orders/copy", array("id"=>$data->order_id))',
                                'imageUrl'=>Yii::app()->baseUrl.'/css/copy.png',
                                'options'=>array(
                                    'confirm'=>'Копировать этот документ ?',
                                ),
                            ),
                        ),
                    ),
                ),
            ));
            ?>

        <br>
            <div class="section-header">Исполненные</div>
            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'orders-grid3',
                'dataProvider'=>$model->search(3),
                'afterAjaxUpdate' => 'reinstallDatePicker',
                'summaryText' => "Документы {start} - {end} из {count}",
                'columns'=>array(
                    array(
                        'name'=>'order_id',
                        'htmlOptions'=>array('width'=>'40px'),
                    ),
                    array(
                        'type'=>'raw',
                        'name'=>'order_header',
                    ),
                    array(
                        'name'=>'order_date',
                        'header'=>'Создан',
                        'value'=>'$data->traces[0]->trace_date',
                    ),
                    array(
                        'name'=>'order_date_to',
                        'header'=>'Выполнить до',
                        'value'=>'$data->traces[0]->trace_date_to',
                    ),
                    array(
                        'name' => 'order_type',
                        'filter' => CHtml::listData(Category::model()->findAll(), 'category_id', 'category_type'),
                        'value' => '$data->category->category_type',
                        'htmlOptions'=>array('width'=>'150px'),
                    ),
                    array(
                        'class'=>'CButtonColumn',
                        'htmlOptions'=>array('width'=>'40px','style'=>'white-space: pre; padding-left: 15px;'),
                        'template'=>'{about}  {copy}',
                        'buttons' => array(
                            'about' => array(
                                'label'=>'Просмотр',
                                'url'=>'Yii::app()->createUrl("orders/view", array("id"=>$data->order_id))',
                                'imageUrl'=>Yii::app()->baseUrl.'/css/view.png',
                            ),
                            'copy' => array(
                                'label'=>'Копировать',
                                'url'=>'Yii::app()->createUrl("orders/copy", array("id"=>$data->order_id))',
                                'imageUrl'=>Yii::app()->baseUrl.'/css/copy.png',
                                'options'=>array(
                                    'confirm'=>'Копировать этот документ ?',
                                ),
                            ),
                        ),
                    ),
                ),
            ));
            ?>

    </section>
    <section id="content1">

        <div class="wide form">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'action'=>Yii::app()->createUrl($this->route),
                'method'=>'get',
            )); ?>

            <div class="row" >
                <?php echo $form->label($model,'order_id'); ?>
                <?php echo $form->textField($model,'order_id'); ?>
            </div>

            <div class="row">
                <?php echo $form->label($model,'order_header'); ?>
                <?php echo $form->textField($model,'order_header',array('size'=>50,'maxlength'=>200)); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model,'order_date'); ?>
                <?php if ($model->isNewRecord) $model->order_data_from = date('d.m.Y'); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'order_date',
                    'language' => 'ru',
                    'options' => array(
                        'dateFormat'=>'yy-mm-dd',
                    ),
                    'htmlOptions' => array(
                        'style' => 'height:20px;',
                        'id'=>'date1',
                    ),
                ));?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model,'order_date_to'); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'order_date_to',
                    'language' => 'ru',
                    'options' => array(
                        'dateFormat'=>'yy-mm-dd',
                    ),
                    'htmlOptions' => array(
                        'style' => 'height:20px;',
                        'id'=>'date2',
                    ),
                ));?>
            </div>

            <div class="row">
                <?php echo $form->label($model,'order_type'); ?>
                <?php echo $form->dropDownList($model,'order_type',
                    Category::All(),
                    array('empty' => '')
                );?>
            </div>

            <div class="row">
                <?php echo $form->label($model,'order_lstatus'); ?>
                <?php echo $form->dropDownList($model, 'order_lstatus',
                    array('empty'=>'',
                            Orders::ORDER_NEW => Orders::ORDER_NEW,
                            Orders::ORDER_IN_WORK => Orders::ORDER_IN_WORK,
                            Orders::ORDER_DONE => Orders::ORDER_DONE,
                            Orders::ORDER_OLD => Orders::ORDER_OLD)); ?>
            </div>

            <div class="row">
                <?php
                echo CHtml::submitButton('Найти');?>
            </div>

            <?php $this->endWidget(); ?>
        </div>

        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'orders-grid',
            'ajaxUpdate'=>false,
            'dataProvider'=>$model->search2(),
            'columns'=>array(
                'order_id',
                'order_header',
                array(
                    'header'=>'Изменение',
                    'value' => '$data->traces[0]->trace_date',
                ),
                array(
                    'header'=>'Выполнить до',
                    'value' => '$data->traces[0]->trace_date_to',
                ),
                array(
                    'name' => 'order_type',
                    'filter' => CHtml::listData(Category::model()->findAll(), 'category_id', 'category_type'),
                    'value' => '$data->category->category_type',
                ),
                array(
                    'header'=>'Статус',
                    'value' => '$data->traces[0]->trace_order_lstatus',
                ),
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{about}',
                    'buttons' => array(
                        'about' => array(
                            'label' => 'Перейти',
                            'url' => 'Yii::app()->createUrl("orders/view", array("id"=>$data->order_id))',
                            'imageUrl' => Yii::app()->baseUrl . '/css/view.png',
                        ),
                    ),
                ),
            ),
        ));
        ?>
        <!--<div id="grid-container"><?php /*$this->actionAgrid(); */?></div>-->

    </section>
    <!--<section id="content3">

    </section>-->
</div>

<?php
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $('#date1').datepicker(jQuery.extend(jQuery.datepicker.regional['ru'],{'dateFormat':'yy-mm-dd'}));
    $('#date2').datepicker(jQuery.extend(jQuery.datepicker.regional['ru'],{'dateFormat':'yy-mm-dd'}));
}
");

Yii::app()->clientScript->registerScript('search', "
/*$(document).ready(function(){
    $('.search-form').hide();
});*/

/*$('.search-button').click(function(){
	if($('.search-form').css('display') == 'none'){
        $('.search-form').show('fast');
    } else {
        $('.search-form').hide('fast');
    }
});*/
$('.search-form form').submit(function(){
	$('#orders-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
});
");
?>