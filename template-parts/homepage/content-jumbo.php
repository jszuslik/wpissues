<?php
$bg_img_1 = url().'/wp-content/uploads/2016/07/bd1.png';
?>
<div class="desktop_only jumbotron" style="background-image: url(<?php wpi_switch_img_url_to_data_string($bg_img_1, '', '', true); ?>)">
    <!--<div class="container">-->
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div id="jumbo-owl" class="owl-carousel">
                <?php
                    $args = array(
                        'post_type' 				=> 'wpi_slides',
                        'post_status' 				=> 'publish',
                        'posts_per_page'			=> '5',
	                    'no_found_rows' 			=> true,
	                    'update_post_meta_cache' 	=> false
                    );
                    $loop = new WP_Query($args);

                    if ($loop->have_posts()) :
                        while($loop->have_posts()) : $loop->the_post();
                            $title = get_the_title();
                            $content = get_post_meta( get_the_ID(), 'wpi_slide_content', true );
                            $tagline = get_post_meta( get_the_ID(), 'wpi_slide_tagline', true );
                            $image_url = get_post_meta( get_the_ID(), 'wpi_slide_image', true );


                            // echo '<pre>'; echo $content; echo '</pre>';
                ?>
                            <div class="item">
                                <div class="container">
                                    <div class="container-bkgd">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <p class="jumbo-header"><?php echo $title; ?></p>
                                            </div>
                                        </div>
                                        <div class="row table-row">
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <div class="agent-image-container">
                                                    <?php wpi_switch_img_url_to_data_string($image_url, 'full', 'WP Issues Agent'); ?>
                                                </div>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                                <p class="jumbo-content"><?php echo $content; ?></p>
                                                <p class="jumbo-content no-padding"><?php echo $tagline; ?></p>
                                                <?php echo wpi_email_form(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endwhile; ?>
                    <?php endif; wp_reset_query();
                ?>

            </div>
        </div>
    </div>
    <!--</div>-->
</div>