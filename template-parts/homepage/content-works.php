<?php
/**
 * Created by PhpStorm.
 * User: JoshuaSzuslik
 * Date: 6/11/16
 * Time: 11:28 PM
 */
if (have_posts()) :

    $works_title = get_post_meta( get_the_ID(), 'wpi_works_title', true );
    $works_image_1 = get_post_meta( get_the_ID(), 'wpi_works_image_1', true );
    $works_content_1 = get_post_meta( get_the_ID(), 'wpi_works_content_1', true );
    $works_link_id = get_post_meta( get_the_ID(), 'wpi_homepage_works_link', true );
    $works_image_2 = get_post_meta( get_the_ID(), 'wpi_works_image_2', true );
    $works_content_2 = get_post_meta( get_the_ID(), 'wpi_works_content_2', true );
    $works_image_3 = get_post_meta( get_the_ID(), 'wpi_works_image_3', true );
    $works_content_3 = get_post_meta( get_the_ID(), 'wpi_works_content_3', true );

?>
<div class="how-it-works">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h2 class="panel-title"><?php echo $works_title; ?></h2>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                <div class="funnel_image_wrapper">
                                    <?php wpi_switch_img_url_to_data_string($works_image_1, 'full', 'Missions'); ?>
                                </div>
                                <p class="works-content"><?php echo $works_content_1; ?></p>
                                <a href="<?php echo get_the_permalink($works_link_id); ?>" class="btn btn-raised btn-danger">Submit Mission Now!</a>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                <div class="funnel_image_wrapper">
                                    <?php wpi_switch_img_url_to_data_string($works_image_2, 'full', 'Contact'); ?>
                                </div>
                                <p class="works-content"><?php echo $works_content_2; ?></p>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                <div class="funnel_image_wrapper">
                                    <?php wpi_switch_img_url_to_data_string($works_image_3, 'full', 'Clean Code'); ?>
                                </div>
                                <p class="works-content"><?php echo $works_content_3; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>