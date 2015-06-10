<?php
    $opts1 = array(
        'disable_xmlrpc' => array(
            'label' => __('Disable XML-RPC', 'yablog'),
            'desc' => __('Disable XML-RPC API in WordPress 3.5+.', 'yablog')
        ),
        'disable_emoji' => array(
            'label' => __('Disable emoji', 'yablog'),
            'desc' => __('Disable the new emoji functionality in WordPress 4.2', 'yablog')
        ),
        'disable_feed' => array(
            'label' => __('Disable all feeds', 'yablog'),
            'desc' => __('Disable and remove from html links to the general feeds: Post and Comment Feed, and links to the extra feeds such as category feeds.', 'yablog')
        ),
    );
    $opts2 = array(
        'disable_wp_generator' => array(
            'label' => __('Remove html meta tag generator', 'yablog'),
            'desc' => __('<meta name="generator" content="WordPress 4.2.2" />', 'yablog')
        ),
        'disable_wlwmanifest' => array(
            'label' => __('Remove wlwmanifest', 'yablog'),
            'desc' => __('<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="/wp-includes/wlwmanifest.xml" />', 'yablog')
        ),
        'disable_shortlink' => array(
            'label' => __('Remove shortlink', 'yablog'),
            'desc' => sprintf(__('Remove "Link:<%s/>; rel=shortlink" from HTTP header', 'yablog'), get_bloginfo('url'))
        ),
    );
?>
<style> .indent {padding-left: 2em} </style>
<div class="wrap">
<h2>YaBlog <?php _e('Settings'); ?></h2>
<form method="post" action="options.php">
    <?php settings_fields('yablog-settings-group'); ?>
    <h3><?php _e('Disable'); ?></h3>
    <ul>
        <?php foreach ($opts1 as $opt_key => $opt): ?>
        <li>
                <label>
                    <input type="checkbox" name="yablog_options[<?php echo $opt_key; ?>]" value="1" <?php if (1==yablog_get_option($opt_key)): ?>checked="checked"<?php endif; ?>/>
                    <strong><?php echo $opt['label']; ?></strong>
                </label>
                <?php if (!empty($opt['desc'])): ?>
                <p class="indent"><?php echo $opt['desc']; ?></p>
                <?php endif; ?>
        </li>
    <?php endforeach; ?>
    </ul>    
    <h3><?php _e('Remove', 'yablog'); ?></h3>
    <ul>
        <?php foreach ($opts2 as $opt_key => $opt): ?>
        <li>
                <label>
                    <input type="checkbox" name="yablog_options[<?php echo $opt_key; ?>]" value="1" <?php if (1==yablog_get_option($opt_key)): ?>checked="checked"<?php endif; ?>/>
                    <strong><?php echo $opt['label']; ?></strong>
                </label>
                <?php if (!empty($opt['desc'])): ?>
                <p class="indent"><strong style="color: #900"><?php _e('Remove', 'yablog'); ?>:&nbsp;</strong><?php echo htmlspecialchars($opt['desc']); ?></p>
                <?php endif; ?>
        </li>
    <?php endforeach; ?>
    </ul>    
    <p class="submit">
    <input type="hidden" name="yablog_options[version]" value="2"/>
    <input type="submit" class="button-primary" value="<?php _e('Save Changes'); ?>" />
    </p>
</form>
</div>