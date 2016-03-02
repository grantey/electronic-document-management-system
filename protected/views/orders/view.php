<?php
/* @var $this OrdersController */
/* @var $model Orders */

$owner_id = $model->traces[0]->trace_user_from;
$owner_name = Users::model()->findByPk($owner_id)->user_full_name;
$is_have_owner = !(is_null($owner_id));
$is_new_or_work = $model->traces[0]->trace_order_lstatus == Orders::ORDER_NEW || $model->traces[0]->trace_order_lstatus == Orders::ORDER_IN_WORK;
$is_new = $model->traces[0]->trace_order_lstatus == Orders::ORDER_NEW;

Yii::app()->clientScript->registerScript('add-user-toggle', "
$('.user-button').click(function(){
    if ($('.resolution-form').is(':visible')) $('.resolution-form').slideToggle();
    if ($('.end-form').is(':visible')) $('.end-form').slideToggle();
	$('.user-form').slideToggle();
	return false;
});
$('.app-button').click(function(){
    if ($('.user-form').is(':visible')) $('.user-form').slideToggle();
    if ($('.end-form').is(':visible')) $('.end-form').slideToggle();
	$('.resolution-form').slideToggle();
	return false;
});
$('.end-button').click(function(){
    if ($('.user-form').is(':visible')) $('.user-form').slideToggle();
    if ($('.resolution-form').is(':visible')) $('.resolution-form').slideToggle();
	$('.end-form').slideToggle();
	return false;
});
");

$userView = <<<UV
function() {
    var url = $(this).attr('href');
    $.get(url, function(r){
        $("#about").html(r).dialog("open");
    });
    return false;
}
UV;

$appView = <<<AV
function() {
    var url = $(this).attr('href');
    $.get(url, function(r){
        $("#app").html(r).dialog("open");
    });
    return false;
}
AV;
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'about',
        'options' => array(
            'title' => 'Информация',
            'autoOpen' => false,
            'modal' => true,
            'width' => 'auto',
            'height' => 'auto',
            'resizable' => 'false',
        ),
    ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');

    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'app',
        'options' => array(
            'title' => 'Информация',
            'autoOpen' => false,
            'modal' => true,
            'width' => '700px',
            'height' => 'auto',
            'resizable' => 'false',
        ),
    ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');

$this->menu=array(
	array('label'=>'Все документы', 'url'=>array('index')),
	array('label'=>'Новый документ', 'url'=>array('create')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->order_id)),
    array('label'=>'Копировать', 'url'=>array('copy', 'id'=>$model->order_id), 'linkOptions'=>array('confirm'=>'Копировать этот документ ?')),
	array('label'=>'Удалить', 'url'=>'#',
        'linkOptions'=>array('submit'=>array('delete','id'=>$model->order_id), 'confirm'=>'Удалить этот документ ?',),
        'visible'=>$is_new),
	array('label'=>'Управление', 'url'=>array('site/admin')),
);
?>

<div class="headline">
    <h1>Документ №<?php echo $model->order_id; ?></h1>
    <?php if ($model->traces[0]->trace_order_lstatus == Orders::ORDER_DONE): ?>
    <p>(будет перемещен в "Cтарые" через <?=Orders::model()->timetomove($model->order_id)?> дн.)</p>
    <? endif; if ($model->traces[0]->trace_order_lstatus == Orders::ORDER_OLD): ?>
    <p>(будет перемещен в архив через <?=Orders::model()->timetomove($model->order_id)?> дн.)</p>
    <? endif; ?>
</div>

<div class="view">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
    'cssFile'=>Yii::app()->baseUrl.'/css/detail.css',
	'attributes'=>array(
        'order_header',
		'order_text',
        array(
            'label'=>'Отправитель',
            'type'=>'raw',
            'value'=>is_null($owner_id) ? 'новый документ' : $owner_name,
        ),
        array(
            'label'=>$is_new ? 'Создан' : 'Отправлен',
            'type'=>'raw',
            'value'=>$model->traces[0]->trace_date,
        ),
        array(
            'label'=>'Выполнить до',
            'type'=>'raw',
            'value'=>$model->traces[0]->trace_date_to,
        ),
        array(
            'label'=>'Тип документа',
            'type'=>'raw',
            'value'=>$model->category->category_type,
        ),
     /*   array(
            'label'=>'Статус',
            'type'=>'raw',
            'value'=>$model->status->status_type,
        ),*/
        array(
            'label'=>'Состояние',
            'type'=>'raw',
            'value'=>$model->traces[0]->trace_order_lstatus,
        ),
	),

)); ?>
</div>


