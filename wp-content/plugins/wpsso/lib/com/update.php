<?php
/* 
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.txt
Copyright 2012-2014 - Jean-Sebastien Morisset - http://surniaulula.com/
*/

if ( ! defined( 'ABSPATH' ) ) 
	die( 'These aren\'t the droids you\'re looking for...' );

if ( ! class_exists( 'SucomUpdate' ) ) {

	class SucomUpdate {
	
		private $p;
		private static $c = array();
	
		public $lca = '';
		public $slug = '';
		public $base = '';
		public $cron_hook = '';
		public $sched_hours = 24;
		public $sched_name = 'every24hours';
		public $opt_name = '';
		public $json_url = '';
		public $json_expire = 3600;	// cache retrieved update json for 1 hour
		public $update_timestamp = '';

		public function __construct( &$plugin, $lca, $slug, $plugin_base, $update_url ) {
			$this->p =& $plugin;
			$this->p->debug->mark();
			$this->lca = $lca;								// ngfb
			$this->slug = $slug;								// nextgen-facebook
			$this->plugin_base = $plugin_base;						// nextgen-facebook/nextgen-facebook.php
			$this->cron_hook = 'plugin_updates-'.$slug;					// plugin_updates-nextgen-facebook
			$this->opt_name = self::$c[$lca.'_opt_name'] = 'external_updates-'.$slug;	// external_updates-nextgen-facebook

			if ( ! empty( $this->p->cf['update_hours'] ) ) {
				$this->sched_hours = $this->p->cf['update_hours'];			// 24
				$this->sched_name = 'every'.$this->sched_hours.'hours';			// every24hours
			}

			if ( ! empty( $this->p->options['plugin_tid'] ) )
				$this->json_url = $update_url.'?tid='.$this->p->options['plugin_tid'];
			else $this->p->debug->log( 'missing option value: plugin_tid' );

			$this->install_hooks();
		}

		public static function get_umsg( $lca ) {
			if ( ! array_key_exists( $lca.'_umsg', self::$c ) ) {
				self::$c[$lca.'_umsg'] = base64_decode( get_option( $lca.'_umsg' ) );
				if ( empty( self::$c[$lca.'_umsg'] ) )
					self::$c[$lca.'_umsg'] = false;
			}
			return self::$c[$lca.'_umsg'];
		}

		public static function get_option( $lca, $idx = '' ) {
			if ( ! empty( self::$c[$lca.'_opt_name'] ) ) {
				$option_data = get_site_option( self::$c[$lca.'_opt_name'] );
				if ( ! empty( $idx ) ) {
					if ( is_object( $option_data->update ) &&
						isset( $option_data->update->$idx ) )
							return $option_data->update->$idx;
					else return false;
				} else return $option_data;
			}
			return false;
		}

		public function install_hooks() {
			$this->p->debug->mark();
			add_filter( 'plugins_api', array( &$this, 'inject_data' ), 100, 3 );
			add_filter( 'transient_update_plugins', array( &$this, 'inject_update' ), 1000, 1 );
			add_filter( 'site_transient_update_plugins', array( &$this, 'inject_update' ), 1000, 1 );
			add_filter( 'pre_site_transient_update_plugins', array( &$this, 'enable_update' ), 1000, 1 );

			// in a multisite environment, each site checks for updates
			if ( $this->sched_hours > 0 ) {
				add_filter( 'cron_schedules', array( &$this, 'custom_schedule' ) );
				add_action( $this->cron_hook, array( &$this, 'check_for_updates' ) );
				$schedule = wp_get_schedule( $this->cron_hook );
				// check for schedule mismatch
				if ( ! empty( $schedule ) && $schedule !== $this->sched_name ) {
					$this->p->debug->log( 'changing '.$this->cron_hook.' schedule from '.$schedule.' to '.$this->sched_name );
					wp_clear_scheduled_hook( $this->cron_hook );
				}
				// add schedule if it doesn't exist
				if ( ! defined('WP_INSTALLING') && ! wp_next_scheduled( $this->cron_hook ) )
					wp_schedule_event( time(), $this->sched_name, $this->cron_hook );	// since wp 2.1.0
			} else wp_clear_scheduled_hook( $this->cron_hook );
		}
	
		public function inject_data( $result, $action = null, $args = null ) {
		    	if ( $action == 'plugin_information' && 
				isset( $args->slug ) && $args->slug == $this->slug ) {
				$plugin_data = $this->get_json();
				if ( ! empty( $plugin_data ) ) 
					return $plugin_data->json_to_wp();
			}
			return $result;
		}

		// if updates have been disabled and/or manipulated (ie. $updates is not false), 
		// then re-enable by including our update data (if a new version is present)
		public function enable_update( $updates = false ) {
			if ( $updates !== false )
				$updates = $this->inject_update( $updates );
			return $updates;
		}

		public function inject_update( $updates = false ) {
			// remove existing plugin information to make sure it is correct
			if ( isset( $updates->response[$this->plugin_base] ) )
				unset( $updates->response[$this->plugin_base] );	// wpsso/wpsso.php
			$option_data = get_site_option( $this->opt_name );
			if ( empty( $option_data ) )
				$this->p->debug->log( 'update option is empty' );
			elseif ( empty( $option_data->update ) )
				$this->p->debug->log( 'no update information' );
			elseif ( ! is_object( $option_data->update ) )
				$this->p->debug->log( 'update property is not an object' );
			elseif ( version_compare( $option_data->update->version, $this->get_installed_version(), '>' ) ) {
				$updates->response[$this->plugin_base] = $option_data->update->json_to_wp();
				$this->p->debug->log( $updates->response[$this->plugin_base], 2 );
			}
			return $updates;
		}
	
		public function custom_schedule( $schedule ) {
			if ( $this->sched_hours > 0 ) {
				$schedule[$this->sched_name] = array(
					'interval' => $this->sched_hours * 3600,
					'display' => sprintf('Every %d hours', $this->sched_hours)
				);
			}
			return $schedule;
		}
	
		public function check_for_updates() {
			$option_data = get_site_option( $this->opt_name );
			if ( empty( $option_data ) ) {
				$option_data = new StdClass;
				$option_data->lastCheck = 0;
				$option_data->checkedVersion = 0;
				$option_data->update = null;
			}
			$option_data->lastCheck = time();
			$option_data->checkedVersion = $this->get_installed_version();
			$option_data->update = $this->get_update_data();
			update_site_option( $this->opt_name, $option_data );
		}
	
		public function get_update_data() {
			$plugin_data = $this->get_json();
			if ( empty( $plugin_data ) ) 
				return null;
			return SucomPluginUpdate::from_plugin_data( $plugin_data );
		}
	
		public function get_json( $query = array(), $read_cache = true ) {
			global $wp_version;
			$update_url = $this->json_url;
			$site_url = get_bloginfo( 'url' );
			$query['installed_version'] = $this->get_installed_version();

			if ( empty( $update_url ) ) {
				$this->p->debug->log( 'exiting early: empty update url' );
				return null;
			} elseif ( ! empty( $query ) ) 
				$update_url = add_query_arg( $query, $update_url );

			if ( ! empty( $this->p->is_avail['cache']['transient'] ) ) {
				$cache_salt = __METHOD__.'(update_url:'.$update_url.'_site_url:'.$site_url.')';
				$cache_id = $this->lca.'_'.md5( $cache_salt );		// use lca prefix for plugin clear cache
				$cache_type = 'object cache';
				$this->p->debug->log( $cache_type.': transient salt '.$cache_salt );
				$last_update = get_option( $this->lca.'_utime' );
				if ( $read_cache && $last_update !== false ) {
					$plugin_data = get_transient( $cache_id );
					if ( $plugin_data !== false ) {
						$this->p->debug->log( $cache_type.': plugin data retrieved from transient '.$cache_id );
						return $plugin_data;
					}
				}
			}

			$ua = 'WordPress/'.$wp_version.' ('.( apply_filters( $this->lca.'_ua_plugin', 
				$this->slug.'/'.$query['installed_version'] ) ).'); '.$site_url;
			$options = array(
				'timeout' => 10, 
				'user-agent' => $ua,
				'headers' => array( 
					'Accept' => 'application/json',
					'X-WordPress-Id' => $ua,
				),
			);

			$plugin_data = null;
			$result = wp_remote_get( $update_url, $options );
			if ( is_wp_error( $result ) ) {
				if ( isset( $this->p->notice ) && is_object( $this->p->notice ) &&
					isset( $this->p->debug ) && is_object( $this->p->debug ) &&
					$this->p->debug->is_on() === true ) {

					$this->p->debug->log( 'update library error: '.$result->get_error_message().'.' );
					$this->p->notice->err( 'Update library error &ndash; '.$result->get_error_message().'.' );
				}
			} elseif ( isset( $result['response']['code'] ) && 
				( $result['response']['code'] == 200 ) && 
				! empty( $result['body'] ) ) {
	
				if ( ! empty( $result['headers']['x-smp-error'] ) ) {
					self::$c[$this->lca.'_umsg'] = json_decode( $result['body'] );
					update_option( $this->lca.'_umsg', base64_encode( self::$c[$this->lca.'_umsg'] ) );
				} else {
					self::$c[$this->lca.'_umsg'] = false;
					delete_option( $this->lca.'_umsg' );
					$plugin_data = SucomPluginData::from_json( $result['body'] );
				}
			}

			$this->update_timestamp = time();
			update_option( $this->lca.'_utime', $this->update_timestamp );

			if ( ! empty( $this->p->is_avail['cache']['transient'] ) ) {
				set_transient( $cache_id, ( $plugin_data === null ? '' : $plugin_data ), $this->json_expire );
				$this->p->debug->log( $cache_type.': plugin data saved to transient '.$cache_id.' ('.$this->json_expire.' seconds)');
			}
			return $plugin_data;
		}
	
		public function get_installed_version() {
			$version = 0;
			if ( ! function_exists( 'get_plugins' ) ) 
				require_once( ABSPATH.'/wp-admin/includes/plugin.php' );
			$plugins = get_plugins();
			if ( array_key_exists( $this->plugin_base, $plugins ) && 
				array_key_exists( 'Version', $plugins[$this->plugin_base] ) )
					$version = $plugins[$this->plugin_base]['Version'];
			return apply_filters( $this->lca.'_installed_version', $version );
		}
	}
}
	
