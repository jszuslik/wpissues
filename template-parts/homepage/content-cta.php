<?php
/**
 * Created by PhpStorm.
 * User: JoshuaSzuslik
 * Date: 6/11/16
 * Time: 11:51 PM
 */
if (have_posts()) :

    $cta_message = get_post_meta( get_the_ID(), 'wpi_cta_message', true );
    $cta_link = get_post_meta( get_the_ID(), 'wpi_cta_link', true );

?>
<div class="cta">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                <h3><?php echo $cta_message; ?></h3>
            </div>
            <div class="col-xs-12 col-md-12 col-md-3 col-lg-3">
                <a href="<?php echo get_the_permalink($cta_link); ?>" class="btn btn-raised">Submit Mission Now!</a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>