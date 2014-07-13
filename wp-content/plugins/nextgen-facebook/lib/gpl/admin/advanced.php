<?php
/*
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.txt
Copyright 2012-2014 - Jean-Sebastien Morisset - http://surniaulula.com/
*/

if ( ! defined( 'ABSPATH' ) ) 
	die( 'These aren\'t the droids you\'re looking for...' );

if ( ! class_exists( 'NgfbAdminAdvanced' ) ) {

	class NgfbAdminAdvanced {

		public function __construct( &$plugin ) {
			$this->p =& $plugin;
			$this->p->util->add_plugin_filters( $this, array( 
				'plugin_content_rows' => 2,
				'plugin_social_rows' => 2,
				'plugin_cache_rows' => 2,
				'taglist_tags_rows' => 2,
			), 20 );
		}

		public function filter_plugin_content_rows( $rows, $form ) {
			$rows[] = '<td colspan="2" align="center">'.$this->p->msgs->get( 'pro-feature-msg' ).'</td>';

			$rows[] = $this->p->util->th( 'Apply Content Filters', null, 'plugin_filter_content' ).
			'<td class="blank">'.$form->get_fake_checkbox( 'plugin_filter_content' ).'</td>';

			$rows[] = $this->p->util->th( 'Apply Excerpt Filters', null, 'plugin_filter_excerpt' ).
			'<td class="blank">'.$form->get_fake_checkbox( 'plugin_filter_excerpt' ).'</td>';

			if ( $this->p->options['plugin_display'] == 'all' ) {
				$rows[] = $this->p->util->th( 'Language uses WP Locale', null, 'plugin_filter_lang' ).
				'<td class="blank">'.$form->get_fake_checkbox( 'plugin_filter_lang' ).'</td>';

				if ( ! empty( $this->p->cf['lib']['shortcode'] ) ) {
					$rows[] = $this->p->util->th( 'Enable Shortcode(s)', 'highlight', 'plugin_shortcodes' ).
					'<td class="blank">'.$form->get_fake_checkbox( 'plugin_shortcodes' ).'</td>';
				}
	
				if ( ! empty( $this->p->cf['lib']['widget'] ) ) {
					$rows[] = $this->p->util->th( 'Enable Widget(s)', 'highlight', 'plugin_widgets' ).
					'<td class="blank">'.$form->get_fake_checkbox( 'plugin_widgets' ).'</td>';
				}
	
				$rows[] =  $this->p->util->th( 'Auto-Resize Media Images', null, 'plugin_auto_img_resize' ).
				'<td class="blank">'.$form->get_fake_checkbox( 'plugin_auto_img_resize' ).'</td>';
	
				$rows[] =  $this->p->util->th( 'Ignore Small Images in Content', null, 'plugin_ignore_small_img' ).
				'<td class="blank">'.$form->get_fake_checkbox( 'plugin_ignore_small_img' ).'</td>';
			}

			$rows[] = $this->p->util->th( 'Check for Embedded Media', null, 'plugin_embedded_media' ).
			'<td class="blank">'.
			'<p>'.$form->get_fake_checkbox( 'plugin_slideshare_api' ).' Slideshare Presentations</p>'.
			'<p>'.$form->get_fake_checkbox( 'plugin_vimeo_api' ).' Vimeo Videos</p>'.
			'<p>'.$form->get_fake_checkbox( 'plugin_wistia_api' ).' Wistia Videos</p>'.
			'<p>'.$form->get_fake_checkbox( 'plugin_youtube_api' ).' YouTube Videos and Playlists</p>'.
			'</td>';

			return $rows;
		}

		public function filter_plugin_social_rows( $rows, $form ) {
			$checkboxes = '<p>'.$form->get_fake_checkbox( 'plugin_add_to_user' ).' User Profile</p>';

			foreach ( $this->p->util->get_post_types( 'plugin' ) as $post_type )
				$checkboxes .= '<p>'.$form->get_fake_checkbox( 'plugin_add_to_'.$post_type->name ).' '.
					$post_type->label.' '.( empty( $post_type->description ) ? '' : '('.$post_type->description.')' ).'</p>';

			$rows[] = '<td colspan="2" align="center">'.$this->p->msgs->get( 'pro-feature-msg' ).'</td>';

			$rows[] = $this->p->util->th( 'Show Social Settings on', null, 'plugin_add_to' ).
			'<td class="blank">'.$checkboxes.'</td>';
			
			if ( $this->p->options['plugin_display'] == 'all' ) {
				$rows[] = $this->p->util->th( 'Video URL Custom Field', null, 'plugin_cf_vid_url' ).
				'<td class="blank">'.$form->get_hidden( 'plugin_cf_vid_url' ).
				$this->p->options['plugin_cf_vid_url'].'</td>';
			}
			
			return $rows;
		}

		public function filter_plugin_cache_rows( $rows, $form ) {
			$rows[] = '<td colspan="2" align="center">'.$this->p->msgs->get( 'pro-feature-msg' ).'</td>';

			$rows[] = $this->p->util->th( 'Object Cache Expiry', null, 'plugin_object_cache_exp' ).
			'<td class="blank">'.$form->get_hidden( 'plugin_object_cache_exp' ).
			$this->p->options['plugin_object_cache_exp'].' seconds</td>';

			return $rows;
		}

		public function filter_taglist_tags_rows( $rows, $form, $tag = '[^_]+' ) {
			$og_cols = 2;
			$cells = array();
			foreach ( $this->p->opt->get_defaults() as $opt => $val ) {
				if ( preg_match( '/^add_('.$tag.')_([^_]+)_(.+)$/', $opt, $match ) ) {
					$highlight = $opt === 'add_meta_name_description' ? ' highlight' : '';
					$cells[] = '<!-- '.( implode( ' ', $match ) ).' -->'.
						'<td class="checkbox blank">'.$form->get_fake_checkbox( $opt ).'</td>'.
						'<td class="xshort'.$highlight.'">'.$match[1].'</td>'.
						'<td class="taglist'.$highlight.'">'.$match[2].'</td>'.
						'<th class="taglist'.$highlight.'">'.$match[3].'</th>'."\n";
				}
			}
			sort( $cells );
			$col_rows = array();
			$per_col = ceil( count( $cells ) / $og_cols );
			foreach ( $cells as $num => $cell ) {
				if ( empty( $col_rows[ $num % $per_col ] ) )
					$col_rows[ $num % $per_col ] = '';	// initialize the array
				$col_rows[ $num % $per_col ] .= $cell;		// create the html for each row
			}
			return array_merge( $rows, $col_rows );
		}
	}
}

?>
