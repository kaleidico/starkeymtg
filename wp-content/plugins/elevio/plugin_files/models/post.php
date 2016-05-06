<?php

class Elevio_Sync_Post {

  // Note:
  //   JSON_API_Post objects must be instantiated within The Loop.

  var $id;              // Integer
  var $type;            // String
  var $slug;            // String
  var $url;             // String
  var $status;          // String ("draft", "published", or "pending")
  var $title;           // String
  var $title_plain;     // String
  var $content;         // String (modified by read_more query var)
  var $excerpt;         // String
  var $date;            // String (modified by date_format query var)
  var $modified;        // String (modified by date_format query var)
  var $categories;      // Array of objects
  var $tags;            // Array of objects
  var $author;          // Object
  var $comments;        // Array of objects
  var $attachments;     // Array of objects
  var $comment_count;   // Integer
  var $comment_status;  // String ("open" or "closed")
  var $thumbnail;       // String
  var $custom_fields;   // Object (included by using custom_fields query var)

  function Elevio_Sync_Post($wp_post = null) {
    if (!empty($wp_post)) {
      $this->import_wp_object($wp_post);
    }
    // do_action("json_api_{$this->type}_constructor", $this);
  }


  function import_wp_object($wp_post) {
    global $json_api, $post;
    // $date_format = $json_api->query->date_format;
    $this->id = (int) $wp_post->ID;
    setup_postdata($wp_post);
    $this->set_value('type', $wp_post->post_type);
    $this->set_value('title', get_the_title($this->id));
    $this->set_value('title_plain', strip_tags(@$this->title));
    $this->set_content_value();
    $this->set_categories_value();
    $this->set_tags_value();

    // do_action("json_api_import_wp_post", $this, $wp_post);
  }

  function set_value($key, $value) {
      $this->$key = $value;
  }

  function set_content_value() {
    global $json_api;
    $content = get_post_field('post_content', $this->id);
    $content = apply_filters('the_content', $content);
    $this->content = $content;
  }

  function set_categories_value() {
    global $json_api;
      $this->categories = array();
      if ($wp_categories = get_the_category($this->id)) {
        foreach ($wp_categories as $wp_category) {
          $category = new Elevio_Sync_Category($wp_category);
          if ($category->id == 1 && $category->slug == 'uncategorized') {
            // Skip the 'uncategorized' category
            continue;
          }
          $this->categories[] = $category;
        }
      }
  }

  function set_tags_value() {
    global $json_api;
      $this->tags = array();
      if ($wp_tags = get_the_tags($this->id)) {
        foreach ($wp_tags as $wp_tag) {
          $this->tags[] = new Elevio_Sync_Tag($wp_tag);
        }
      }
  }

}
