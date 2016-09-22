<?php
$questions = get_post_meta($post->ID,'questions',true);
$x = 1;
foreach($questions as $question){
?>
<div class="panel-group">
    <div class="panel panel-default">
        <div class="panel-heading collapsed faq" data-toggle="collapse" href="#collapse<?php echo $x; ?>">
            <div class="square">
                <span class="plus"><i class="fa fa-plus-square"></i></span>
                <span class="minus"><i class="fa fa-minus-square"></i></span>
            </div>
            <h4 class="faq-question"><?php echo $question['question']; ?></h4>
        </div>
        <div id="collapse<?php echo $x; ?>" class="panel-collapse collapse">
            <div class="panel-body"><p><strong><?php echo $question['answer']; ?></strong></p></div>
        </div>
    </div>
</div>
<?php $x++; } ?>

