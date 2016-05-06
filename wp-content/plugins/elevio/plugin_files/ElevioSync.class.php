<?php

class ElevioSync
{

    public function __construct()
    {
        require_once(dirname(__FILE__).'/models/category.php');
        require_once(dirname(__FILE__).'/models/post.php');
        require_once(dirname(__FILE__).'/models/tag.php');
    }

    public function run($query)
    {
        if ($query === 'categories') {
            return $this->syncCategories();
        } else if ($query === 'posts') {
            return $this->syncTopics();
        }
    }

    public function syncCategories($args = array())
    {
        $wp_categories = get_categories($args);
        $categories = array();
        foreach ($wp_categories as $wp_category) {
          if ($wp_category->term_id == 1 && $wp_category->slug == 'uncategorized') {
            continue;
          }
          $category = new Elevio_Sync_Category($wp_category);
          $categories[] = $category;
        }

        return $categories;

    }


    public function syncTopics($query = false, $wp_posts = false)
    {

        global $post, $wp_query;

        query_posts(http_build_query($_GET));

        $output = array();
        while (have_posts()) {
            the_post();
            if ($wp_posts) {
                $new_post = $post;
            } else {
                $new_post = new Elevio_Sync_Post($post);
            }
            $output[] = $new_post;
        }

        return $output;

    }



  protected function set_posts_query($query = false) {
    global $json_api, $wp_query;

    if (!$query) {
      $query = array();
    }

    $query = array_merge($query, $wp_query->query);

    if ($json_api->query->page) {
      $query['paged'] = $json_api->query->page;
    }

    if ($json_api->query->count) {
      $query['posts_per_page'] = $json_api->query->count;
    }

    if ($json_api->query->post_type) {
      $query['post_type'] = $json_api->query->post_type;
    }

    $query = apply_filters('json_api_query_args', $query);
    if (!empty($query)) {
      query_posts($query);
      do_action('json_api_query', $wp_query);
    }
  }
}
