<?php
/**
 * Plugin Installer List Table class.
 *
 * @package WordPress
 * @subpackage List_Table
 * @since 3.1.0
 * @access private
 */
 
 class plobj{
    function plobj()
    {
        return true;
    }
}
 
class WP_FPlugin_Install_List_Table extends WP_List_Table {

	function ajax_user_can() {
		return current_user_can('install_plugins');
	}

	function prepare_items($list) {
		include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );

		global $tabs, $tab, $paged, $type, $term;

		wp_reset_vars( array( 'tab' ) );

		$paged = $this->get_pagenum();

		$per_page = 30;

		// These are the tabs which are shown on the page
		$tabs = array();

		$nonmenu_tabs = array( 'plugin-information' ); //Valid actions to perform which do not have a Menu item.


		$nonmenu_tabs = apply_filters( 'install_plugins_nonmenu_tabs', $nonmenu_tabs );

		// If a non-valid menu tab has been selected, And its not a non-menu action.
		if ( empty( $tab ) || ( !isset( $tabs[ $tab ] ) && !in_array( $tab, (array) $nonmenu_tabs ) ) )
			$tab = key( $tabs );

		$args = array( 'page' => $paged, 'per_page' => $per_page );



		$reslist = array();
		 
		foreach($list as $k => $v){
			$ver = (string)$v->product_description;
			if ($ver){
			
				$obj = new plobj();
				$obj->name = (string) $v->title;
				$obj->slug = sanitize_title($obj->name);
				$obj->version = (string)  $v->product_version;
				$obj->author = '<a href="'.((string)$v->product_creator ).'">'.((string)$v->product_salespage).'</a>';
				$obj->requires = '3.0';
				$obj->tested = '3.3';
				$obj->rating = (string) $v->product_stars;
				$obj->num_ratings = 1;
				$obj->homepage = (string) $v->product_salespage;
				$obj->description = (string) $v->product_description;
				$des = $ver;
				$obj->install_url = (string) $v->install_url;
				$obj->product_creator = (string) $v->product_creator;
				$obj->product_salespage = (string) $v->product_salespage;
				$obj->short_description = substr($des,0,255)."...";
				$obj->product_review = (string) $v->product_review;
			
				$reslist[] = $obj;
			}
		}
		
		$this->items = $reslist;

