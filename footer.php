<?php
/**
 * Footer Template
 */
$options = get_option('wpi_settings');
?>
<div class="footer-info">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <h5 class="footer_title">Quick Links</h5>
                <?php
                    wp_nav_menu(
                        array(
                            'menu' => 'Quick Links',
                            'theme_location'    => 'quick',
                            'menu_class' => 'footer_menu',
                            'depth' => 3,
                            'container' => false,
                            'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                            'walker'            => new wp_bootstrap_navwalker()
                        )
                    );
                ?>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <h5 class="footer_title">Get In Touch</h5>
                <ul class="wpi_info">
                    <li class="wpi_phone">
                        <?php
                            $ph_number_unsan = $options['wpi_phone_number'];
                            $ph_number_print = preg_replace('#\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})#', '(\1) \2-\3', $ph_number_unsan);
                            $ph_number_link = preg_replace('#\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})#', '\1\2\3', $ph_number_unsan);
                        ?>
                        <a href="tel:+1<?php echo $ph_number_link; ?>"><span>Phone: </span><?php echo $ph_number_print; ?></a>
                    </li>
                    <li class="wpi_email">
                        <?php
                        $email = $options['wpi_email_field'];
                        ?>
                        <a href="mailto:<?php echo $email; ?>">Send Us An E-Mail</a>
                    </li>
                    <li class="wpi_location">
                        <span>Waukesha, WI</span>
                    </li>
                </ul>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <h5 class="footer_title">Ask Us A Question</h5>
                <?php echo FrmFormsController::get_form_shortcode( array( 'id' => 3, 'title' => false, 'description' => false ) ); ?>
            </div>
        </div>
    </div>
</div>

<footer>
    <div class="footer-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="copyright">
                        <p>Copyright  &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?> All Rights Reserved.</p>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="powered">
                        <p>Powered By No Rules Web</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>







<?php wp_footer(); ?>
<script async>
    jQuery.material.init();
    jQuery(document).ready(function() {
        jQuery('#jumbo-owl').owlCarousel({
            items:1
        });
    });

</script>
</body>
</html>
