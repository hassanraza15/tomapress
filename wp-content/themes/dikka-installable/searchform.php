<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} get_header(); ?>

<form class="form-search" method="post" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <input type="search"  name="s" id="s" placeholder="<?php _e('Search', 'dikka'); ?>" />
         <button id="searchsubmit" type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
  
</form>