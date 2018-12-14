<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>

<article class="media well container" style="margin: 100px auto;">

    <header class="media-body">
        <!--
<h2 class="media-heading">
            <?php _e('Nothing found', 'dikka'); ?>
        </h2>
-->
		<div class="notfoundimg"></div>
    </header>

    <div class="clearfix"></div>
    <br />

    <section>
        <?php _e('Ops! there is nothing here...', 'dikka'); ?>
        
        <?php get_search_form(TRUE); ?>
    </section>

    <div class="clearfix"></div>
    <br />

    <a class="btn-color btn-color-1d nav-to tp-button red-fill" href="<?php echo get_site_url(); ?>" title="<?php _e('Home', 'dikka'); ?>"><?php _e('Take me home', 'dikka'); ?></a>

</article>