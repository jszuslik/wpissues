<?php
/**
 * Created by PhpStorm.
 * User: JoshuaSzuslik
 * Date: 6/11/16
 * Time: 11:44 PM
 */
if (have_posts()) :

    $guarantee_title = get_post_meta( get_the_ID(), 'wpi_section_2_header', true );
    $guarantee_content = get_post_meta( get_the_ID(), 'wpi_section_2_content', true );
    $guarantee_image_url = get_post_meta( get_the_ID(), 'wpi_section_2_image', true );
?>
<div class="guarantee">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="panel">
                    <div class="panel-body">
                        <h2><?php echo $guarantee_title; ?></h2>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-4 col-md-push-8 col-lg-4 col-lg-push-8">
                                <?php wpi_switch_img_url_to_data_string($guarantee_image_url, 'full', '100% Satisfaction Guarantee'); ?>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-8 col-md-pull-4 col-lg-8 col-lg-pull-4">
                                <?php echo $guarantee_content; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
