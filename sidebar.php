<?php if ( is_active_sidebar( 'sidebar-1' )  ) : ?>
    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
        <aside id="secondary" class="sidebar widget-area" role="complementary">
            <?php dynamic_sidebar( 'sidebar-1' ); ?>
        </aside><!-- .sidebar .widget-area -->
    </div>
<?php endif; ?>