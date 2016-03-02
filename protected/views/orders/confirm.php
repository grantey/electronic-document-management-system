<?php switch ($success) {
    case 1: echo '<h4>Документ успешно отправлен в работу !</h4>';
            break;
    case 0: echo '<h4>Документ уже был отправлен указанным адресатам !</h4>
                    <p>Для повторной отправки создайте свою копию документа.</p>';
            break;
    case 3: echo '<h4>Удалить можно только новый документ !</h4>';
            break;
}
?>

<div>
    <?php echo CHtml::button('К документу', array('class'=>'btn', 'submit' => array('orders/view', 'id'=>$id))); ?>
    <?php echo CHtml::button('К списку', array('class'=>'btn', 'submit' => array('orders/index'))); ?>
</div>


