        <section id="impression_area">
            <div class="container">
                <div class="row">
                    <div class="col-md-10">
                        <?php if (function_exists('get_option_tree')) : if (get_option_tree('impression_textarea')) : ?>
                        <?php get_option_tree('impression_textarea', '', 'true'); ?>
                        <br />
                        <?php echo do_shortcode('[su_youtube_advanced url="https://www.youtube.com/watch?v=_DsIdq8y98Y" loop="1" controls="alt" autohide="yes" theme="light" modestbranding="yes" wmode="transparent" playsinline="yes" title="An Introduction to Modern Impressions"]'); ?>
                        <?php else : ?>
                        <?php endif;
                        endif; ?>
                    </div>
                </div>

                <?php
                $list_item = ot_get_option('impression_list', array());
                if (!empty($list_item)) {
                    echo '<div class="row">';
                    foreach ($list_item as $type) {
                        echo '
                            <div class="col-md-3">
                                <div class="child_impression">
                                    <h2>' . $type['impression_number'] . '</h2>
                                    <h5>' . $type['impression_title'] . '</h5>
                                    <p>' . $type['impression_textarea'] . '</p>
                                </div>
                            </div>';
                    }
                    echo '</div>';
                }
                ?>
            </div>
            <!-- Homepage Testimonials area
    ================================================== -->
            <?php get_template_part('home_part/testimonials_area'); ?>

            <!-- Homepage Netpromoter Score area
    ================================================== -->
            <?php get_template_part('home_part/nps_area'); ?>
        </section>
