<?php
/**
 * Created by PhpStorm.
 * User: JoshuaSzuslik
 * Date: 6/11/16
 * Time: 11:52 PM
 */
?>
<div class="premium">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <h2>Top Secret Missions</h2>
            </div>
            <?php
                $args = array(
                    'post_type' => 'product',
                    'product_cat' => 'top-secret',
                    'posts_per_page' => 4,
                    'order' => 'ASC'
                );
                $product_loop = new WP_Query($args);
                if($product_loop->have_posts()):
                    while($product_loop->have_posts()) : $product_loop->the_post();
                        global $product;
            ?>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="panel">
                    <div class="panel-body premium-panel">
                        <div class="premium_image_wrapper">
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
            <?php
                endwhile;
                endif;
                wp_reset_query();
            ?>
        </div>
    </div>
</div>
