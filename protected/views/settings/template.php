<?php
$this->menu=array(
    array('label'=>'Настройки', 'url'=>array('view')),
);
Yii::app()->clientScript->registerScript('add-user-toggle', "
$('.user-button').click(function(){
    if ($('.create-form').is(':visible')) $('.create-form').slideToggle();
	$('.user-form').slideToggle();
	return false;
});
$('.create-button').click(function(){
    if ($('.user-form').is(':visible')) $('.user-form').slideToggle();
	$('.create-form').slideToggle();
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
?>

<div class="headline">
    <h1>Шаблоны получателей</h1>
</div>

    <div class="wide form">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
        )); ?>

        <div><b>Выберите шаблон:</b></div>

        <div>

            <?php echo $form->dropDownList($model,'template_id',
                Templates::All(),
                array('empty' => '')
            );?>
        </div>

        <div>
            <?php echo CHtml::submitButton('Показать', array('class'=>'btn'));?>
        </div>

        <?php $this->endWidget(); ?>
    </div>

    <?
    $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'users-grid',
        'dataProvider'=>$model->search(),
        'htmlOptions'=>array('style'=>'cursor: pointer;'),
        'summaryText' => '',
        'selectableRows'=>1,
        'columns'=>array(
            'user_id',
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
                        'url'=>'Yii::app()->createUrl("settings/Udelete", array("tid"=>'.$model->template_id.', "uid"=>$data->user_id))',
                        'imageUrl'=>Yii::app()->baseUrl.'/css/delete.png',
                    ),
                ),
            ),
        )
    ));

    echo CHtml::button('Создать шаблон', array('class'=>'create-button btn'));
    echo CHtml::button('Удалить шаблон', array(
        'class'=>'btn',
        'submit' => array('settings/alldelete', 'tid'=>$model->template_id),
        'confirm'=>'Полностью удалить шаблон ?'
    ));
    echo CHtml::button('Получатели', array('class'=>'user-button btn'));
?>
<!-- ----------------Пользователи----------------- -->
<div class="user-form" style="display:none; clear:both;">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'method'=>'post',
    )); ?>

<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'users-grid',
    'dataProvider'=>Users::model()->search(),
    'htmlOptions'=>array('style'=>'cursor: pointer;'),
    //'filter'=>Users::model(),
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
                    'imageUrl'=>Yii::app()->baseUrl.'/css/user.png',
                    'click'=>$userView,
                ),
            ),
        ),
    )
));
?>

<div class="row buttons">
    <?php echo CHtml::submitButton('Добавить', array('name'=>'addChecked'));?>
</div>


<?php $this->endWidget(); ?>

</div>
<!-- --------------Конец пользователей--------------- -->
<!-- --------------------Создать--------------------- -->
<div class="create-form form" style="display:none; margin-top: 20px;">

<?php $form=$this->beginWidget('CActiveForm', array('method'=>'post')); ?>

    <div><b>Название шаблона:</b></div>
    <div><input type="text" name="title"/></div>
    <div>
        <?php echo CHtml::button('Создать', array('submit' => array('create')));?>
    </div>

<?php $this->endWidget();?>

</div>
<!-- --------------Конец создать---------------- -->