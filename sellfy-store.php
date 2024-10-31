<?php
/*
* Plugin Name: Sellfy store
* Plugin URI:
* Description: Sellfy Store plugin allows to create store page for your WordPress page. Just enter your Sellfy username, name your store and you are ready to go! This plugin lets you integrate Sellfy profile page without any coding.
* Version: 1.1
* Author: sellfy
* Author URI: https://sellfy.com/
*/
class SellfyStore {

    var $page_id;
    var $title;
    var $slug;
    var $sellfy_username;

    public function __construct() {
        if( is_admin() ) {
            add_action( 'admin_menu', array( $this, 'register_admin_page' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
            add_action( 'wp_ajax_sellfy_create_store', array( $this, 'create_store' ) );
            add_action( 'wp_ajax_sellfy_delete_store', array( $this, 'delete_store' ) );
            $this->init();
        }
        add_action( 'wp_enqueue_scripts', array( $this, 'public_scripts' ) );
        add_shortcode( 'sellfy_store', array( $this, 'register_shortcode' ) );
    }

    public function init() {
        $this->page_id = get_option( 'sellfy_store_id' );
        $this->title = '';
        $this->slug = '';
        $this->sellfy_username = '';
        $post = $this->get_page();

        if ( $post ) {
            $this->title = $post->post_title;
            $this->slug = $post->post_name;
            $this->sellfy_username = get_option( 'sellfy_username' );
        }
    }

    public function get_page() {
        $post = get_post( $this->page_id );
        return $post;
    }

    public function register_admin_page() {
        add_menu_page( 'Sellfy store settings', 'Sellfy store', 'manage_options', 'sellfy-store-creator/store-admin.php', '', 'dashicons-cart', 79 );
    }

    public function scripts() {
        wp_enqueue_script( 'sellfy-script', plugins_url( '/js/script.js', __FILE__ ), array('jquery') );
        wp_enqueue_style( 'sellfy-style', plugins_url( '/css/style.css', __FILE__ ));
    }

    public function public_scripts() {
        wp_enqueue_script( 'sellfy-embed', plugins_url( '/js/embed.js', __FILE__ ) );
    }

    public function create_store() {
        check_ajax_referer( 'sellfy-store-create', 'security', true );
        $success = 'false';
        $error = '';
        $page_url = '';
        $username = $_POST['sellfy_username'];
        $title = $_POST['sellfy_store_title'];
        $slug = $_POST['sellfy_store_slug'];

        if ($username && $title && $slug) {
            $result = $this->create_post($username, $slug, $title);

            if ( $result['success'] ) {
                $success = true;
                $page_url = $result['permalink'];
            } else {
                $success = false;
                $error = $result['error'];
            }

            $return = array(
                'success'  => $success,
                'error'    => $error,
                'page_url' => $page_url,
                'is_new'   => $result['is_new']
            );

            wp_send_json($return);
        } else {
            $return = array(
                'success' => false,
                'error'   => 'Please fill up all fields!',
            );
            wp_send_json($return);
        }
    }

    public function delete_store() {
        check_ajax_referer( 'sellfy-store-create', 'security', true );
        if($this->page_id) {
            wp_delete_post($this->page_id, true);
        }
        $return = array(
            'success' => ($this->page_id ? true : false)
        );
        wp_send_json($return);
    }

    private function create_post($username, $slug, $title) {
        global $user_ID;
        $success = true;
        $error = '';
        $is_new = true;
        $permalink = '';

        $my_post = array(
            'post_title'    => $title,
            'post_content'  => sprintf('[sellfy_store id="%s"]', $username),
            'post_status'   => 'publish',
            'post_name'     =>  $slug,
            'post_author'   => $user_ID,
            'post_type' => 'page',
            //'post_status' => 'draft',
            'comment_status' => 'closed'
        );

        if ($this->get_page()) {
            $my_post['ID'] = $this->page_id;
            $is_new = false;
            $post_id = wp_update_post( $my_post );
        }
        else {
            $post_id = wp_insert_post( $my_post, true );
        }

        if ( is_wp_error( $post_id ) ) {
            $success = false;
            $error = $post->get_error_message();
        }
        else {
            update_option( 'sellfy_store_id', $post_id );
            update_option( 'sellfy_username', $username );
            $permalink = get_permalink( $post_id );
        }

        $return = array(
            'success'   => $success,
            'error'     => $error,
            'permalink' => $permalink,
            'is_new'    => $is_new
        );
        return $return;
    }

    public function register_shortcode( $atts ) {
        extract( shortcode_atts( array(
            'id' => 'none',
        ), $atts ) );

        if(!$id) {
            $id = 'none';
        }

        $HTML = "<iframe src=\"https://sellfy.com/embed/profile/{$id}\" width=\"100%\" style=\"border:none;\" scrolling=\"no\"></iframe>";

        return $HTML;
    }
}
$sellfy_settings = new SellfyStore();
?>

