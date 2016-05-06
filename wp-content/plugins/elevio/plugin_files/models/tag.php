<?php

class Elevio_Sync_Tag {

    var $id;          // Integer
    var $slug;        // String
    var $title;       // String
    var $description; // String

    function JSON_API_Tag($wp_tag = null) {
        if ($wp_tag) {
            $this->import_wp_object($wp_tag);
        }
    }

    function import_wp_object($wp_tag) {
        $this->id = (int) $wp_tag->term_id;
        $this->slug = $wp_tag->slug;
        $this->title = $wp_tag->name;
    }
}