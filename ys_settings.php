<?php
/**
 * Created by PhpStorm.
 * User: Alexis
 * Date: 25/11/2015
 * Time: 17:14
 */
function your_sign_admin_actions() {
    global $your_sign_admin_actions;

    $your_sign_admin_actions = add_options_page(
        'Your Signature',
        'Your Signature',
        'manage_options',
        __FILE__,
        'ys_show_admin_actions'
    );
    add_action( 'admin_print_styles-' . $your_sign_admin_actions, 'ys_admin_scripts' );
}
add_action( 'admin_menu', 'your_sign_admin_actions' );

/**
 * Enqueue wp color picker script.
 */
function ys_admin_scripts() {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'myplugin-script', plugins_url('js/script.js', dirname(__FILE__)), array('wp-color-picker'), false, true );

}




/**
 * plugin settings.
 */
add_action( 'admin_init', 'ys_plugin_options' );
function ys_plugin_options() {
    // If the theme options don't exist, create them.
    if( false == get_option( 'ys_settings_display' ) ) {
        add_option( 'ys_settings_display' );
    }


    // Add Display Settings section
   add_settings_section(
        'ys_colors_settings',
        __( '', 'your_sign' ),
        'ys_color_settings_callback',
        'ys_settings_display'
    );


    add_settings_field(
        'show_in_posts',
        __( 'Color Selector', 'your_sign' ),
        'ys_colorpicker_callback',
        'ys_settings_display',
        'ys_colors_settings',
        array(
            'profile_current',
            array(
                '_background'	=> __( 'Background', 'your_sign' ),
                '_border'		=> __( 'Border', 'your_sign' ),
                '_color'		=> __( 'Color', 'your_sign' )
            )
        )
    );

  register_setting(
      'ys_settings_display',
      'ys_settings_display'
    );
}




/**
 *color settings callback
 */
function ys_color_settings_callback() {
}

/**
 * Color parameters in admin settings page
 */
function ys_colorpicker_callback( $args ) {
    $options = ys_display_settings();
    $background = $args[0] . '_background';
    $border = $args[0] . '_border_color';
    $color = $args[0] . '_color';
    foreach( $args[1] as $key => $value ) {
        $field = $args[0] . $key; ?>

        <span>
            <input id="show_in_posts" name="ys_settings_display[show_in_posts]" type="hidden" value="below"/>
            <input type="text" id="<?php echo $field; ?>" name="ys_settings_display[<?php echo $field; ?>]" class="your_sign-color-input"  value="<?php echo $options[$field]; ?>" />
			<span class="description"><?php echo $value; ?></span>
            <a href="#" id="<?php echo $field; ?>" class="color-field"</a>
		</span><br />
    <?php }

    //echo var_dump($options);
}




/**
 * Display admin settings page
 */
function ys_show_admin_actions() { ?>
    <div class="wrap">
        <div id="icon-users" class="icon32"></div>
        <h2>Your Signature</h2>
    </div>

    <?php settings_errors(); ?>

    <?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'display_settings'; ?>

    <div id="poststuff">
        <div id="post-body" class="columns-2">
            <div id="post-body-content">
                <form method="post" action="options.php">
                    <?php
                    settings_fields( 'ys_settings_display' );
                    do_settings_sections( 'ys_settings_display' );
                    echo '<a id="your_sign-reset-colors" href="#" style="margin:15px 0 0 230px;display:inline-block">' . __( 'Reset all color settings', 'your_sign' ) . '</a>';
                    submit_button();
                    ?>
                </form>
            </div>


        </div>
    </div>
<?php }