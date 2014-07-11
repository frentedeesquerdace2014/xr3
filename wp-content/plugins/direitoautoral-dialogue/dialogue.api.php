<?php
/* Copyright 2010  Ministério da Cultura Brasileiro
 *
 *     Author: Lincoln de Sousa <lincoln@comum.org>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/* Defining extra fields for comments. Since wp 2.9 we have the
 * commentsmeta stuff, so we don't need to change the main comments
 * table. */
define ('DIALOGUE_CF_PARAGRAPH',          '_dialogue_cf_paragraph');
define ('DIALOGUE_CF_NEWTEXTPROPOSAL',    '_dialogue_cf_newtextproposal');

function dialogue_api_parse_content ($content)
{
  $newct = array ();
  $pattern = get_shortcode_regex ();
  $len = preg_match_all ('/'.$pattern.'/s', $content, $paragraphs);
  for ($i = 0; $i < $len; $i++)
    {
      if ($paragraphs[2][$i] != 'commentable')
        continue;
      $attrs = shortcode_parse_atts ($paragraphs[3][$i]);
      $newct[$attrs['id']] = $paragraphs[5][$i];
    }
  return $newct;
}

function dialogue_api_get_comments ($post)
{
  return get_comments ($post, ARRAY_A);
}

function dialogue_api_get_paragraph_comments_count($paragraph, $post) 
{
  global $wpdb;

  $sql = "SELECT COUNT(*) as count FROM {$wpdb->comments} AS c INNER JOIN
    {$wpdb->prefix}commentmeta as m ON (m.comment_ID = c.comment_ID)
    WHERE c.comment_post_ID = %d AND m.meta_key = '" . DIALOGUE_CF_PARAGRAPH . "'
    AND m.meta_value = %s ORDER BY c.comment_ID;";
  $query = $wpdb->prepare ($sql, $post, $paragraph);
  $res = $wpdb->get_results ($query);  
  return $res[0]->count;
}

function dialogue_api_get_paragraph_comments ($paragraph, $post)
{
  global $wpdb;

  $sql = "SELECT c.* FROM {$wpdb->comments} AS c INNER JOIN
    {$wpdb->prefix}commentmeta as m ON (m.comment_ID = c.comment_ID)
    WHERE c.comment_post_ID = %d AND m.meta_key = '" . DIALOGUE_CF_PARAGRAPH . "'
    AND m.meta_value = %s ORDER BY c.comment_ID;";
  $query = $wpdb->prepare ($sql, $post, $paragraph);
  return $wpdb->get_results ($query);
}

function dialogue_api_get_toplevel_paragraph_comments ($paragraph, $post)
{
  global $wpdb;

  $sql = "SELECT c.* FROM {$wpdb->comments} AS c INNER JOIN
    {$wpdb->prefix}commentmeta as m ON (m.comment_ID = c.comment_ID)
    WHERE c.comment_post_ID = %d AND m.meta_key = '" . DIALOGUE_CF_PARAGRAPH . "'
    AND m.meta_value = %s 
    AND c.comment_parent = 0 ORDER BY c.comment_ID;";
  $query = $wpdb->prepare ($sql, $post, $paragraph);
  return $wpdb->get_results ($query);
}

function dialogue_api_get_children_paragraph_comments($comment_id)
{
  global $wpdb;

  $sql = "SELECT * FROM {$wpdb->comments}
    WHERE comment_parent= $comment_id ORDER BY comment_ID;";
  $query = $wpdb->prepare ($sql, $post, $paragraph);
  return $wpdb->get_results ($query);
}

function dialogue_api_get_comment_paragraph ($comment)
{
  return get_comment_meta ($comment, DIALOGUE_CF_PARAGRAPH, true);
}

function dialogue_api_get_tags ()
{
  global $wpdb;
  $sql = "SELECT tag_id, name FROM {$wpdb->prefix}dialogue_comment_tags;";
  return $wpdb->get_results ($sql);
}

function dialogue_api_get_comment_tags ($comment)
{
  global $wpdb;
  $sql = "SELECT t.tag_id, t.name, ct.tag_id, ct.comment_id
    FROM {$wpdb->prefix}dialogue_comment_tags AS t INNER JOIN
    {$wpdb->prefix}dialogue_comment_comment_tags AS ct
    ON (ct.tag_id = t.tag_id) WHERE ct.comment_id = %d
    ORDER BY t.name;";
  $query = $wpdb->prepare ($sql, $comment);
  return $wpdb->get_results ($query);
}

function dialogue_api_process_request ()
{
  if (!empty ($_REQUEST['dialogue_query']))
    {
      $query = json_decode ($_REQUEST['dialogue_query']);
      $error = null;
      switch (json_last_error())
        {
        case JSON_ERROR_DEPTH:
          $error = 'Maximum stack depth exceeded';
          break;
        case JSON_ERROR_CTRL_CHAR:
          $error = 'Unexpected control character found';
          break;
        case JSON_ERROR_SYNTAX:
          $error = 'Syntax error, malformed JSON';
          break;
        case JSON_ERROR_NONE:
          break;
        }
      if ($error != null)
        die(json_encode($error));

      /* I'm not so stupid to allow the user to call an arbitrary
       * function here... neither to pass \b or any other tricky
       * stuff! */
      $func = 'dialogue_api_' . $query->method;
      $params = $query->params;
      die (json_encode (call_user_func_array ($func,  $params)));
    }
}
?>
