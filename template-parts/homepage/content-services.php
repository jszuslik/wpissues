<?php
/**
 * Created by PhpStorm.
 * User: JoshuaSzuslik
 * Date: 6/11/16
 * Time: 11:47 PM
 */
?>
<div class="services">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h2>Some Missions We Perform</h2>
            </div>
            <?php
                $product_args = array(
                    'post_type' => 'product',
                    'product_cat' => 'missions',
                    'posts_per_page' => 6,
                    'order' => 'ASC'
                );
                $product_loop = new WP_Query($product_args);
                if($product_loop->have_posts()):
                    while($product_loop->have_posts()) : $product_loop->the_post();
                        global $product;

                        // echo '<pre>'; var_dump($product); echo '</pre>';
            ?>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 clearfix">
                <div class="panel">
                    <div class="panel-body service-panel">
                        <div class="service_image_wrapper">
                            <?php if (has_post_thumbnail( $product->post->ID )) {
                                $thumb_url = wp_get_attachment_url( get_post_thumbnail_id($product->post->ID));
                                wpi_switch_img_url_to_data_string($thumb_url, 'full', get_the_title());
                            } else {
                                echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="300px" height="300px" />';
                            } ?>
                        </div>
                        <h3><?php the_title(); ?></h3>
                    </div>
                    <div class="panel-footer">
                        <a href="<?php echo get_permalink( $product->post->ID ) ?>" class="btn btn-raised btn-danger">Order Now</a>
                    </div>
                </div>
            </div>

            <?php endwhile; ?>
            <?php endif; wp_reset_query();
            ?>
        </div>
    </div>
</div>
