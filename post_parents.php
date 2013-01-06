<?php
/*
Plugin Name: Post Parents
Plugin URI: http://mtekk.us/code/
Description: Adds a metabox that allows you to set a page as the parent of a post
Version: 0.2.0
Author: John Havlik
Author URI: http://mtekk.us/
License: GPL2
TextDomain: mtekk-post-parents
DomainPath: /languages/

*/
/*  Copyright 2012-2013  John Havlik  (email : mtekkmonkey@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
/**
 * The plugin class 
 */
class mtekk_post_parents
{
	protected $version = '0.2.0';
	protected $full_name = 'Post Parents';
	protected $short_name = 'Post Parents';
	protected $access_level = 'manage_options';
	protected $identifier = 'mtekk_post_parents';
	protected $unique_prefix = 'mpp';
	protected $plugin_basename = 'post-parents/post_parents.php';
	/**
	 * mlba_video
	 * 
	 * Class default constructor
	 */
	function __construct()
	{
		//We set the plugin basename here, could manually set it, but this is for demonstration purposes
		$this->plugin_basename = plugin_basename(__FILE__);
		add_action('add_meta_boxes', array($this, 'meta_boxes'));
	}
	/**
	 * Function that fires on the add_meta_boxes action
	 */
	function meta_boxes()
	{
		global $wp_post_types, $wp_taxonomies;
		//Loop through all of the post types in the array
		foreach($wp_post_types as $post_type)
		{
			if($post_type->name != 'page')
			{
				//Add our post parent metabox
				add_meta_box('postparentdiv', __('Parent', 'mtekk-post-parents'), array($this,'parent_meta_box'), $post_type->name, 'side', 'default');
			}
		}
	}
	/**
	 * This function outputs the post parent metabox
	 * 
	 * @param WP_Post $post The post object for the post being edited
	 */
	function parent_meta_box($post)
	{
		//If we use the parent_id we can sneak in with WP's styling and post save routines
		wp_dropdown_pages(array(
			'name' => 'parent_id',
			'id' => 'parent_id',
			'echo' => 1,
			'show_option_none' => __( '&mdash; Select &mdash;' ),
			'option_none_value' => '0',
			'selected' => $post->post_parent)
		);
	}
}
$mtekk_post_parents = new mtekk_post_parents();