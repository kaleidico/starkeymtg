<?php

require_once('ElevioHelper.class.php');

class TrackingCodeInfoHelper extends ElevioHelper
{
	public function render()
	{
		if (Elevio::get_instance()->is_installed())
		{
            ?>
			<div class="updated installed_ok">
            <p>You've successfully installed Elevio, nice work (using account id: <strong>
                <?php echo Elevio::get_instance()->get_account_id() ?>
            </strong> and secret id: <strong>
                <?php echo Elevio::get_instance()->get_secret_id() ?>
            </strong>)</p></div>

            <form method="post" action="?page=elevio_settings">
                Show elevio on site? <input type="checkbox" name="elevio_is_enabled" id="elevio_is_enabled" value="1" <?php echo Elevio::get_instance()->is_enabled()?'checked="checked"':''; ?> />
                <p class="submit">
                    <input type="hidden" name="settings_form" value="1">
                    <input type="hidden" name="elevio_enable_form" value="1">
                    <input type="submit" class="button-primary" value="<?php _e('Save changes') ?>" />
                </p>
            </form>
            <?php

		}

		return '';
	}
}
