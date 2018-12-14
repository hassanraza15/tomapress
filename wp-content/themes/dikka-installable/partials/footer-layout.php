<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>
<?php  global $dikka_options; ?>

<?php if(isset($dikka_options['footer-layout'])): ?>
       <div class="row">
                    


                     <?php if(esc_attr($dikka_options['footer-layout'])=='1'): ?>
                            <div class="col-sm-12">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('dikka-widgets-footer-block-1')) : ?>
                                    <?php //_e ('add widgets here', 'dikka'); ?>
                                <?php endif; ?>  
                            </div>
                     <?php endif; ?>

                     <?php if(esc_attr($dikka_options['footer-layout'])=='2'): ?>
                            <div class="col-sm-6">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('dikka-widgets-footer-block-1')) : ?>
                                    <?php //_e ('add widgets here', 'dikka'); ?>
                                <?php endif; ?>  
                            </div>

                            <div class="col-sm-6">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('dikka-widgets-footer-block-2')) : ?>
                                    <?php //_e ('add widgets here', 'dikka'); ?>
                                <?php endif; ?>
                            </div>
                     <?php endif; ?>

                    <?php if(esc_attr($dikka_options['footer-layout'])=='3'): ?>
                            <div class="col-sm-8">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('dikka-widgets-footer-block-1')) : ?>
                                    <?php //_e ('add widgets here', 'dikka'); ?>
                                <?php endif; ?>  
                            </div>

                            <div class="col-sm-4">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('dikka-widgets-footer-block-2')) : ?>
                                    <?php //_e ('add widgets here', 'dikka'); ?>
                                <?php endif; ?>
                            </div>
                     <?php endif; ?>

                    <?php if(esc_attr($dikka_options['footer-layout'])=='4'): ?>
                            <div class="col-sm-4">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('dikka-widgets-footer-block-1')) : ?>
                                    <?php //_e ('add widgets here', 'dikka'); ?>
                                <?php endif; ?>  
                            </div>

                            <div class="col-sm-8">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('dikka-widgets-footer-block-2')) : ?>
                                    <?php //_e ('add widgets here', 'dikka'); ?>
                                <?php endif; ?>
                            </div>
                     <?php endif; ?>

                     <?php if(esc_attr($dikka_options['footer-layout'])=='5'): ?>
                            <div class="col-sm-3">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('dikka-widgets-footer-block-1')) : ?>
                                    <?php //_e ('add widgets here', 'dikka'); ?>
                                <?php endif; ?>  
                            </div>

                            <div class="col-sm-9">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('dikka-widgets-footer-block-2')) : ?>
                                    <?php //_e ('add widgets here', 'dikka'); ?>
                                <?php endif; ?>
                            </div>
                     <?php endif; ?>


                      <?php if(esc_attr($dikka_options['footer-layout'])=='6'): ?>
                            <div class="col-sm-4">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('dikka-widgets-footer-block-1')) : ?>
                                    <?php //_e ('add widgets here', 'dikka'); ?>
                                <?php endif; ?>  
                            </div>

                            <div class="col-sm-4">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('dikka-widgets-footer-block-2')) : ?>
                                    <?php //_e ('add widgets here', 'dikka'); ?>
                                <?php endif; ?>
                            </div>

                            <div class="col-sm-4">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('dikka-widgets-footer-block-3')) : ?>
                                    <?php //_e ('add widgets here', 'dikka'); ?>
                                <?php endif; ?>
                            </div>
                     <?php endif; ?>

                     <?php if(esc_attr($dikka_options['footer-layout'])=='7'): ?>
                            <div class="col-sm-6">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('dikka-widgets-footer-block-1')) : ?>
                                    <?php //_e ('add widgets here', 'dikka'); ?>
                                <?php endif; ?>  
                            </div>

                            <div class="col-sm-3">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('dikka-widgets-footer-block-2')) : ?>
                                    <?php //_e ('add widgets here', 'dikka'); ?>
                                <?php endif; ?>
                            </div>

                            <div class="col-sm-3">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('dikka-widgets-footer-block-3')) : ?>
                                    <?php //_e ('add widgets here', 'dikka'); ?>
                                <?php endif; ?>
                            </div>
                     <?php endif; ?>

                     <?php if(esc_attr($dikka_options['footer-layout'])=='8'): ?>
                            <div class="col-sm-3">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('dikka-widgets-footer-block-1')) : ?>
                                    <?php //_e ('add widgets here', 'dikka'); ?>
                                <?php endif; ?>  
                            </div>

                            <div class="col-sm-3">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('dikka-widgets-footer-block-2')) : ?>
                                    <?php //_e ('add widgets here', 'dikka'); ?>
                                <?php endif; ?>
                            </div>

                            <div class="col-sm-6">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('dikka-widgets-footer-block-3')) : ?>
                                    <?php //_e ('add widgets here', 'dikka'); ?>
                                <?php endif; ?>
                            </div>
                     <?php endif; ?> 

                     <?php if(esc_attr($dikka_options['footer-layout'])=='9'): ?>
                            <div class="col-sm-3">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('dikka-widgets-footer-block-1')) : ?>
                                    <?php //_e ('add widgets here', 'dikka'); ?>
                                <?php endif; ?>  
                            </div>

                            <div class="col-sm-6">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('dikka-widgets-footer-block-2')) : ?>
                                    <?php //_e ('add widgets here', 'dikka'); ?>
                                <?php endif; ?>
                            </div>

                            <div class="col-sm-3">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('dikka-widgets-footer-block-3')) : ?>
                                    <?php //_e ('add widgets here', 'dikka'); ?>
                                <?php endif; ?>
                            </div>
                    <?php endif; ?>

                    <?php if(esc_attr($dikka_options['footer-layout'])=='10'): ?>
                            <div class="col-sm-3">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('dikka-widgets-footer-block-1')) : ?>
                                    <?php //_e ('add widgets here', 'dikka'); ?>
                                <?php endif; ?>  
                            </div>

                            <div class="col-sm-3">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('dikka-widgets-footer-block-2')) : ?>
                                    <?php //_e ('add widgets here', 'dikka'); ?>
                                <?php endif; ?>
                            </div>

                            <div class="col-sm-3">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('dikka-widgets-footer-block-3')) : ?>
                                    <?php //_e ('add widgets here', 'dikka'); ?>
                                <?php endif; ?>
                            </div>

                            <div class="col-sm-3">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('dikka-widgets-footer-block-4')) : ?>
                                    <?php //_e ('add widgets here', 'dikka'); ?>
                                <?php endif; ?>
                            </div>
                    <?php endif; ?>


                </div>
<?php endif; ?>