<br><br>
<h3>Прилагаемые файлы:</h3>

<table class="detail-view">
<?php
$files = $model->files;
if (count($files) == 0) echo '<tr><td>Нет</tr></td>';
else foreach ($files as $file)
{
    $folder = Yii::getPathOfAlias('application.uploads'). '\\' . $file->file_name;
    echo '<tr><td>'.CHtml::link($file->file_name,array('Download','file'=>$file->file_name,'path'=>$folder),array('target'=>'blank'));
    echo '</td></tr>';
}
    ?>
</table>

<?php if ($is_have_owner): /*если есть отправитель*/?>
<br><br>
<h3>Резолюция отправителя:</h3>

<?php
    $app_id = $this->ownerApplicationID($model->order_id, $owner_id);
    if (!isset($app_id)):?>

    <table class="detail-view">
        <tr><td>Нет</tr></td>
    </table>

<?php else: $app=Application::model()->findByPk($app_id); ?>
    <div class="view">
        <?php
         $this->widget('zii.widgets.CDetailView', array(
            'data'=>$app,
            'cssFile'=>Yii::app()->baseUrl.'/css/detail.css',
            'attributes'=>array(
                'app_text',
                array(
                    'label'=>'Заключение',
                    'type'=>'raw',
                    'value'=>$app->appResolution->resolution_type,
                ),
                array(
                    'label'=>'Выполнить до',
                    'type'=>'raw',
                    'value'=>is_null($app->app_date) ? 'не задано' : $app->app_date,
                ),
            ),
        )); ?>
    </div>
<?php endif; endif; /*конец если есть отправитель*/?>

<br><br>
<h3>Резолюция:</h3>

<?php if (!isset($model3->app_id)):?>

<table class="detail-view">
    <tr><td>Нет</tr></td>
</table>

<?php else: ?>
<div class="view">
<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model3,
    'cssFile'=>Yii::app()->baseUrl.'/css/detail.css',
    'attributes'=>array(
        'app_text',
        array(
            'label'=>'Заключение',
            'type'=>'raw',
            'value'=>$model3->appResolution->resolution_type,
        ),
        array(
            'label'=>'Выполнить до',
            'type'=>'raw',
            'value'=>is_null($model3->app_date) ? 'не задано' : $model3->app_date,
        ),
    ),
)); ?>
</div>
<?php endif; ?>


<?php if($is_new): ?>  <!-- Дальше выводим если документ новый -->
<div style="margin: 30px 0 60px 0;">

        <div style="float: left; clear: both;">
            <?php echo CHtml::button('Получатели', array('class'=>'user-button btn')); ?>
        </div>
        <div style="float: left;">
            <?php echo CHtml::button('Резолюция', array('class'=>'app-button btn')); ?>
        </div>
<?php if (!$is_have_owner): ?>
 </div>
<div style="clear: both;"></div>
<?php endif; endif; ?>


<?php if($is_have_owner && $is_new_or_work):
    if($is_new): ?>

        <div style="float: left;">
            <?php echo CHtml::button('Отчет', array('class'=>'end-button btn')); ?>
        </div>
</div>
<div style="clear: both;"></div>
    <?php else: ?>
<div style="margin: 30px 0 60px 0;">
    <div style="float: left;">
        <?php echo CHtml::button('Отчет', array('class'=>'end-button btn')); ?>
    </div>
</div>
<div style="clear: both;"></div>
    <?php endif; ?>

<!-- --------------Отчет---------------- -->
<div class="end-form form" style="display:none; ">

