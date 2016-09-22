<?php
$args = array(
    'post_type' => 'post',
    'category_name' => 'news',
    'posts_per_page'			=> 3,
    'no_found_rows' 			=> true,
    'update_post_meta_cache' 		=> false
);
$loop = new WP_Query($args);

if($loop->have_posts()):
    ?>
    <div class="desktop_only top-news">
        <div class="container">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">
                <p class="news-header">Latest News</p>
                <ul class="latest-news-list">
                    <?php while($loop->have_posts()) : $loop->the_post(); ?>
                        <li class="news-item">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="mobile_only mobile-news">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <table class="table">
                        <tbody>
                        <?php while($loop->have_posts()) : $loop->the_post(); ?>
                            <tr>
                                <td><a href="<?php the_permalink(); ?>"><span class="mobile_news_item"><?php the_title(); ?></span></a></td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php endif; wp_reset_query(); ?>