if ( ! class_exists( 'SucomPluginData' ) ) {

	class SucomPluginData {
	
		public $id = 0;
		public $name;
		public $slug;
		public $version;
		public $homepage;
		public $sections;
		public $download_url;
		public $author;
		public $author_homepage;
		public $requires;
		public $tested;
		public $upgrade_notice;
		public $rating;
		public $num_ratings;
		public $downloaded;
		public $last_updated;
	
		public static function from_json( $json ) {
			$json_data = json_decode( $json );
			if ( empty( $json_data ) || 
				! is_object( $json_data ) ) 
					return null;
			if ( isset( $json_data->name ) && 
				! empty( $json_data->name ) && 
				isset( $json_data->version ) && 
				! empty( $json_data->version ) ) {

				$plugin_data = new SucomPluginData();
				foreach( get_object_vars( $json_data ) as $key => $value) {
					$plugin_data->$key = $value;
				}
				return $plugin_data;
			} else return null;
		}
	
		public function json_to_wp(){
			$fields = array(
				'name', 
				'slug', 
				'version', 
				'requires', 
				'tested', 
				'rating', 
				'upgrade_notice',
				'num_ratings', 
				'downloaded', 
				'homepage', 
				'last_updated',
				'download_url',
				'author_homepage');
			$data = new StdClass;
			foreach ( $fields as $field ) {
				if ( isset( $this->$field ) ) {
					if ($field == 'download_url') {
						$data->download_link = $this->download_url; }
					elseif ($field == 'author_homepage') {
						$data->author = sprintf('<a href="%s">%s</a>', $this->author_homepage, $this->author); }
					else { $data->$field = $this->$field; }
				} elseif ( $field == 'author_homepage' )
					$data->author = $this->author;
			}
			if ( is_array( $this->sections ) ) 
				$data->sections = $this->sections;
			elseif ( is_object( $this->sections ) ) 
				$data->sections = get_object_vars( $this->sections );
			else $data->sections = array( 'description' => '' );
			return $data;
		}
	}
}
	
