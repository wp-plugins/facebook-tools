<div class="wrap">
    <h2>Facebook Tools - General Settings</h2>
    <?php if(isset($_GET['settings-updated']) && $_GET['settings-updated']) : ?>
    <div class="updated settings-error"><p><strong>Settings saved.</strong></p></div>
    <?php endif; ?>
    <form method="post" action="options.php">
    <?php settings_fields('uprisingcreative_fbtools_settings'); ?>
    <table class="form-table">
        <tr valign="top">
            <th scope="row">App ID</th>
            <td><input type="text" name="uprisingcreative_fbtools_app_id" value="<?php echo get_option('uprisingcreative_fbtools_app_id'); ?>" /></td>
        </tr>
        <tr valign="top">
            <th scope="row">API Key</th>
            <td><input type="text" name="uprisingcreative_fbtools_api_key" value="<?php echo get_option('uprisingcreative_fbtools_api_key'); ?>" /></td>
        </tr>
        <tr valign="top">
            <th scope="row">API Secret</th>
            <td><input type="text" name="uprisingcreative_fbtools_api_secret" value="<?php echo get_option('uprisingcreative_fbtools_api_secret'); ?>" /></td>
        </tr>
        <tr valign="top">
            <th scope="row">Facebook URL</th>
            <td><input type="text" name="uprisingcreative_fbtools_facebook_url" value="<?php echo get_option('uprisingcreative_fbtools_facebook_url'); ?>" /></td>
        </tr>
        <tr valign="top">
            <th scope="row">Disable Open Tags</th>
            <td>
            	<input type="checkbox" name="uprisingcreative_fbtools_disable_opengraph" <?=(get_option('uprisingcreative_fbtools_disable_opengraph'))?'checked="checked"' : ''; ?> />
            	<span class="description">
            		Check this box to disable automatic placement of the Open Graph tags.
            	</span>
            </td>
        </tr>
    </table>
    <p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes'); ?>" /></p>
    </form>
</div>