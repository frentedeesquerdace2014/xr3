<?php
/*
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.txt
Copyright 2012-2014 - Jean-Sebastien Morisset - http://surniaulula.com/
*/

if ( ! defined( 'ABSPATH' ) ) 
	die( 'These aren\'t the droids you\'re looking for...' );

if ( ! class_exists( 'NgfbAdminApikeys' ) ) {

	class NgfbAdminApikeys {

		public function __construct( &$plugin ) {
			$this->p =& $plugin;
			$this->p->util->add_plugin_filters( $this, array( 
				'plugin_tabs' => 1,
				'plugin_apikeys_rows' => 2,
			) );
		}

		public function filter_plugin_tabs( $tabs ) {
			$tabs['apikeys'] = 'API Keys';
			return $tabs;
		}

		public function filter_plugin_apikeys_rows( $rows, $form ) {
			$rows[] = '<td colspan="2" align="center">'.$this->p->msgs->get( 'pro-feature-msg' ).'</td>';

			if ( $this->p->options['plugin_display'] == 'all' ) {
				$rows[] = $this->p->util->th( 'Minimum URL Length to Shorten', null, 'plugin_min_shorten' ). 
				'<td class="blank">'.$form->get_hidden( 'plugin_min_shorten' ).
					$this->p->options['plugin_min_shorten'].' characters</td>';
			}

			$rows[] = $this->p->util->th( 'Bit.ly Username', null, 'plugin_bitly_login' ).
			'<td class="blank mono">'.$form->get_hidden( 'plugin_bitly_login' ).
				$this->p->options['plugin_bitly_login'].'</td>';

			$rows[] = $this->p->util->th( 'Bit.ly API Key', null, 'plugin_bitly_api_key' ).
			'<td class="blank mono">'.$form->get_hidden( 'plugin_bitly_api_key' ).
				$this->p->options['plugin_bitly_api_key'].'</td>';

			$rows[] = $this->p->util->th( 'Google Project App BrowserKey', null, 'plugin_google_api_key' ).
			'<td class="blank mono">'.$form->get_hidden( 'plugin_google_api_key' ).
				$this->p->options['plugin_google_api_key'].'</td>';

			$rows[] = $this->p->util->th( 'Google URL Shortener API is ON', null, 'plugin_google_shorten' ).
			'<td class="blank">'.$form->get_fake_radio( 'plugin_google_shorten', 
				array( '1' => 'Yes', '0' => 'No' ), null, null, true ).'</td>';

			return $rows;
		}
	}
}

?>