if ( ! class_exists( 'SucomPluginUpdate' ) ) {

	class SucomPluginUpdate {
	
		public $id = 0;
		public $slug;
		public $version = 0;
		public $homepage;
		public $download_url;
		public $upgrade_notice;
	
		public function from_json( $json ) {
			$plugin_data = SucomPluginData::from_json( $json );
			if ( $plugin_data !== null ) 
				return self::from_plugin_data( $plugin_data );
			else return null;
		}
	
		public static function from_plugin_data( $data ){
			$plugin_update = new SucomPluginUpdate();
			$fields = array(
				'id', 
				'slug', 
				'qty_used', 
				'version', 
				'homepage', 
				'download_url', 
				'upgrade_notice'
			);
			foreach( $fields as $field )
				$plugin_update->$field = $data->$field;
			return $plugin_update;
		}
	
		public function json_to_wp() {
			$data = new StdClass;
			$fields = array(
				'id' => 'id',
				'slug' => 'slug',
				'qty_used' => 'qty_used',
				'new_version' => 'version',
				'url' => 'homepage',
				'package' => 'download_url',
				'upgrade_notice' => 'upgrade_notice'
			);
			foreach ( $fields as $new_field => $old_field ) {
				if ( isset( $this->$old_field ) )
					$data->$new_field = $this->$old_field;
			}
			return $data;
		}
	}
}

?>
