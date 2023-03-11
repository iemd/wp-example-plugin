<?php
/*
Plugin Name: Grocery Shop
Plugin URI: https://github.com/iemd/wp-example-plugin
Description: Create a Grocery Store to display product information
Version: 1.0
Author: Omprakash Thakur
Author URI: https://github.com/iemd
License: GPLv2
*/

/* Copyright 2023 Omprakash Thakur (email : iewd1285@gmail.com)

   This program is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation; either version 2 of the License, or
   (at your option) any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with this program; if not, write to the Free Software
   Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/

/**
 * DEFAULT PLUGIN SETTINGS
 */
// Call function when plugin is activated
register_activation_hook( __FILE__, 'grocery_shop_install' );

function grocery_shop_install() {

    //setup default option values
    $gcery_options_arr = array(
        'currency_sign' => '$'
    );

    //save our default option values
    update_option( 'grocery_options', $gcery_options_arr );
}

/**
 * REGISTERING THE CUSTOM POST TYPE FOR PRODUCTS
 */
// Action hook to initialize the plugin
add_action( 'init', 'grocery_shop_init' );

// Initialize the Grocery Shop
function grocery_shop_init() {

    //register the products custom post type
    $labels = array(
        'name'                  => __( 'Products', 'grocery-plugin' ),
        'singular_name'         => __( 'Product', 'grocery-plugin' ),
        'add_new'               => __( 'Add New', 'grocery-plugin' ),
        'add_new_item'          => __( 'Add New Product', 'grocery-plugin' ),
        'edit_item'             => __( 'Edit Product', 'grocery-plugin' ),
        'new_item'              => __( 'New Product', 'grocery-plugin' ),
        'all_items'             => __( 'All Products', 'grocery-plugin' ),
        'view_item'             => __( 'View Product', 'grocery-plugin' ),
        'search_items'          => __( 'Search Products', 'grocery-plugin' ),
        'not_found'             => __( 'No products found', 'grocery-plugin' ),
        'not_found_in_trash'    => __( 'No products found in Trash', 'grocery-plugin' ),
        'menu_name'             => __( 'Products', 'grocery-plugin' )
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => true,
        'rewrite'               => true,
        'capability_type'       => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => null,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt' )
    );

    register_post_type( 'grocery-products', $args );
}

/**
 * CREATING THE SETTINGS PAGE
 */
// Action hook to add the post products menu item
add_action( 'admin_menu', 'grocery_shop_menu' );

// Create the Grocery Masks sub-menu
function grocery_shop_menu() {

    add_options_page(
        __( 'Grocery Shop Settings Page', 'grocery-plugin' ),
        __( 'Grocery Shop Settings', 'grocery-plugin' ),
        'manage_options',
        'grocery-shop-settings',
        'grocery_shop_settings_page' 
    );

}

// Build the plugin settings page
function grocery_shop_settings_page() {

    //load the plugun options array
    $gcery_options_arr = get_option( 'grocery_options' );

    //set the option array values to variables
    $gs_inventory = ( !empty( $gcery_options_arr['show_inventory'] ) ) ? $gcery_options_arr['show_inventory'] : '';
    $gs_currency_sign = $gcery_options_arr['currency_sign'];
    ?>
    <div class="wrap">
        <h2><?php _e( 'Grocery Shop Options', 'grocery-plugin' ) ?></h2>
        <form method="post" action="options.php">
            <?php settings_fields( 'grocery-settings-group' ); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php _e( 'Show Product Inventory', 'grocery-plugin' ) ?></th>
                    <td><input type="checkbox" name="grocery_options[show_inventory]" <?php echo checked( $gs_inventory, 'on' ); ?> /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e( 'Currency Sign', 'grocery-plugin' ) ?></th>
                    <td><input type="text" name="grocery_options[currency_sign]" value="<?php echo esc_attr( $gs_currency_sign ); ?>" size="1" maxlength="1" /></td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'grocery-plugin' ); ?>" />
            </p>
        </form>
    </div>
<?php  
}

// Action hook to register the plugin option settings
add_action( 'admin_init', 'grocery_shop_register_settings' );

function grocery_shop_register_settings() {

    //register the array of settings
    register_setting( 'grocery-settings-group', 'grocery_options', 'grocery_sanitize_options' );

}

function grocery_sanitize_options( $options ) {

    $options['show_inventory'] = ( !empty( $options['show_inventory'] ) ) ? sanitize_text_field( $options['show_inventory'] ) : '';
    $options['currency_sign'] = ( !empty( $options['currency_sign'] ) ) ? sanitize_text_field( $options['currency_sign'] ) : '';

    return $options;
}
