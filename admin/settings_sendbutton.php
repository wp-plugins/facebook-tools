<div class="wrap">
    <h2>Facebook Tools - Send Button</h2>
    <?php if(isset($_GET['settings-updated']) && $_GET['settings-updated']) : ?>
    <div class="updated settings-error"><p><strong>Settings saved.</strong></p></div>
    <?php endif; ?>
    <form method="post" action="options.php">
    <?php settings_fields('uprisingcreative_fbtools_sendbutton_settings'); ?>
    <table class="form-table">
        <tr valign="top">
            <th scope="row">URL</th>
            <td>
                <input type="text" name="uprisingcreative_fbtools_sendbutton_href" value="<?php echo get_option('uprisingcreative_fbtools_sendbutton_href'); ?>" />
                <span class="description">The URL to Send. The XFBML version defaults to the current page.</span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Font</th>
            <td>
                <?php
                $options = array(
                	'arial' => 'Arial',
                	'lucida grande' => 'Lucida Grande',
                	'segoe ui' => 'Segoe UI',
                	'tahoma' => 'Tahoma',
                	'trebuchet ms' => 'Trebuchet MS',
                	'verdana' => 'Verdana'
                );
                ?>
                <select name="uprisingcreative_fbtools_sendbutton_font">
                    <?php foreach($options as $option=>$optionName) : ?>
                    <option value="<?php echo $option; ?>" <?php echo (get_option('uprisingcreative_fbtools_sendbutton_font')==$option) ? 'selected="selected"' : ''; ?>><?php echo $optionName; ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="description">The font to display in the button.</span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Color Scheme</th>
            <td>
                <?php $options = array('light','dark'); ?>
                <select name="uprisingcreative_fbtools_sendbutton_colorscheme">
                    <?php foreach($options as $option) : ?>
                    <option value="<?php echo $option; ?>" <?php echo (get_option('uprisingcreative_fbtools_sendbutton_colorscheme')==$option) ? 'selected="selected"' : ''; ?>><?php echo $option; ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="description">The color scheme for the like button.</span>
            </td>
        </tr>
        <tr>
        	<th scope="row">Referral Tracking Name</th>
        	<td>
                <input type="text" name="uprisingcreative_fbtools_sendbutton_ref" value="<?php echo get_option('uprisingcreative_fbtools_sendbutton_ref'); ?>" />
                <div class="description">A label for tracking referrals; must be less than 50 characters and can contain alphanumeric characters and some punctuation (currently +/=-.:_). Specifying the ref attribute will add the 'fb_ref' parameter to the referrer URL when a user clicks a link from the plugin.</div>
        	</td>
        </tr>
    </table>
    <p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes'); ?>" /></p>
    </form>
</div>