<div style="margin-bottom: 20px;">
    <br>Укажите заключение по работе с документом.<br>
    <b>Получатель: </b>
    <?php echo CHtml::link($owner_name, '#', array('onclick'=>'$("#owner").dialog("open"); return false;'));?>
    <br>

    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'owner',
        'options' => array(
        'title' => 'Информация о пользователе',
        'autoOpen' => false,
        'modal' => true,
        'width'=>'auto',
        'height'=>'auto',
        'resizable'=> false
        ),
    ));
        $this->widget('zii.widgets.CDetailView', array(
            'data'=>Users::model()->findByPk($owner_id),
            'attributes'=>array(
                'user_full_name',
                'user_post',
                'user_phone',
                'user_faculty',
                'user_depart',
            ),
        ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');?>
    <b>Внимание !</b> Операция не может быть отменена.
</div>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'method'=>'post',
    )); ?>

    <?php echo CHtml::errorSummary($model3); ?>

    <div class="row">
        <?php echo $form->labelEx($model3,'app_text'); ?>
        <?php echo $form->textArea($model3,'app_text',array('rows'=>4, 'cols'=>50)); ?>
        <?php echo $form->error($model3,'app_text'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model3,'app_resolution'); ?>
        <?php
        echo $form->dropDownList($model3, 'app_resolution',
            Resolution::All()
        // array('empty' => '--- Заключение ---')
        );?>
        <?php echo $form->error($model3,'app_resolution'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Отправить', array('name'=>'returnOrder', 'confirm'=>'Завершить работу с документом ?')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>
<!-- ------------Конец завершить------------ -->
<? endif; if($is_new): /*резолюцию и пользователей если не исполнен*/?>
<!-- --------------Резолюция---------------- -->
<div class="resolution-form form" style="display:none; margin-top: 20px;">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'method'=>'post',
    )); ?>

    <?php echo CHtml::errorSummary($model3); ?>

    <div class="row">
        <?php echo $form->labelEx($model3,'app_text'); ?>
        <?php echo $form->textArea($model3,'app_text',array('rows'=>4, 'cols'=>50)); ?>
        <?php echo $form->error($model3,'app_text'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model3,'app_resolution'); ?>
        <?php
        echo $form->dropDownList($model3, 'app_resolution',
            Resolution::All()
           // array('empty' => '--- Заключение ---')
        );?>
        <?php echo $form->error($model3,'app_resolution'); ?>
    </div>

    <div class="row">
        <b>Выполнить до</b><br>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'Application[app_date]',
            'model' => $model3,
            'value' => $model->traces[0]->trace_date_to,
            'language' => 'ru',
            'options' => array(
                'showAnim' => 'fold',
                'dateFormat'=>'yy-mm-dd',
            ),
            'htmlOptions' => array(
                'style' => 'height:20px;'
            ),
        ));?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить', array('name'=>'addResolution')); ?>
        <?php echo CHtml::submitButton('Удалить', array('name'=>'delResolution')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>
<!-- --------------Конец резолюции---------------- -->

<!-- ----------------Пользователи----------------- -->
<div class="user-form" style="display:none; clear:both;">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'method'=>'post',
    )); ?>

    <?php

    $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'users-grid',
        'dataProvider'=>$model2->search(),
        'htmlOptions'=>array('style'=>'cursor: pointer;'),
        'filter'=>$model2,
        'summaryText' => '',
        'selectableRows'=>2,
        'columns'=>array(
            array(
                'class'=>'CCheckBoxColumn',
                'id'=>'check-boxes',
            ),
            array(
                'name'=>'user_full_name',
                'header'=>'Ф.И.О.',
            ),
            array(
                'name'=>'user_faculty',
                'header'=>'Факультет',
            ),
            array(
                'name'=>'user_post',
                'header'=>'Должность',
            ),
            array(
                'class'=>'CButtonColumn',
                'template'=>'{about}',
                'buttons' => array(
                    'about' => array(
                        'label'=>'О пользователе',
                        'url'=>'Yii::app()->createUrl("orders/UAbout", array("id"=>$data->user_id))',
                        'imageUrl'=>Yii::app()->baseUrl.'/css/view.png',
                        'click'=>$userView,
                    ),
                ),
            ),
        )
    ));
    ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Добавить', array('name'=>'addChecked', 'style'=>'float: left'));?>

        <?php echo CHtml::submitButton('Добавить шаблон', array('name'=>'addTemplate', 'style'=>'float: right;'));?>

        <?php echo CHtml::dropDownList('Templates',$template,
            Templates::model()->getTemplates(Yii::app()->user->id),
            array('empty' => '--- Выбрать шаблон ---', 'style'=>'float: right; width: 300px; margin-right: 20px;'));?>
    </div>


    <?php $this->endWidget(); ?>

