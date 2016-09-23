<div class="row">
    <?php $image_url = get_post_meta( get_the_ID(), 'wpi_works_image_2', true ); ?>
    <div class="col-xs-12 col-sm-12 col-md-4 col-md-push-8 col-lg-4 col-lg-push-8">
        <?php wpi_switch_img_url_to_data_string($image_url, 'full', '100% Satisfaction Guarantee'); ?>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-8 col-md-pull-4 col-lg-8 col-lg-pull-4">
        <?php the_content(); ?>
    </div>
</div>