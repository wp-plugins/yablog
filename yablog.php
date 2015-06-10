<?php
/*
Plugin Name: YaBlog
Plugin URI: https://wordpress.org/plugins/yablog/
Description: Allows administrators to globally disable XML-RPC, new emoji functionality in WordPress 4.2, wp generator and feeds on their site.
Version: 1.6.4
Author: Anton Paramonov
Author URI: http://paramonovav.com/
Donate link: http://blog.paramonovav.com/en/plugins/plugins-for-wordpress/
License: GPLv2 or later  
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: yablog
Domain Path: /languages
*/

if (is_admin())
{
	// create custom plugin settings menu
	add_action('admin_menu', 'yablog_create_menu');

	add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'yablog_plugin_settings_link');
}
else
{
	add_action('init', 'yablog_action_init');
}

function yablog_load_textdomain()
{
	load_plugin_textdomain('yablog', false, dirname(plugin_basename(__FILE__)) . '/languages');
}	
add_action('plugins_loaded', 'yablog_load_textdomain');

function yablog_activate()
{
	add_option('yablog_options', array(), '', 'yes');
}
register_activation_hook(__FILE__, 'yablog_activate');

function yablog_deactivation()
{
}
register_deactivation_hook(__FILE__, 'yablog_deactivation');

function yablog_plugin_settings_link($links)
{ 
  	$settings_link = '<a href="options-general.php?page=yablog_settings">'.__('Settings').'</a>';
  	array_unshift($links, $settings_link);
  	return $links;
}

function yablog_create_menu()
{
	//create new top-level menu
	add_menu_page('YaBlog '.__('Settings'), 'YaBlog', 'manage_options', 'yablog_settings', 'yablog_settings_page', plugins_url('/images/icon.png', __FILE__));
	add_submenu_page('options-general.php', 'YaBlog Plugin Settings', 'YaBlog', 'manage_options', 'yablog_settings_disabler', 'yablog_settings_page');	
	
	//add_submenu_page('yablog_settings', 'YaBlog Plugin Settings', 'YaBlog', 'manage_options', 'yablog_settings_disabler', 'yablog_settings_page');	

	//call register settings function
	add_action('admin_init', 'yablog_register_settings');
}

function yablog_register_settings()
{
	//register our settings
	register_setting('yablog-settings-group', 'yablog_disable_xmlrpc');
	register_setting('yablog-settings-group', 'yablog_disable_wp_generator');
	register_setting('yablog-settings-group', 'yablog_disable_emoji');
	register_setting('yablog-settings-group', 'yablog_disable_wlwmanifest');
	register_setting('yablog-settings-group', 'yablog_disable_feed');
	register_setting('yablog-settings-group', 'yablog_options');
}

function yablog_settings_page()
{
	wp_nonce_field('update-options');
	include_once(plugin_dir_path(__FILE__).'/settings_page.php');
}

function yablog_disable_feed()
{
	wp_die(sprintf(__('No feed available, please visit our <a href="%s">Home page</a>!', 'yablog'), get_bloginfo('url')));
}

function yablog_get_option($option, $default = false)
{
	static $key_prefix = 'yablog_';
	static $options = null;

    if (is_null($options))
    {
    	$options = is_multisite()? get_site_option($key_prefix.'options', $default): get_option($key_prefix.'options', $default);
    }

    if (isset($options[$option]))
    {
    	return $options[$option];
    }

    if (empty($options['version']))
    {
    	$options[$option] = is_multisite()? get_site_option($key_prefix.$option, $default): get_option($key_prefix.$option, $default);
    }
    
    return $options[$option];
}

function yablog_action_init()
{
	add_filter('wp_headers', 'yablog_filter_wp_headers');

	if (yablog_get_option('disable_xmlrpc'))
	{
		add_filter('bloginfo_url', 'yablog_filter_bloginfo_url_remove_pingback_url', 10, 2);

		add_filter('xmlrpc_enabled', '__return_false');
		// Disable XMLRPC by hijacking and blocking the option.
		add_filter('pre_option_enable_xmlrpc', '__return_state_false');
		add_filter('option_enable_xmlrpc', '__return_state_false');

		// Just disable pingback.ping functionality while leaving XMLRPC intact?
		add_action('xmlrpc_call', function($method){
    		if($method != 'pingback.ping') return;
    		wp_die(
        		__('Pingback functionality is disabled on this Blog.', 'yablog'),
        		__('Pingback Disabled!', 'yablog'),
        		array('response' => 403, 'back_link' => 'http://blog.paramonovav.com/en/plugins/plugins-for-wordpress/')
    		);
		});

		remove_action('wp_head', 'rsd_link');//<link rel="EditURI" type="application/rsd+xml" title="RSD" href="http://blog.paramonovav.com/xmlrpc.php?rsd" />
	}
	
	if (yablog_get_option('disable_wp_generator'))
	{
		remove_action('wp_head', 'wp_generator');//<meta name="generator" content="WordPress 4.2.2" />
	}
	if (yablog_get_option('disable_wlwmanifest'))
	{
		//Windows Live Writer
		remove_action('wp_head', 'wlwmanifest_link');//<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="http://blog.paramonovav.com/wp-includes/wlwmanifest.xml" /> 
	}
	
	if (yablog_get_option('disable_emoji'))
	{
		remove_action('wp_head', 'print_emoji_detection_script', 7);//_wpemojiSettings
		remove_action('wp_print_styles', 'print_emoji_styles');	
	}
	
	if (yablog_get_option('disable_feed'))
	{
		remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
		remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed

		add_action('do_feed', 'yablog_disable_feed', 1);
		add_action('do_feed_rdf', 'yablog_disable_feed', 1);
		add_action('do_feed_rss', 'yablog_disable_feed', 1);
		add_action('do_feed_rss2', 'yablog_disable_feed', 1);
		add_action('do_feed_atom', 'yablog_disable_feed', 1);
		add_action('do_feed_rss2_comments', 'yablog_disable_feed', 1);
		add_action('do_feed_atom_comments', 'yablog_disable_feed', 1);
	}

	if (yablog_get_option('disable_shortlink'))
	{
		remove_action('wp_head', 'wp_shortlink_wp_head', 10);
		remove_action('template_redirect', 'wp_shortlink_header', 11);
	}
}

function __return_state_false($state)
{
	return FALSE;
}

function yablog_filter_bloginfo_url_remove_pingback_url( $output, $show )
{
    if ( $show == 'pingback_url' )
    {
    	$output = '';
    }

    return $output;
}

function yablog_filter_wp_headers($headers)
{
	if (isset($headers['X-Pingback']) && yablog_get_option('disable_xmlrpc'))
	{
		unset($headers['X-Pingback']);
	}

    return $headers;     
}