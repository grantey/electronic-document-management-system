<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

?>

<div style="text-align: center">
<h1><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>



<p><h2>
    <?php
    if (!Yii::app()->user->isGuest) echo CHtml::encode(Yii::app()->user->title);
    else echo 'Гость';
    ?>, добро пожаловать !
</h2></p>

<img src="images/main1.jpg" style="margin-bottom: 30px;">


<p>Вы находитесь на главной странице системы электронного документооборота, дипломного проекта студента гр. ПМ-51 Бакулина А.В.</p>

</div>
<?php

if (Yii::app()->session['alert']) {

    $list = Orders::model()->alertsearch()->getData();
    if ($list != null) {

        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'alert',
            'options' => array(
                'title' => 'Предупреждение',
                'autoOpen' => true,
                'modal' => true,
                'width' => 'auto',
                'height' => 'auto',
                'resizable' => 'false',
            ),
        ));

        echo '<p style="margin: 10px 0 0 0;">Необходимо обработать следующие документы:</p>';

        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => Orders::model()->alertsearch(),
            'template' => '{items}{pager}',
            'htmlOptions' => array('style' => 'cursor: pointer;'),
            //'rowCssClassExpression'=>'grid-alert',
            'columns' => array(
                array(
                    'header' => 'Тема',
                    'value' => '$data->order_header',
                ),
                array(
                    'header' => 'Отправитель',
                    'value' => '($val = Users::model()->findByPk($data->traces[0]->trace_user_from)->user_full_name) == null ? "новый документ" : $val',
                ),
                array(
                    'header' => 'Выполнить до',
                    'value' => '$data->traces[0]->trace_date_to',
                ),
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{about}',
                    'buttons' => array(
                        'about' => array(
                            'label' => 'Перейти',
                            'url' => 'Yii::app()->createUrl("orders/view", array("id"=>$data->order_id))',
                            'imageUrl' => Yii::app()->baseUrl . '/css/go.png',
                        ),
                    ),
                ),
            ),
        ));
        ?>

        <div style="text-align: center;">
            <?php echo CHtml::button('К списку', array('class' => 'btn', 'submit' => array('orders/index'))); ?>
            <?php echo CHtml::button('Закрыть', array('class' => 'btn', 'onclick' => '$("#alert").dialog("close"); return false;')); ?>
        </div>

        <?php
        $this->endWidget('zii.widgets.jui.CJuiDialog');
    }
    unset(Yii::app()->session['alert']);
}

?>