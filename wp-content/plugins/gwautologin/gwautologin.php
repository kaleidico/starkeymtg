<?php

/**
* Plugin Name: GP Auto Login
* Description: Automatically log users in after registration.
* Plugin URI: http://gravitywiz.com/
* Version: 1.3
* Author: David Smith
* Author URI: http://gravitywiz.com/
* License: GPL2
* Perk: True
*/

/**
* Saftey net for individual perks that are active when core Gravity Perks plugin is inactive.
*/
$gw_perk_file = __FILE__;
if(!require_once(dirname($gw_perk_file) . '/safetynet.php'))
    return;

/**
* TODO:
* - Provide settings UI for where to redirect after registration.
*/

class GWAutoLogin extends GWPerk {

    public $version = '1.3';

    protected $min_gravity_perks_version = '1.0.beta4';
    protected $min_gravity_forms_version = '1.8.9';
    protected $min_wp_version = '3.5';

	public function init() {

        /*
         * @deprecated 1.3
         */
        $this->add_tooltip($this->key('auto_login'), '<h6>' . __('Auto Login', 'gravityperks') . '</h6>' . __('Enable this option to automatically log users in after registration.', 'gravityperks') );

		// Add Actions
        add_filter( 'gform_userregistration_feed_settings_fields', array( $this, 'add_auto_login_setting' ), 10, 2 );
		add_action( 'gform_user_registered', array( $this, 'maybe_auto_login' ), 10, 4 );

        // Support for User Activation
        add_action( 'init', array( $this, 'auto_login_on_redirect' ), 11 );

        /*
		 * @deprecated 1.3
		 */
        add_action( 'gform_user_registration_add_option_group', array( $this, 'add_auto_login_option' ), 10, 3 );
        add_filter( 'gform_user_registration_save_config', array( $this, 'save_auto_login_option' ) );

	}

	public function requirements() {
		return array(
			array(
				'class' => 'GFUser',
				'message' => 'GP Auto Login requires the Gravity Forms User Registration add-on.'
			)
		);
	}

	public function is_auto_login_enabled( $feed ) {

        // different setting in earlier version of UR (>3.0)
        $old_setting_enabled = rgars( $feed, "meta/{$this->key('auto_login')}" ) == true;
        $enabled = rgars( $feed, 'meta/autoLogin' ) == true;

        return $enabled || $old_setting_enabled;
	}

	public function maybe_auto_login( $user_id, $feed, $entry, $password ) {

		if( ! $this->is_auto_login_enabled( $feed ) ) {
            return;
        }

        if( rgget( 'page' ) == 'gf_activation' ) {
            $redirect_url = add_query_arg( array(
                'user' => $user_id,
                'pass' => rawurlencode( GFCommon::encrypt( $password ) )
            ) );
            echo '<script type="text/javascript"> window.location = "' . $redirect_url . '"; </script>';
        } else {
            $this->auto_login( $user_id, $password );
        }

	}

    public function auto_login_on_redirect() {

        $is_activation_page = rgget( 'page' ) == 'gf_activation';
        $user_id = rgget( 'user' );
        $password = GFCommon::decrypt( rgget( 'pass' ) );

        if( ! $is_activation_page || ! $user_id || ! $password ) {
            return;
        }

        $this->auto_login( $user_id, $password );

        $redirect_url = apply_filters( 'gpal_auto_login_on_redirect_redirect_url', '', $user_id );

        if( ! empty( $redirect_url ) ) {
            wp_redirect( $redirect_url );
            exit;
        }

    }

    public function auto_login( $user_id, $password ) {

        do_action( 'gpal_pre_auto_login', $user_id, $password );

        $user = new WP_User( $user_id );
        $user_data = array(
            'user_login' 	=> $user->user_login,
            'user_password'	=> $password,
            'remember'		=> false
        );

        $result = wp_signon( $user_data );

        if( ! is_wp_error( $result ) ) {
            global $current_user;
            $current_user = $result;
        }

        do_action( 'gpal_post_auto_login', $user_id, $password, $result );

    }

    public function add_auto_login_setting( $fields, $form ) {

        $fields['additional_settings']['fields'][] = array(
            'name'      => 'autoLogin',
            'label'     => __( 'Auto Login', 'gp-auto-login' ),
            'type'      => 'checkbox',
            'choices'   => array(
                array(
                    'label'         => __( 'Automatically log the user in once they are registered.', 'gp-auto-login' ),
                    'value'         => 1,
                    'name'          => 'autoLogin'
                )
            ),
            'tooltip' => sprintf( '<h6>%s</h6> %s', __( 'Auto Login', 'gp-auto-login' ), __( 'Enable this option to automatically log users in after registration.', 'gp-auto-login' ) ),
            'dependency'  => array(
                'field'   => 'feedType',
                'values'  => 'create'
            )
        );

        return $fields;
    }

	public function documentation() {
        return array(
            'type' => 'url',
            'value' => 'http://gravitywiz.com/documentation/gp-auto-login/'
        );
	}



    /**
     * @deprecated 1.3 Use add_auto_login_setting()
     */
    public function add_auto_login_option($feed, $form, $is_validation_error) {
        ?>
        <div class="margin_vertical_10">
            <label class="left_header" for="<?php echo $this->key('auto_login'); ?>">
                <?php _e('Auto Login', 'gravityperks'); ?> <?php gform_tooltip( $this->key('auto_login') ); ?>
            </label>
            <input type="checkbox" id="<?php echo $this->key('auto_login'); ?>" name="<?php echo $this->key('auto_login'); ?>" value="1" <?php checked(rgars($feed, "meta/{$this->key('auto_login')}")); ; ?> />
            <label for="<?php echo $this->key('auto_login'); ?>" class="checkbox-label">
                <?php _e('Automatically log the user in once they are registered.', 'gravityperks'); ?>
            </label>
        </div>
        <?php
    }

    /**
     * @deprecated 1.3
     */
    public function save_auto_login_option($feed) {
        $feed['meta'][$this->key('auto_login')] = rgpost($this->key('auto_login'));
        return $feed;
    }

}