<?php

class WP_frontend_posts {

  public function __construct() {

    add_action('wp_enqueue_scripts', array($this, 'scripts'));

    add_action('wp_ajax_nopriv_save_fields', array($this, 'save_fields'));
    add_action('wp_ajax_save_fields', array($this, 'save_fields'));

    add_action('wp_ajax_nopriv_load_fields', array($this, 'load_fields'));
    add_action('wp_ajax_load_fields', array($this, 'load_fields'));

  }

  function scripts() {

    wp_enqueue_script('saving-fields', get_template_directory_uri() . '/js/scripts.js', array( 'jquery'), null, true);

    wp_localize_script( 'saving-fields', 'settings', array(
      'ajaxurl'  => admin_url( 'admin-ajax.php'),
    ));

  }

  function load_fields() {

    $data = $_POST;

    if (false == check_ajax_referer('load_fields_' . $data['post_id'], 'nonce', false)) {
      wp_send_json_error();
    } 

    $field_reviewer = get_field('reviewer', $data['post_id']);
    $field_ico_status = get_field('ico_status', $data['post_id']);
    $the_id = $data['post_id'];

    $content.= '
    <div class="col-3 mb-2">
      <label >Reviewer</label>
      <input class="reviewer'.$the_id.' form-control w-100" placeholder="Enter value" value="'. $field_reviewer .'"></input>
    </div>
    ';

    $content .= '
    <div class="col-3 mb-2">
      <label >ICO status</label>
      <input class="ico-status'.$the_id.' form-control w-100" placeholder="Enter value" value="'. $field_ico_status .'"></input>
    </div>
    ';

    // etc. etc.

    wp_send_json_success($content);

  }

  function save_fields() {

    $data = $_POST;

    if (false == check_ajax_referer('save_fields_' . $data['post_id'], 'nonce', false)) {
      wp_send_json_error();
    } 

    update_field('ico_status', sanitize_text_field($data['ico_status']), $data['post_id']);
    update_field('reviewer', sanitize_text_field($data['reviewer']), $data['post_id']);
    
    $the_id = $data['post_id'];
    
    $field_reviewer = get_field('reviewer', $data['post_id']);
    $field_ico_status = get_field('ico_status', $data['post_id']);
    
    $content.= '
    <div class="col-3 mb-2">
      <label >Reviewer</label>
      <input class="reviewer'.$the_id.' form-control w-100" placeholder="Enter value" value="'. $field_reviewer .'"></input>
    </div>
    ';

    $content .= '
    <div class="col-3 mb-2">
      <label >ICO status</label>
      <input class="ico-status'.$the_id.' form-control w-100" placeholder="Enter value" value="'. $field_ico_status .'"></input>
    </div>
    ';

    // etc.
    
    wp_send_json_success($content);
    
  }

}

new WP_frontend_posts();

?>
