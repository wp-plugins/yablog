<?php 

    if( !defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN'))
    {
        exit;
    }

    $opts = array(
        'yablog_disable_xmlrpc',
        'yablog_disable_wp_generator',
        'yablog_disable_emoji',
        'yablog_disable_wlwmanifest',
        'yablog_disable_feed',
        'yablog_options'
    );

    foreach ($opts as $opt_key)
    {
    	delete_option($opt_key);
        
        if (is_multisite())
        {
            delete_site_option($opt_key);
        }
	}