<h2>Отчет исполнителя</h2>

<?php

$this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'cssFile'=>Yii::app()->baseUrl.'/css/detail.css',
    'attributes'=>array(
        'app_text',
        array(
            'label'=>'Заключение',
            'type'=>'raw',
            'value'=>$model->appResolution->resolution_type,
        ),
        array(
            'label'=>'Исполнено',
            'type'=>'raw',
            'value'=>is_null($model->app_date) ? 'не задано' : $model->app_date,
        ),
    ),
));