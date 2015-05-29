<?php
    $opts1 = array(
        'yablog_disable_xmlrpc' => array(
            'label' => 'Disable XML-RPC',
            'desc' => 'Disable XML-RPC API in WordPress 3.5+.'
        ),
        'yablog_disable_emoji' => array(
            'label' => 'Disable emoji',
            'desc' => 'Disable the new emoji functionality in WordPress 4.2'
        ),
        'yablog_disable_feed' => array(
            'label' => 'Disable all feeds',
            'desc' => 'Disable and remove from html links to the general feeds: Post and Comment Feed, and links to the extra feeds such as category feeds.'
        ),
    );
    $opts2 = array(
        'yablog_disable_wp_generator' => array(
            'label' => 'Remove html meta tag generator',
            'desc' => '<meta name="generator" content="WordPress 4.2.2" />'
        ),
        'yablog_disable_wlwmanifest' => array(
            'label' => 'Remove wlwmanifest',
            'desc' => '<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="'.get_bloginfo('url').'/wp-includes/wlwmanifest.xml" />'
        ),
    );
?>
<style> .indent {padding-left: 2em} </style>
<div class="wrap">
<h2>YaBlog Settings</h2>
<form method="post" action="options.php">
    <?php settings_fields('yablog-settings-group'); ?>
    <h3>Disable services</h3>
    <ul>
        <?php foreach ($opts1 as $opt_key => $opt): ?>
        <li>
                <label>
                    <input type="checkbox" name="<?php echo $opt_key; ?>" value="1" <?php if (1==yablog_get_option($opt_key)): ?>checked="checked"<?php endif; ?>/>
                    <strong><?php echo $opt['label']; ?></strong>
                </label>
                <?php if (!empty($opt['desc'])): ?>
                <p class="indent"><?php echo $opt['desc']; ?></p>
                <?php endif; ?>
        </li>
    <?php endforeach; ?>
    </ul>    
    <h3>Remove</h3>
    <ul>
        <?php foreach ($opts2 as $opt_key => $opt): ?>
        <li>
                <label>
                    <input type="checkbox" name="<?php echo $opt_key; ?>" value="1" <?php if (1==yablog_get_option($opt_key)): ?>checked="checked"<?php endif; ?>/>
                    <strong><?php echo $opt['label']; ?></strong>
                </label>
                <?php if (!empty($opt['desc'])): ?>
                <p class="indent"><strong style="color: #900">Remove:&nbsp;</strong><?php echo htmlspecialchars($opt['desc']); ?></p>
                <?php endif; ?>
        </li>
    <?php endforeach; ?>
    </ul>    
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>
</form>
</div>