<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="span-19">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<div class="span-5 last">
	<div id="sidebar">
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title'=>'Действия',
        ));
        $this->widget('zii.widgets.CMenu', array(
            'items'=>$this->menu,
            'htmlOptions'=>array('class'=>'operations'),
        ));
        $this->endWidget();
        ?>
    </div><!-- sidebar -->

    <div id="scrollup"><img alt="Прокрутить вверх" src="/images/up.png"></div>
</div>
<?php $this->endContent(); ?>

<script>
    jQuery( document ).ready(function() {
        jQuery('#scrollup').mouseover( function(){
            jQuery( this ).animate({opacity: 0.65},100);
        }).mouseout( function(){
            jQuery( this ).animate({opacity: 1},100);
        }).click( function(){
            window.scroll(0 ,0);
            return false;
        });

        jQuery(window).scroll(function(){
            if ( jQuery(document).scrollTop() > 0 ) {
                jQuery('#scrollup').fadeIn('fast');
            } else {
                jQuery('#scrollup').fadeOut('fast');
            }
        });
    });
</script>