<?php
$collapse_id=rand().rand();
?>
<div class="collapse-group" id="accordion">
<div class="panel">
    <div class="collapse-heading">
        <h4><a data-toggle="collapse" data-parent="#accordion" class="<?php if($instance['open']==1) { echo 'collapse'; } else { echo 'collapsed'; }?>" href="#collapse<?php echo $collapse_id; ?>"> <?php echo esc_html($instance['heading']) ?></a></h4>
    </div>
    <div id="collapse<?php echo $collapse_id; ?>" class="panel-collapse collapse <?php if($instance['open']==1) { echo 'in'; } ?>">
        <div class="collapse-body">
            <p><?php echo wp_kses_post($instance['body']) ?></p>
        </div>
    </div>
</div>
</div>

