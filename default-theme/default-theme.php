<?php
/*
Plugin Name: Default Theme
Plugin URI: 
Description:
Author: Andrew Billits
Version: 1.0.1
Author URI:
*/

/* 
Copyright 2007-2009 Incsub (http://incsub.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//

add_action('wpmu_options', 'default_theme_site_admin_options');
add_action('update_wpmu_options', 'default_theme_site_admin_options_process', 1);
add_action('wpmu_new_blog', 'default_theme_switch_theme', 1, 1);

//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

function default_theme_switch_theme($blog_ID) {
	$default_theme = get_site_option('default_theme');
	if ( !empty( $default_theme ) ) {
		switch_to_blog( $blog_ID );
		switch_theme( $default_theme, $default_theme );
		restore_current_blog();
	}
}

function default_theme_site_admin_options_process() {
	update_site_option( 'default_theme' , $_POST['default_theme']);
}

//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

function default_theme_site_admin_options() {

	$themes = get_themes();

	$default_theme = get_site_option('default_theme');
	if ( empty( $default_theme ) ) {
		$default_theme = 'default';
	}
?>
		<h3><?php _e('Theme Settings') ?></h3>
		<table class="form-table">
            <tr valign="top"> 
            <th scope="row"><?php _e('Default Theme') ?></th> 
            <td><select name="default_theme">
            <?php
				foreach( $themes as $key => $theme ) {
					$theme_key = wp_specialchars( $theme['Stylesheet'] );
                    echo '<option value="' . $theme_key . '"' . ($theme_key == $default_theme ? ' selected' : '') . '>' . $key . '</option>' . "\n";
				}
            ?>
            </select>
            <br /><?php _e('Default theme applied to new blogs.'); ?></td> 
            </tr>
		</table>
<?php
}

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

?>
