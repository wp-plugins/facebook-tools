<div class="wrap">
    <h2>Facebook Tools - Comments</h2>
    <?php if(isset($_GET['settings-updated']) && $_GET['settings-updated']) : ?>
    <div class="updated settings-error"><p><strong>Settings saved.</strong></p></div>
    <?php endif; ?>
    <form method="post" action="options.php" name="form">
    <?php settings_fields('uprisingcreative_fbtools_comments_settings'); ?>
    <h3>Global Settings</h3>
    <table class="form-table">
        <tr valign="top">
            <th scope="row">Use New Comment Box</th>
            <td>
                <input type="checkbox" name="uprisingcreative_fbtools_comments_migrated" <?php echo (get_option('uprisingcreative_fbtools_comments_migrated')) ? "checked=\"checked\"" : ""; ?> />
                Check this box to use the new and improved comment box. <a href="http://developers.facebook.com/blog/post/472" target="_blank">Read more</a>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Number of Comments</th>
            <td>
                <input type="text" name="uprisingcreative_fbtools_comments_numposts" value="<?php echo get_option('uprisingcreative_fbtools_comments_numposts'); ?>" />
                The number of comments to show by default. Default: 10.
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Width</th>
            <td>
                <input type="text" name="uprisingcreative_fbtools_comments_width" value="<?php echo get_option('uprisingcreative_fbtools_comments_width'); ?>" />
                The width of the plugin in pixels. Minimum width: 500px.
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Color Scheme</th>
            <td>
                <?php $options = array('light','dark'); ?>
                <select name="uprisingcreative_fbtools_comments_colorscheme">
                    <?php foreach($options as $option) : ?>
                    <option value="<?php echo $option; ?>" <?php echo (get_option('uprisingcreative_fbtools_comments_colorscheme')==$option) ? 'selected="selected"' : ''; ?>><?php echo $option; ?></option>
                    <?php endforeach; ?>
                </select>
                The color scheme for the comment box.
            </td>
        </tr>
    </table>
    <h3>Legacy Comments Box</h3>
    <p>All settings below only take effect if "Use New Comment Box" is unchecked under Global Settings.</p>
    <table class="form-table">
        <tr valign="top">
            <th scope="row">Reverse Order</th>
            <td>
                <input type="checkbox" name="uprisingcreative_fbtools_comments_reverse" <?php echo (get_option('uprisingcreative_fbtools_comments_reverse')) ? "checked=\"checked\"" : ""; ?> />
                Changes the order of comments and comment area to allow greater customization.
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Stylesheet</th>
            <td>
                <input type="text" name="uprisingcreative_fbtools_comments_css" value="<?php echo get_option('uprisingcreative_fbtools_comments_css'); ?>" />
                The name of your stylesheet that is located in your theme folder. (Example: facebook.css)
            </td>
        </tr>
    </table>
    <p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes'); ?>" /></p>
    </form>
</div>