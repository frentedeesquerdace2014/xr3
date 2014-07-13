<?php
/*
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.txt
Copyright 2012-2014 - Jean-Sebastien Morisset - http://surniaulula.com/
*/

if ( ! defined( 'ABSPATH' ) ) 
	die( 'These aren\'t the droids you\'re looking for...' );

if ( ! class_exists( 'NgfbConfig' ) ) {

	class NgfbConfig {

		private static $cf = array(
			'version' => '7.5.5',		// plugin version
			'lca' => 'ngfb',		// lowercase acronym
			'uca' => 'NGFB',		// uppercase acronym
			'slug' => 'nextgen-facebook',
			'menu' => 'NGFB',		// menu item label
			'full' => 'NGFB',		// full plugin name
			'full_pro' => 'NGFB Pro',
			'update_hours' => 24,		// check for pro updates
			'cache' => array(
				'file' => true,
				'object' => true,
				'transient' => true,
			),
			'lib' => array(			// libraries
				'dashboard' => array (
					'welcome' => 'Welcome to the NextGEN Facebook (NGFB) plugin!',
				),
				'setting' => array (
					'contact' => 'Contact Methods',
				),
				'submenu' => array (
					'general' => 'General',
					'advanced' => 'Advanced',
					'sharing' => 'Buttons',
					'style' => 'Styles',
					'readme' => 'Read Me',
					'setup' => 'Setup Guide',
					'whatsnew' => 'What\'s New',
				),
				'sitesubmenu' => array(
					'network' => 'Network',
					'readme' => 'Read Me',
					'setup' => 'Setup Guide',
					'whatsnew' => 'What\'s New',
				),
				'website' => array(
					'facebook' => 'Facebook', 
					'gplus' => 'GooglePlus',
					'twitter' => 'Twitter',
					'linkedin' => 'LinkedIn',
					'pinterest' => 'Pinterest',
					'buffer' => 'Buffer',
					'reddit' => 'Reddit',
					'managewp' => 'ManageWP',
					'stumbleupon' => 'StumbleUpon',
					'tumblr' => 'Tumblr',
					'youtube' => 'YouTube',
					'skype' => 'Skype',
				),
				'shortcode' => array(
					'sharing' => 'Sharing',
				),
				'widget' => array(
					'sharing' => 'Sharing',
				),
				'gpl' => array(
					'admin' => array(
						'general' => 'General Settings',
						'advanced' => 'Advanced Settings',
						'sharing' => 'Button Settings',
						'style' => 'Style Settings',
						'apikeys' => 'API Key Settings',
						'postmeta' => 'Post Social Settings',
						'user' => 'User Social Settings',
					),
					'forum' => array(
						'bbpress' => 'bbPress',
					),
					'social' => array(
						'buddypress' => 'BuddyPress',
					),
					'util' => array(
						'postmeta' => 'Post Social Settings',
						'user' => 'User Social Settings',
					),
				),
				'pro' => array(
					'admin' => array(
						'general' => 'General Settings',
						'advanced' => 'Advanced Settings',
						'sharing' => 'Button Settings',
						'style' => 'Style Settings',
						'apikeys' => 'API Key Settings',
						'postmeta' => 'Post Social Settings',
						'user' => 'User Social Settings',
					),
					'ecom' => array(
						'edd' => 'Easy Digital Downloads',
						'marketpress' => 'MarketPress',
						'woocommerce' => 'WooCommerce',
						'wpecommerce' => 'WP e-Commerce',
					),
					'forum' => array(
						'bbpress' => 'bbPress',
					),
					'head' => array(
						'twittercard' => 'Twitter Cards',
					),
					'lang' => array(
						'polylang' => 'Polylang',
					),
					'media' => array(
						'gravatar' => 'Author Gravatar',
						'ngg' => 'NextGEN Gallery',
						'photon' => 'Jetpack Photon',
						'slideshare' => 'Slideshare API',
						'vimeo' => 'Vimeo Video API',
						'wistia' => 'Wistia Video API',
						'youtube' => 'YouTube Video / Playlist API',
					),
					'seo' => array(
						'aioseop' => 'All in One SEO Pack',
						'wpseo' => 'WordPress SEO',
					),
					'social' => array(
						'buddypress' => 'BuddyPress',
					),
					'util' => array(
						'language' => 'Publisher Language',
						'shorten' => 'URL Shortener',
						'postmeta' => 'Post Social Settings',
						'user' => 'User Social Settings',
					),
				),
			),
			'opt' => array(				// options
				'version' => '291',		// increment when changing default options
				'defaults' => array(
					'options_filtered' => false,
					'options_version' => '',
					'schema_desc_len' => 300,		// meta itemprop="description" maximum text length
					'seo_desc_len' => 156,			// meta name="description" maximum text length
					'seo_author_name' => 'none',		// meta name="author" format
					'seo_def_author_id' => 0,
					'seo_def_author_on_index' => 0,
					'seo_def_author_on_search' => 0,
					'link_author_field' => '',		// default value set by NgfbOptions::get_defaults()
					'link_publisher_url' => '',
					'fb_admins' => '',
					'fb_app_id' => '',
					'fb_lang' => 'en_US',
					'og_site_name' => '',
					'og_site_description' => '',
					'og_publisher_url' => '',
					'og_art_section' => 'none',
					'og_img_width' => 800,
					'og_img_height' => 800,
					'og_img_crop' => 1,
					'og_img_max' => 1,
					'og_vid_max' => 1,
					'og_vid_https' => 1,
					'og_def_img_id_pre' => 'wp',
					'og_def_img_id' => '',
					'og_def_img_url' => '',
					'og_def_img_on_index' => 1,
					'og_def_img_on_author' => 0,
					'og_def_img_on_search' => 0,
					'og_def_vid_url' => '',
					'og_def_vid_on_index' => 1,
					'og_def_vid_on_author' => 0,
					'og_def_vid_on_search' => 0,
					'og_def_author_id' => 0,
					'og_def_author_on_index' => 0,
					'og_def_author_on_search' => 0,
					'og_ngg_tags' => 0,
					'og_page_parent_tags' => 0,
					'og_page_title_tag' => 0,
					'og_author_field' => '',		// default value set by NgfbOptions::get_defaults()
					'og_author_fallback' => 0,
					'og_title_sep' => '-',
					'og_title_len' => 70,
					'og_desc_len' => 300,
					'og_desc_hashtags' => 3,
					'og_desc_strip' => 0,
					'rp_author_name' => 'display_name',     // rich-pin specific article:author
					'rp_img_width' => 800,
					'rp_img_height' => 800,
					'rp_img_crop' => 0,
					'tc_enable' => 1,
					'tc_site' => '',
					'tc_desc_len' => 200,
					// summary card
					'tc_sum_width' => 200,
					'tc_sum_height' => 200,
					'tc_sum_crop' => 1,
					// large image summary card
					'tc_lrgimg_width' => 300,
					'tc_lrgimg_height' => 300,
					'tc_lrgimg_crop' => 0,
					// photo card
					'tc_photo_width' => 800,
					'tc_photo_height' => 800,
					'tc_photo_crop' => 0,
					// gallery card
					'tc_gal_min' => 4,
					'tc_gal_width' => 300,
					'tc_gal_height' => 300,
					'tc_gal_crop' => 0,
					// product card
					'tc_prod_width' => 300,
					'tc_prod_height' => 300,
					'tc_prod_crop' => 1,			// prefers square product images
					'tc_prod_def_l2' => 'Location',
					'tc_prod_def_d2' => 'Unknown',
					// enable/disable header html tags
					'add_link_rel_author' => 1,
					'add_link_rel_publisher' => 1,
					'add_meta_property_fb:admins' => 1,
					'add_meta_property_fb:app_id' => 1,
					'add_meta_property_og:locale' => 1,
					'add_meta_property_og:site_name' => 1,
					'add_meta_property_og:description' => 1,
					'add_meta_property_og:title' => 1,
					'add_meta_property_og:type' => 1,
					'add_meta_property_og:url' => 1,
					'add_meta_property_og:image' => 1,
					'add_meta_property_og:image:secure_url' => 1,
					'add_meta_property_og:image:width' => 1,
					'add_meta_property_og:image:height' => 1,
					'add_meta_property_og:video' => 1,
					'add_meta_property_og:video:secure_url' => 1,
					'add_meta_property_og:video:width' => 1,
					'add_meta_property_og:video:height' => 1,
					'add_meta_property_og:video:type' => 1,
					'add_meta_property_article:author' => 1,
					'add_meta_property_article:publisher' => 1,
					'add_meta_property_article:published_time' => 1,
					'add_meta_property_article:modified_time' => 1,
					'add_meta_property_article:section' => 1,
					'add_meta_property_article:tag' => 1,
					'add_meta_property_product:price:amount' => 1,
					'add_meta_property_product:price:currency' => 1,
					'add_meta_property_product:availability' => 1,
					'add_meta_name_twitter:card' => 1,
					'add_meta_name_twitter:creator' => 1,
					'add_meta_name_twitter:domain' => 1,
					'add_meta_name_twitter:site' => 1,
					'add_meta_name_twitter:title' => 1,
					'add_meta_name_twitter:description' => 1,
					'add_meta_name_twitter:image' => 1,
					'add_meta_name_twitter:image:width' => 1,
					'add_meta_name_twitter:image:height' => 1,
					'add_meta_name_twitter:image0' => 1,
					'add_meta_name_twitter:image1' => 1,
					'add_meta_name_twitter:image2' => 1,
					'add_meta_name_twitter:image3' => 1,
					'add_meta_name_twitter:player' => 1,
					'add_meta_name_twitter:player:width' => 1,
					'add_meta_name_twitter:player:height' => 1,
					'add_meta_name_twitter:data1' => 1,
					'add_meta_name_twitter:label1' => 1,
					'add_meta_name_twitter:data2' => 1,
					'add_meta_name_twitter:label2' => 1,
					'add_meta_name_twitter:data3' => 1,
					'add_meta_name_twitter:label3' => 1,
					'add_meta_name_twitter:data4' => 1,
					'add_meta_name_twitter:label4' => 1,
					'add_meta_name_generator' => 1,
					'add_meta_name_author' => 1,
					'add_meta_name_description' => 0,
					'add_meta_itemprop_description' => 1,
					// advanced plugin options
					'plugin_version' => '',
					'plugin_tid' => '',
					'plugin_display' => 'basic',
					'plugin_preserve' => 0,
					'plugin_debug' => 0,
					'plugin_filter_content' => 1,
					'plugin_filter_excerpt' => 0,
					'plugin_filter_lang' => 1,
					'plugin_shortcodes' => 1,
					'plugin_widgets' => 1,
					'plugin_auto_img_resize' => 1,
					'plugin_ignore_small_img' => 1,
					'plugin_gravatar_api' => 1,
					'plugin_slideshare_api' => 1,
					'plugin_vimeo_api' => 1,
					'plugin_wistia_api' => 1,
					'plugin_youtube_api' => 1,
					'plugin_cf_vid_url' => '_format_video_embed',
					'plugin_add_to_user' => 1,
					'plugin_add_to_post' => 1,
					'plugin_add_to_page' => 1,
					'plugin_add_to_attachment' => 1,
					'plugin_verify_certs' => 0,
					'plugin_file_cache_hrs' => 0,
					'plugin_object_cache_exp' => 21600,	// 6 hours
					'plugin_cm_fb_name' => 'facebook', 
					'plugin_cm_fb_label' => 'Facebook URL', 
					'plugin_cm_fb_enabled' => 1,
					'plugin_cm_gp_name' => 'gplus', 
					'plugin_cm_gp_label' => 'Google+ URL', 
					'plugin_cm_gp_enabled' => 1,
					'plugin_cm_linkedin_name' => 'linkedin', 
					'plugin_cm_linkedin_label' => 'LinkedIn URL', 
					'plugin_cm_linkedin_enabled' => 0,
					'plugin_cm_pin_name' => 'pinterest', 
					'plugin_cm_pin_label' => 'Pinterest URL', 
					'plugin_cm_pin_enabled' => 0,
					'plugin_cm_tumblr_name' => 'tumblr', 
					'plugin_cm_tumblr_label' => 'Tumblr URL', 
					'plugin_cm_tumblr_enabled' => 0,
					'plugin_cm_twitter_name' => 'twitter', 
					'plugin_cm_twitter_label' => 'Twitter @username', 
					'plugin_cm_twitter_enabled' => 1,
					'plugin_cm_yt_name' => 'youtube', 
					'plugin_cm_yt_label' => 'YouTube Channel URL', 
					'plugin_cm_yt_enabled' => 0,
					'plugin_cm_skype_name' => 'skype', 
					'plugin_cm_skype_label' => 'Skype Username', 
					'plugin_cm_skype_enabled' => 0,
					// wordpress contact methods
					'wp_cm_aim_name' => 'aim', 
					'wp_cm_aim_label' => 'AIM', 
					'wp_cm_aim_enabled' => 1,
					'wp_cm_jabber_name' => 'jabber', 
					'wp_cm_jabber_label' => 'Jabber / Google Talk', 
					'wp_cm_jabber_enabled' => 1,
					'wp_cm_yim_name' => 'yim',
					'wp_cm_yim_label' => 'Yahoo IM', 
					'wp_cm_yim_enabled' => 1,
				),
				'site_defaults' => array(
					'options_filtered' => false,
					'options_version' => '',
					'plugin_version' => '',
					'plugin_tid' => '',
					'plugin_tid:use' => 'default',
					'plugin_object_cache_exp' => 21600,	// 6 hours
					'plugin_object_cache_exp:use' => 'default',
				),
				'pre' => array(
					'facebook' => 'fb', 
					'gplus' => 'gp',
					'twitter' => 'twitter',
					'linkedin' => 'linkedin',
					'pinterest' => 'pin',
					'buffer' => 'buffer',
					'reddit' => 'reddit',
					'managewp' => 'managewp',
					'stumbleupon' => 'stumble',
					'tumblr' => 'tumblr',
					'youtube' => 'yt',
					'skype' => 'skype',
				),
			),
			'wp' => array(				// wordpress
				'min_version' => '3.0',		// minimum wordpress version
				'cm' => array(
					'aim' => 'AIM',
					'jabber' => 'Jabber / Google Talk',
					'yim' => 'Yahoo IM',
				),
			),
			'url' => array(
				'review' => 'http://wordpress.org/support/view/plugin-reviews/nextgen-facebook#postform',
				'readme' => 'http://plugins.svn.wordpress.org/nextgen-facebook/trunk/readme.txt',
				'setup' => 'http://plugins.svn.wordpress.org/nextgen-facebook/trunk/setup.html',
				'changelog' => 'http://surniaulula.com/extend/plugins/nextgen-facebook/changelog/',
				'purchase' => 'http://surniaulula.com/extend/plugins/nextgen-facebook/',
				'codex' => 'http://surniaulula.com/codex/plugins/nextgen-facebook/',
				'faq' => 'http://surniaulula.com/codex/plugins/nextgen-facebook/faq/',
				'notes' => 'http://surniaulula.com/codex/plugins/nextgen-facebook/notes/',
				'feed' => 'http://surniaulula.com/category/application/wordpress/wp-plugins/ngfb/feed/',
				'support' => 'http://wordpress.org/support/plugin/nextgen-facebook',
				'pro_support' => 'http://support.ngfb.surniaulula.com/',
				'pro_ticket' => 'http://ticket.ngfb.surniaulula.com/',
				'pro_update' => 'http://update.surniaulula.com/extend/plugins/nextgen-facebook/update/',
			),
			'follow' => array(
				'size' => 32,
				'src' => array(
					'facebook.png' => 'https://www.facebook.com/SurniaUlulaCom',
					'gplus.png' => 'https://plus.google.com/+SurniaUlula/',
					'linkedin.png' => 'https://www.linkedin.com/in/jsmoriss',
					'twitter.png' => 'https://twitter.com/surniaululacom',
					'youtube.png' => 'https://www.youtube.com/user/SurniaUlulaCom',
					'feed.png' => 'http://feed.surniaulula.com/category/application/wordpress/wp-plugins/ngfb/feed/',
				),
			),
			'form' => array(
				'tooltip_class' => 'sucom_tooltip',
				'max_desc_hashtags' => 10,
				'max_media_items' => 20,
				'file_cache_hours' => array( 0, 1, 3, 6, 9, 12, 24, 36, 48, 72, 168 ),
				'js_locations' => array( 'none' => '[none]', 'header' => 'Header', 'footer' => 'Footer' ),
				'caption_types' => array( 'none' => '[none]', 'title' => 'Title Only', 'excerpt' => 'Excerpt Only', 'both' => 'Title and Excerpt' ),
				'display_options' => array( 'basic' => 'Basic Plugin Options', 'all' => 'All Plugin Options' ),
				'user_name_fields' => array( 'none' => '[none]', 'fullname' => 'First and Last Names', 'display_name' => 'Display Name', 'nickname' => 'Nickname' ),
			),
			'head' => array(
				'min_img_dim' => 200,
				'min_desc_len' => 156,
			),
		);

		public static function get_config( $idx = '' ) { 
			// remove the sharing libs if social sharing features are disabled
			if ( defined( 'NGFB_SOCIAL_SHARING_DISABLE' ) && NGFB_SOCIAL_SHARING_DISABLE ) {
				unset (
					self::$cf['lib']['submenu']['sharing'],
					self::$cf['lib']['submenu']['style'],
					self::$cf['lib']['shortcode']['sharing'],
					self::$cf['lib']['widget']['sharing'],
					self::$cf['lib']['gpl']['admin']['sharing'],
					self::$cf['lib']['gpl']['admin']['style'],
					self::$cf['lib']['gpl']['admin']['apikeys'],
					self::$cf['lib']['pro']['admin']['sharing'],
					self::$cf['lib']['pro']['admin']['style'],
					self::$cf['lib']['pro']['admin']['apikeys'],
					self::$cf['lib']['pro']['util']['shorten']
				);
				self::$cf['lib']['website'] = array();
			}
			if ( ! empty( $idx ) ) {
				if ( array_key_exists( $idx, self::$cf ) )
					return self::$cf[$idx];
				else return false;
			} else return self::$cf;
		}

		public static function set_constants( $plugin_filepath ) { 

			$cf = self::get_config();

			define( 'NGFB_FILEPATH', $plugin_filepath );						
			define( 'NGFB_PLUGINDIR', trailingslashit( plugin_dir_path( $plugin_filepath ) ) );
			define( 'NGFB_PLUGINBASE', plugin_basename( $plugin_filepath ) );
			define( 'NGFB_TEXTDOM', $cf['slug'] );
			define( 'NGFB_URLPATH', trailingslashit( plugins_url( '', $plugin_filepath ) ) );
			define( 'NGFB_NONCE', md5( NGFB_PLUGINDIR.'-'.$cf['version'] ) );

			/*
			 * Allow some constants to be pre-defined in wp-config.php
			 */

			if ( defined( 'NGFB_DEBUG' ) && 
				! defined( 'NGFB_HTML_DEBUG' ) )
					define( 'NGFB_HTML_DEBUG', NGFB_DEBUG );

			if ( ! defined( 'NGFB_CACHEDIR' ) )
				define( 'NGFB_CACHEDIR', NGFB_PLUGINDIR.'cache/' );

			if ( ! defined( 'NGFB_CACHEURL' ) )
				define( 'NGFB_CACHEURL', NGFB_URLPATH.'cache/' );

			if ( ! defined( 'NGFB_OPTIONS_NAME' ) )
				define( 'NGFB_OPTIONS_NAME', $cf['lca'].'_options' );

			if ( ! defined( 'NGFB_SITE_OPTIONS_NAME' ) )
				define( 'NGFB_SITE_OPTIONS_NAME', $cf['lca'].'_site_options' );

			if ( ! defined( 'NGFB_META_NAME' ) )
				define( 'NGFB_META_NAME', '_'.$cf['lca'].'_meta' );

			if ( ! defined( 'NGFB_MENU_PRIORITY' ) )
				define( 'NGFB_MENU_PRIORITY', '99.11' );

			if ( ! defined( 'NGFB_INIT_PRIORITY' ) )
				define( 'NGFB_INIT_PRIORITY', 13 );

			if ( ! defined( 'NGFB_HEAD_PRIORITY' ) )
				define( 'NGFB_HEAD_PRIORITY', 10 );

			if ( ! defined( 'NGFB_SOCIAL_PRIORITY' ) )
				define( 'NGFB_SOCIAL_PRIORITY', 100 );
			
			if ( ! defined( 'NGFB_FOOTER_PRIORITY' ) )
				define( 'NGFB_FOOTER_PRIORITY', 100 );
			
			if ( ! defined( 'NGFB_DEBUG_FILE_EXP' ) )
				define( 'NGFB_DEBUG_FILE_EXP', 300 );

			if ( ! defined( 'NGFB_CURL_USERAGENT' ) )
				define( 'NGFB_CURL_USERAGENT', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:18.0) Gecko/20100101 Firefox/18.0' );

			if ( ! defined( 'NGFB_CURL_CAINFO' ) )
				define( 'NGFB_CURL_CAINFO', NGFB_PLUGINDIR.'share/curl/cacert.pem' );

			if ( ! defined( 'NGFB_TOPICS_LIST' ) )
				define( 'NGFB_TOPICS_LIST', NGFB_PLUGINDIR.'share/topics.txt' );
		}

		public static function require_libs( $plugin_filepath ) {
			
			$cf = self::get_config();
			$plugin_dir = NGFB_PLUGINDIR;

			require_once( $plugin_dir.'lib/com/util.php' );
			require_once( $plugin_dir.'lib/com/cache.php' );
			require_once( $plugin_dir.'lib/com/notice.php' );
			require_once( $plugin_dir.'lib/com/script.php' );
			require_once( $plugin_dir.'lib/com/style.php' );
			require_once( $plugin_dir.'lib/com/webpage.php' );
			require_once( $plugin_dir.'lib/com/opengraph.php' );

			require_once( $plugin_dir.'lib/check.php' );
			require_once( $plugin_dir.'lib/util.php' );
			require_once( $plugin_dir.'lib/options.php' );
			require_once( $plugin_dir.'lib/postmeta.php' );
			require_once( $plugin_dir.'lib/user.php' );
			require_once( $plugin_dir.'lib/media.php' );
			require_once( $plugin_dir.'lib/head.php' );

			if ( is_admin() ) {
				require_once( $plugin_dir.'lib/messages.php' );
				require_once( $plugin_dir.'lib/admin.php' );
				require_once( $plugin_dir.'lib/com/form.php' );
				require_once( $plugin_dir.'lib/ext/parse-readme.php' );
			} else require_once( $plugin_dir.'lib/functions.php' );

			if ( ( ! defined( 'NGFB_SOCIAL_SHARING_DISABLE' ) || 
				( defined( 'NGFB_SOCIAL_SHARING_DISABLE' ) && ! NGFB_SOCIAL_SHARING_DISABLE ) ) &&
				empty( $_SERVER['NGFB_SOCIAL_SHARING_DISABLE'] ) &&
				file_exists( $plugin_dir.'lib/sharing.php' ) )
					require_once( $plugin_dir.'lib/sharing.php' );

			if ( ( ! defined( 'NGFB_OPEN_GRAPH_DISABLE' ) || 
				( defined( 'NGFB_OPEN_GRAPH_DISABLE' ) && ! NGFB_OPEN_GRAPH_DISABLE ) ) &&
				empty( $_SERVER['NGFB_OPEN_GRAPH_DISABLE'] ) &&
				file_exists( $plugin_dir.'lib/opengraph.php' ) )
					require_once( $plugin_dir.'lib/opengraph.php' );	// extends lib/com/opengraph.php

			// additional classes are loaded and extended by the pro addon construct
			if ( file_exists( $plugin_dir.'lib/pro/addon.php' ) )
				require_once( $plugin_dir.'lib/pro/addon.php' );

			add_filter( 'ngfb_load_lib', array( 'NgfbConfig', 'load_lib' ), 10, 2 );
		}

		public static function load_lib( $loaded = false, $filepath = '' ) {
			if ( $loaded === false && ! empty( $filepath ) ) {
				$filepath = NGFB_PLUGINDIR.'lib/'.$filepath.'.php';
				if ( file_exists( $filepath ) ) {
					require_once( $filepath );
					return true;
				}
			}
			return $loaded;
		}
	}
}

?>
