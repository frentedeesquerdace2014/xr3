<?php
/*
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.txt
Copyright 2012-2014 - Jean-Sebastien Morisset - http://surniaulula.com/
*/

if ( ! defined( 'ABSPATH' ) ) 
	die( 'These aren\'t the droids you\'re looking for...' );

if ( ! class_exists( 'WpssoSitesubmenuNetwork' ) && class_exists( 'WpssoAdmin' ) ) {

	class WpssoSitesubmenuNetwork extends WpssoAdmin {

		// executed by WpssoAdminAdvancedPro() as well
		public function __construct( &$plugin, $id, $name ) {
			$this->p =& $plugin;
			$this->p->debug->mark();
			$this->menu_id = $id;
			$this->menu_name = $name;
		}

		protected function set_form() {
			$def_site_opts = $this->p->opt->get_site_defaults();
			$this->form = new SucomForm( $this->p, WPSSO_SITE_OPTIONS_NAME, $this->p->site_options, $def_site_opts );
		}

		protected function add_meta_boxes() {
			// add_meta_box( $id, $title, $callback, $post_type, $context, $priority, $callback_args );
			add_meta_box( $this->pagehook.'_network', 'Network-Wide Settings', array( &$this, 'show_metabox_network' ), $this->pagehook, 'normal' );
			add_filter( 'postbox_classes_'.$this->pagehook.'_'.$this->pagehook.'_network', array( &$this, 'add_class_postbox_network' ) );
		}

		public function add_class_postbox_network( $classes ) {
			array_push( $classes, 'admin_postbox_network' );
			return $classes;
		}

		public function show_metabox_network() {
			echo '<table class="sucom-setting">';
			foreach ( $this->get_rows( 'network', 'settings' ) as $row )
				echo '<tr>'.$row.'</tr>';
			echo '</table>';
		}

		protected function get_rows( $metabox, $key ) {
			$ret = array();
			$use = array( 
				'default' => 'As Default Value', 
				'empty' => 'If Value is Empty', 
				'force' => 'Force This Value',
			);
			// generic tooltip message for site option use
			$use_msg = esc_attr( 'Individual sites / blogs may use this value as a default when the plugin is first activated, 
			if the current site / blog option value is blank, or force every site / blog to use this value (disabling editing of this field).' );

			switch ( $metabox.'-'.$key ) {
				case 'network-settings' :
					// retrieve information on license use, if any
					$qty_used = class_exists( 'SucomUpdate' ) ? 
						SucomUpdate::get_option( $this->p->cf['lca'], 'qty_used' ) : false;

					$ret[] = $this->p->util->th( $this->p->cf['uca'].' Pro Authentication ID', 'highlight', 'plugin_tid_network' ).
					'<td nowrap><p>'.$this->form->get_input( 'plugin_tid', 'mono' ).
						( empty( $qty_used ) ? '' : ' &nbsp;'.$qty_used.' Licenses Assigned</p>' ).'</td>'.
					'<td nowrap>Site Use <img src="'.WPSSO_URLPATH.'images/question-mark.png" class="sucom_tooltip'.'" alt="'.$use_msg.'" /> '.
						$this->form->get_select( 'plugin_tid:use', $use, 'medium' ).'</td>';

					$ret[] = $this->p->util->th( 'Object Cache Expiry', null, 'plugin_object_cache_exp' ).
					'<td nowrap>'.$this->form->get_input( 'plugin_object_cache_exp', 'short' ).' seconds</td>'.
					'<td nowrap>Site Use <img src="'.WPSSO_URLPATH.'images/question-mark.png" class="sucom_tooltip'.'" alt="'.$use_msg.'" /> '.
						$this->form->get_select( 'plugin_object_cache_exp:use', $use, 'medium' ).'</td>';

					break;

			}
			return $ret;
		}
	}
}

?>
