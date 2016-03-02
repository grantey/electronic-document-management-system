<?php
$dataProvider = $model->search2();
$dataProvider->pagination->route = 'agrid';

$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'orders-grid',
    //'ajaxUpdate'=>false,
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

if(!yii::app()->request->isAjaxRequest) {
    yii::app()->clientScript->registerScript('grid-first-load', '
          $("#orders-grid").children(".keys").attr("title", "'.$this->createUrl($dataProvider->pagination->route).'");
      ');
}
