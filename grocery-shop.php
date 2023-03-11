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
