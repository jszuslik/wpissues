<?php if ( is_active_sidebar( 'shop-sidebar' )  ) : ?>
    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <aside id="secondary" class="sidebar widget-area" role="complementary">
                    <?php dynamic_sidebar( 'shop-sidebar' ); ?>
                </aside><!-- .sidebar .widget-area -->
            </div>
        </div>
    </div>
    </div></div>
<?php endif; ?>