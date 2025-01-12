<?php
/*
 *	This is the archive page for the top sections with a list style.
 */


//Get Knowledge Base object
$bpkb_knowledge_base = basepress_kb();
$bpkb_is_single_kb = basepress_is_single_kb();
$bpkb_sidebar_position = basepress_sidebar_position(true);
$bpkb_show_sidebar = is_active_sidebar('basepress-sidebar') && $bpkb_sidebar_position != 'none';
$bpkb_content_classes = $bpkb_show_sidebar ? ' show-sidebar' : '';

//Get active theme header
basepress_get_header('basepress');
?>

<!-- Main BasePress wrap -->
<div class="bpress-wrap">

    <div class="bpress-page-header">
        <div class="bpress-content-wrap">
            <!-- Knowledge Base title -->
            <header>
                <h1><?php echo apply_filters('basepress_modern_theme_header_title', 'Knowledge Base'); ?><br>
                    <?php echo ($bpkb_is_single_kb ? '' : $bpkb_knowledge_base->name); ?>
                </h1>
                <p><?php echo $bpkb_knowledge_base->description; ?></p>
            </header>

            <!-- Add searchbar -->
            <div class="bpress-searchbar-wrap">
                <?php basepress_searchbar(); ?>
            </div>
        </div>
    </div>

    <!-- Add breadcrumbs -->
    <div class="bpress-crumbs-wrap">
        <div class="bpress-content-wrap">
            <?php basepress_breadcrumbs(); ?>
        </div>
    </div>

    <div class="bpress-content-wrap">
        <div class="bpress-content-area bpress-float-<?php echo $bpkb_sidebar_position . $bpkb_content_classes; ?>">

            <!-- Add main content -->
            <main class="bpress-main" role="main">
                <?php basepress_get_template_part('sections-content'); ?>
            </main>

        </div><!-- content area -->

        <!-- Sidebar -->
        <?php if ($bpkb_show_sidebar) : ?>
        <aside class="bpress-sidebar bpress-float-<?php echo $bpkb_sidebar_position; ?>" role="complementary">
            <div class="hide-scrollbars">
                <?php dynamic_sidebar('basepress-sidebar'); ?>
            </div>
            <br />
            <div class="hide-scrollbars">
                <section class="widget">
                    <h3 class="widget-title">Need Support?</h3>
                    <p>Can't find the answer you're looking for? Don't worry we're here to help!</p>
                    <a class="btn btn-primary button primary-button large full mi-button"
                        href="<?php echo site_url('/support/place-a-service-call'); ?>">Contact Support</a>
                </section>
            </div>
        </aside>
        <?php endif; ?>

    </div>
</div><!-- wrap -->
<?php basepress_get_footer('basepress'); ?>
