<div class="wrap">
    <h2>Facebook Tools - Like Button</h2>
    <?php if(isset($_GET['settings-updated']) && $_GET['settings-updated']) : ?>
    <div class="updated settings-error"><p><strong>Settings saved.</strong></p></div>
    <?php endif; ?>
    <form method="post" action="options.php">
    <?php settings_fields('uprisingcreative_fbtools_likebutton_settings'); ?>
    <table class="form-table">
        <tr valign="top">
            <th scope="row">URL</th>
            <td>
                <input type="text" name="uprisingcreative_fbtools_likebutton_href" value="<?php echo get_option('uprisingcreative_fbtools_likebutton_href'); ?>" />
                The URL to like. The XFBML version defaults to the current page.
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Layout</th>
            <td>
                <?php $options = array('standard','button_count','box_count'); ?>
                <select name="uprisingcreative_fbtools_likebutton_layout">
                    <?php foreach($options as $option) : ?>
                    <option value="<?php echo $option; ?>" <?php echo (get_option('uprisingcreative_fbtools_likebutton_layout')==$option) ? 'selected="selected"' : ''; ?>><?php echo $option; ?></option>
                    <?php endforeach; ?>
                </select>
                <ul style="font-size:11px;">
                    <li>standard - Displays social text to the right of the button and friends' profile photos below. Minimum width: 225 pixels. Default width: 450 pixels. Height: 35 pixels (without photos) or 80 pixels (with photos).</li>
                    <li>button_count - Displays the total number of likes to the right of the button. Minimum width: 90 pixels. Default width: 90 pixels. Height: 20 pixels.</li>
                    <li>box_count - Displays the total number of likes above the button. Minimum width: 55 pixels. Default width: 55 pixels. Height: 65 pixels.</li>
                </ul>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Width</th>
            <td>
                <input type="text" name="uprisingcreative_fbtools_likebutton_width" value="<?php echo get_option('uprisingcreative_fbtools_likebutton_width'); ?>" />
                The width of the Like button. (in pixels)
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Action</th>
            <td>
                <?php $options = array('like','recommend'); ?>
                <select name="uprisingcreative_fbtools_likebutton_action">
                    <?php foreach($options as $option) : ?>
                    <option value="<?php echo $option; ?>" <?php echo (get_option('uprisingcreative_fbtools_likebutton_action')==$option) ? 'selected="selected"' : ''; ?>><?php echo $option; ?></option>
                    <?php endforeach; ?>
                </select>
                The verb to display on the button.
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Color Scheme</th>
            <td>
                <?php $options = array('light','dark'); ?>
                <select name="uprisingcreative_fbtools_likebutton_colorscheme">
                    <?php foreach($options as $option) : ?>
                    <option value="<?php echo $option; ?>" <?php echo (get_option('uprisingcreative_fbtools_likebutton_colorscheme')==$option) ? 'selected="selected"' : ''; ?>><?php echo $option; ?></option>
                    <?php endforeach; ?>
                </select>
                The color scheme for the like button.
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Send Button</th>
            <td>
            	<input type="checkbox" name="uprisingcreative_fbtools_likebutton_send" value="1" <?=(get_option('uprisingcreative_fbtools_likebutton_send'))?'checked="checked"':'';?> />
                Specify whether or not to include the Send button.
            </td>
        </tr>
    </table>
    <p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes'); ?>" /></p>
    </form>
</div>