		$this->set_pagination_args( array(
			'total_items' => count($reslist),
			'per_page' => 10,
		) );
	}

	function no_items() {
		_e( 'No plugins match your request.' );
	}

	function get_views() {
		global $tabs, $tab;

		$display_tabs = array();
		foreach ( (array) $tabs as $action => $text ) {
			$class = ( $action == $tab ) ? ' class="current"' : '';
			$href = self_admin_url('plugin-install.php?tab=' . $action);
			$display_tabs['plugin-install-'.$action] = "<a href='$href'$class>$text</a>";
		}

		return $display_tabs;
	}

	function display_tablenav( $which ) {
		if ( 'top' ==  $which ) { ?>
			<div class="tablenav top">
				<div class="alignleft actions">
					<?php do_action( 'install_plugins_table_header' ); ?>
				</div>
				<?php $this->pagination( $which ); ?>
				<img src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" class="ajax-loading list-ajax-loading" alt="" />
				<br class="clear" />
			</div>
		<?php } else { ?>
			<div class="tablenav bottom">
				<?php $this->pagination( $which ); ?>
				<img src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" class="ajax-loading list-ajax-loading" alt="" />
				<br class="clear" />
			</div>
		<?php
		}
	}

	function get_table_classes() {
		extract( $this->_args );

		return array( 'widefat', $plural );
	}

	function get_columns() {
		return array(
			'name'        => _x( 'Name', 'plugin name' ),
			'version'     => __( 'Version' ),
			'rating'      => __( 'Rating' ),
			'description' => __( 'Description' ),
		);
	}

	function display_rows() {
		$plugins_allowedtags = array(
			'a' => array( 'href' => array(),'title' => array(), 'target' => array() ),
			'abbr' => array( 'title' => array() ),'acronym' => array( 'title' => array() ),
			'code' => array(), 'pre' => array(), 'em' => array(),'strong' => array(),
			'ul' => array(), 'ol' => array(), 'li' => array(), 'p' => array(), 'br' => array()
		);

		list( $columns, $hidden ) = $this->get_column_info();

		$style = array();
		foreach ( $columns as $column_name => $column_display_name ) {
			$style[ $column_name ] = in_array( $column_name, $hidden ) ? 'style="display:none;"' : '';
		}

		foreach ( (array) $this->items as $plugin ) {
			if ( is_object( $plugin ) )
				$plugin = (array) $plugin;

			$title = wp_kses( $plugin['name'], $plugins_allowedtags );
			//Limit description to 400char, and remove any HTML.
			$description = strip_tags( $plugin['description'] );
			if ( strlen( $description ) > 400 )
				$description = mb_substr( $description, 0, 400 ) . '&#8230;';
			//remove any trailing entities
			$description = preg_replace( '/&[^;\s]{0,6}$/', '', $description );
			//strip leading/trailing & multiple consecutive lines
			$description = trim( $description );
			$description = preg_replace( "|(\r?\n)+|", "\n", $description );
			//\n => <br>
			$description = nl2br( $description );
			$version = wp_kses( $plugin['version'], $plugins_allowedtags );

			$name = strip_tags( $title . ' ' . $version );

			$author = $plugin['author'];
			if ( ! empty( $plugin['author'] ) )
				$author = ' <cite>' . sprintf( __( 'By %s' ), $author ) . '.</cite>';

			$author = "&nbsp;&nbsp;&nbsp;<a target='_blank' href='$plugin[product_salespage]'>by $plugin[product_creator]</a>";

			$action_links = array();
			$action_links[] = '<a target=blank href="'.$plugin['homepage'].'">' . __( 'Visit Plugin Site' ) . '</a>';

			if ( current_user_can( 'install_plugins' ) || current_user_can( 'update_plugins' ) ) {
				$status = install_plugin_install_status( $plugin );
	
				if ($plugin['install_url'])
				$action_links[] = '<a target=blank href="plugins.php?page=add_featured&url='.urlencode($plugin['install_url']).'"> Install</a>';				
				$action_links[] = '<a target=blank href="'.urldecode($plugin['product_review']).'">Review</a>';								
				
			}

			$action_links = apply_filters( 'plugin_install_action_links', $action_links, $plugin );
		?>
		<tr>
			<td class="name column-name"<?php echo $style['name']; ?>><strong><?php echo $title; ?></strong>
				<div class="action-links"><?php if ( !empty( $action_links ) ) echo implode( ' | ', $action_links ); ?></div>
			</td>
			<td class="vers column-version"<?php echo $style['version']; ?>><?php echo $version; ?></td>
			<td class="vers column-rating"<?php echo $style['rating']; ?>>
				<div class="star-holder" title="<?php printf( _n( '(based on %s rating)', '(based on %s ratings)', $plugin['num_ratings'] ), number_format_i18n( $plugin['num_ratings'] ) ) ?>">
					<div class="star star-rating" style="width: <?php echo $plugin['rating']*20;?>px"></div>
					<?php
						$color = get_user_option('admin_color');
						if ( empty($color) || 'fresh' == $color )
							$star_url = admin_url( 'images/gray-star.png?v=20110615' ); // 'Fresh' Gray star for list tables
						else
							$star_url = admin_url( 'images/star.png?v=20110615' ); // 'Classic' Blue star
					?>
					<div class="star star5"><img src="<?php echo $star_url; ?>" alt="<?php esc_attr_e( '5 stars' ) ?>" /></div>
					<div class="star star4"><img src="<?php echo $star_url; ?>" alt="<?php esc_attr_e( '4 stars' ) ?>" /></div>
					<div class="star star3"><img src="<?php echo $star_url; ?>" alt="<?php esc_attr_e( '3 stars' ) ?>" /></div>
					<div class="star star2"><img src="<?php echo $star_url; ?>" alt="<?php esc_attr_e( '2 stars' ) ?>" /></div>
					<div class="star star1"><img src="<?php echo $star_url; ?>" alt="<?php esc_attr_e( '1 star' ) ?>" /></div>
				</div>
			</td>
			<td class="desc column-description"<?php echo $style['description']; ?>><?php echo $description, $author; ?></td>
		</tr>
		<?php
		}
	}
}

?>
