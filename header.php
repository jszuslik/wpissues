<?php
/**
 * Header Template
 */

?>
<?php
$options = get_option('wpi_settings');
// echo '<pre>'; var_dump($options); echo '</pre>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php endif; ?>
    <title><?php wp_title(''); ?></title>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php wp_head(); ?>
</head>
<body <?php body_class(isset($class) ? $class : ''); ?>>
<div class="desktop_only top_nav">
    <div class="container">
        <ul class="contact-menu left">
            <li class="contact-menu-item">
                <?php
                    $ph_number_unsan = $options['wpi_phone_number'];
                    $ph_number_print = preg_replace('#\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})#', '(\1) \2-\3', $ph_number_unsan);
                    $ph_number_link = preg_replace('#\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})#', '\1\2\3', $ph_number_unsan);
                ?>
                <a href="tel:+1<?php echo $ph_number_link; ?>">
                    <i class="fa fa-phone"></i> <span><?php echo $ph_number_print; ?></span>
                </a>
            </li>
            <li class="contact-menu-item">
                <?php
                    $email = $options['wpi_email_field'];
                ?>
                <a href="mailto:<?php echo $email; ?>">
                    <i class="fa fa-envelope"></i> <span><?php echo $email; ?></span>
                </a>
            </li>
        </ul>
        <ul class="social-list right">
            <li class="wpi_login">
                <?php if(!is_user_logged_in()){ ?>
                    <a href="/my-account/">Login</a>
                <?php } else { ?>
                    <a href="/my-account/customer-logout">Logout</a>
                <?php } ?>
            </li>
            <?php if(is_user_logged_in()){ ?>
            <li class="wpi_login">
                <a href="/my-account/">My Account</a>
            </li>
            <?php } ?>
            <li class="social-item sc">
                <?php $cart_count = WC()->cart->get_cart_contents_count(); ?>
                <?php // echo '<pre>'; var_dump($cart_count); echo '</pre>'; ?>
                <a href="<?php echo WC()->cart->get_cart_url(); ?>" target="_blank">
                    <span class="social-help shopping-cart">
                        <i class="fa fa-shopping-cart"></i> <?php if($cart_count > 0){ echo '<span class="cart_count">'.$cart_count.'</span>'; } ?>
                    </span>
                </a>
            </li>
            <li class="social-item fb">
                <a href="<?php echo $options['wpi_facebook_link']; ?>" target="_blank">
                    <span class="social-help social-facebook">
                        <i class="fa fa-facebook"></i>
                    </span>
                </a>
            </li>
            <li class="social-item tw">
                <a href="<?php echo $options['wpi_twitter_link']; ?>" target="_blank">
                    <span class="social-help social-twitter">
                        <i class="fa fa-twitter"></i>
                    </span>
                </a>
            </li>
        </ul>
    </div>
</div>
<header>
    <div class="navbar navbar-issues">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/"><h1><span>WP</span>-ISSUES.COM</h1></a>
            </div>

            <?php
            if(!is_user_logged_in()) {
                wp_nav_menu(array(
                        'menu' => 'primary',
                        'theme_location' => 'primary',
                        'depth' => 2,
                        'container' => 'div',
                        'container_class' => 'navbar-collapse collapse navbar-responsive-collapse',
                        'container_id' => 'mobile-collapse',
                        'menu_class' => 'nav navbar-nav navbar-right',
                        'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
                        'walker' => new wp_bootstrap_navwalker())
                );
            } else {
                wp_nav_menu(array(
                        'menu' => 'loggedin',
                        'theme_location' => 'loggedin',
                        'depth' => 2,
                        'container' => 'div',
                        'container_class' => 'navbar-collapse collapse navbar-responsive-collapse',
                        'container_id' => 'mobile-collapse',
                        'menu_class' => 'nav navbar-nav navbar-right',
                        'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
                        'walker' => new wp_bootstrap_navwalker())
                );
            }
            ?>
        </div>
    </div>
</header>