</div>
<!-- --------------Конец пользователей--------------- -->
<?php endif;  /*конец резолюцию и пользователей если не исполнен*/ ?>

<div style="clear: both;">


<?php //if(!$is_new) echo '<div style="margin-top: -30px"></div>'; /*если документ в работе и вообще нет кнопок надо сдвинуть для красоты*/?>

<div style="margin: 30px 0 -20px 0">
    <h3>Получатели:</h3>
</div>

<?
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'users-grid2',
    'dataProvider'=>$model2->search2($model->order_id),
    'htmlOptions'=>array('style'=>'cursor: pointer;'),
    'summaryText' => '',
    'selectableRows'=>2,
    'columns'=>array(
        array(
            'name'=>'user_full_name',
            'header'=>'Ф.И.О.',
        ),
        array(
            'name'=>'user_faculty',
            'header'=>'Факультет',
        ),
        array(
            'name'=>'user_post',
            'header'=>'Должность',
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{about}&nbsp;&nbsp;{delete}',
            'buttons' => array(
                'about' => array(
                    'label'=>'О пользователе',
                    'url'=>'Yii::app()->createUrl("orders/UAbout", array("id"=>$data->user_id))',
                    'imageUrl'=>Yii::app()->baseUrl.'/css/user.png',
                    'click'=>$userView,
                ),
                'delete' => array(
                    'url'=>'Yii::app()->createUrl("orders/UDelete", array("oid"=>'.$model->order_id.',"uid"=>$data->user_id))',
                    'imageUrl'=>Yii::app()->baseUrl.'/css/delete.png',
                    'visible'=>(string)$is_new,
                ),
            ),
        ),
    )
)); ?>

</div>

<?php
if (!$is_new):
    //if (!$is_not_done) echo '<br><br>';?>

<div>
    <div style="margin-bottom: -20px;">
        <h3>Отчет:</h3>
    </div>

    <?
    $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'users-grid2',
        'dataProvider'=>Trace::model()->search2($model->order_id),
        'htmlOptions'=>array('style'=>'cursor: pointer;'),
        'summaryText' => '',
        'columns'=>array(
            array(
                'header'=>'Исполнитель',
                'name'=>'traceUserTo',
                'value'=>'$data->traceUserTo->user_full_name',
            ),
            array(
                'header'=>'Статус',
                'name'=>'trace_order_lstatus',
                'value'=>'$data->trace_order_lstatus==Orders::ORDER_NEW ? "В работе" : "Исполнен"',
            ),
            array(
                'header'=>'Дата',
                'name'=>'traceApp',
                'value'=>'$data->traceApp->app_date',
            ),
            array(
                'class'=>'CButtonColumn',
                'template'=>'{about}',
                'buttons' => array(
                    'about' => array(
                        'label'=>'Отчет',
                        'url'=>'Yii::app()->createUrl("orders/app", array("id"=>$data->trace_app_id))',
                        'imageUrl'=>Yii::app()->baseUrl.'/css/go.png',
                        'click'=>$appView,
                    ),
                ),
            ),
        )
    )); ?>

</div>
<br>
<?php endif; ?>

<!-- ---- ДИАЛОГИ ДЛЯ КНОПОК --- -->
<!-- --------------------------- -->

<?php if ($is_new_or_work && !$is_have_owner):
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'move1',
    'options' => array(
        'title' => 'В исполненные',
        'autoOpen' => false,
        'modal' => true,
        'width'=>'auto',
        'height'=>'auto',
        'resizable'=> false
    ),
));

    $form=$this->beginWidget('CActiveForm', array('method'=>'post')); ?>

        <div class="input-row">
            <label for="time">Перенести в "Cтарые" через (дн.):</label>
            <input type="text" name="time" value="<?=Yii::app()->session['set_old']?>" />
        </div>

        <div class="btn-box">
            <?php echo CHtml::button('OK', array('class'=>'btn', 'submit' => array('todone', 'id'=>$model->order_id)));
            echo CHtml::button('Отмена', array('class'=>'btn', 'onclick' => '$("#move1").dialog("close")'));?>
        </div>

    <?php $this->endWidget();

$this->endWidget('zii.widgets.jui.CJuiDialog'); endif;?>

<!-- --------------------------- -->

<?php if ($model->traces[0]->trace_order_lstatus == Orders::ORDER_DONE):
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'move2',
        'options' => array(
            'title' => 'В старые',
            'autoOpen' => false,
            'modal' => true,
            'width'=>'auto',
            'height'=>'auto',
            'resizable'=> false
        ),
    ));

    $form=$this->beginWidget('CActiveForm', array('method'=>'post')); ?>

    <div class="input-row">
        <label for="time">Перенести в "Архив" через (дн.):</label>
        <input type="text" name="time" value="<?=Yii::app()->session['set_archive']?>" />
    </div>

    <div class="btn-box">
        <?php echo CHtml::button('OK', array('class'=>'btn', 'submit' => array('toold', 'id'=>$model->order_id)));
        echo CHtml::button('Отмена', array('class'=>'btn', 'onclick' => '$("#move2").dialog("close")'));?>
    </div>

    <?php $this->endWidget();

    $this->endWidget('zii.widgets.jui.CJuiDialog'); endif;?>

<!-- --------------------------- -->

<?php if ($is_new):
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'move3',
        'options' => array(
            'title' => 'Отправить',
            'autoOpen' => false,
            'modal' => true,
            'width'=>'auto',
            'height'=>'auto',
            'resizable'=> false
        ),
    ));

$form=$this->beginWidget('CActiveForm', array('method'=>'post')); ?>

    <div style="width: 380px">
        <div class="row" style="margin: 10px 0 10px 0">
            <label for="save_template" class="checkbox-row">Сохранить список адресатов в шаблон:<input type="checkbox" name="save_template" value="1" /></label>
        </div>

        <div class="row">
            <?php echo $form->error(Templates::model(),'template_title'); ?>
            <input type="text" name="template_title" placeholder="название шаблона"/>
        </div>

        <div style="margin: 20px 0 10px 0">Завершить работу с документом после ответа:</div>

        <select name="done_mode">
            <option value="0">от всех адресатов</option>
            <option value="1">от любого из адресатов</option>
        </select>

        <div class="btn-box">
            <?php echo CHtml::button('OK', array('class'=>'btn', 'submit' => array('orders/confirm', 'id'=>$model->order_id)));
            echo CHtml::button('Отмена', array('class'=>'btn', 'onclick' => '$("#move3").dialog("close")'));?>
        </div>
    </div>

<?php $this->endWidget();

    $this->endWidget('zii.widgets.jui.CJuiDialog'); endif;?>

<!-- --------------------------- -->

<div class="btn-box">
    <?php
    if ($is_new)
        echo CHtml::button('Отправить', array(
            'class'=>'btn',
            'onclick' => '$("#move3").dialog("open"); return false;',
        ));

    if ($is_new_or_work && !$is_have_owner)
        echo CHtml::button('В исполненные', array(
            'class'=>'btn',
            'onclick' => '$("#move1").dialog("open"); return false;',
        ));

    if ($model->traces[0]->trace_order_lstatus == Orders::ORDER_DONE)
        echo CHtml::button('В старые', array(
            'class'=>'btn',
            'onclick' => '$("#move2").dialog("open"); return false;',
        ));

    if ($model->traces[0]->trace_order_lstatus == Orders::ORDER_OLD)
        echo CHtml::button('В архив', array(
            'class'=>'btn',
            'submit' => array('orders/toarchive', 'id'=>$model->order_id),
            'confirm'=>'После отправки документа в архив доступ к нему будет только у администратора. Продолжить ?'
        ));

        echo CHtml::button('К списку', array(
            'class'=>'btn',
            'submit' => array('orders/index')
        ));
    ?>
</div>