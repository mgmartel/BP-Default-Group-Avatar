<?php
/*
  Plugin Name: BP Default Group Avatar
  Plugin URI: http://trenvo.com
  Description: Adds a default group avatar to BuddyPress.
  Version: 0.2
  Author: Mike Martel
  Author URI: http://trenvo.com
 */

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

/**
 * Version number
 */
define('BPDGA_VERSION', '0.2');

/**
 * PATHs and URLs
 */
define('BPDGA_DIR', plugin_dir_path(__FILE__));
define('BPDGA_URL', plugin_dir_url(__FILE__));

/**
 * Require the admin page
 */
require_once ( BPDGA_DIR . 'bp-default-group-avatar-admin.php' );

if (!class_exists('BP_DefaultGroupAvatar')) :

    class BP_DefaultGroupAvatar    {

        /**
         * Creates an instance of the BP_DefaultGroupAvatar class
         *
         * @return BP_DefaultGroupAvatar object
         * @static
        */
        public static function &init() {
            return new BP_DefaultGroupAvatar;
        }

        /**
         * Constructor
         */
        public function __construct() {
            add_filter( 'bp_core_fetch_avatar_no_grav', array ( &$this, 'maybe_load_grav' ), 99 );
        }

            /**
             * PHP4
             */
            public function BP_DefaultGroupAvatar() {
                $this->__construct();
            }

        /**
         * If someone already disabled Gravatar loading, we're done.
         * If we want to keep Gravatars for users, we're screwed.
         *
         * @param boolean $no_grav
         * @return true (always)
         */
        public function maybe_load_grav ( $no_grav ) {
            if ( ! $no_grav ) {
                add_filter( 'bp_core_default_avatar_user', array ( &$this, 'takeover_gravatars' ), 10, 2 );
                add_filter( 'bp_core_default_avatar_group', array ( &$this, 'takeover_gravatars' ), 10, 2 );
                add_filter( 'bp_core_default_avatar_blog', array ( &$this, 'takeover_gravatars' ), 10, 2 );
            }
            return true;
        }

        public function get_default_avatar() {
            if ( $avatar = get_option('BPDGA_img_url') )
                return $avatar;
            return BPDGA_URL . 'default.jpg';
        }

        /**
         * All of that so we can load this switch!
         *
         * @param str $mysteryman
         * @param arr $params
         * @return str Avatar url
         */
        public function takeover_gravatars( $mysteryman, $params ) {
            switch ( $params['object'] ) {
                case 'group' :
                    return $this->get_default_avatar();
                    break;
                default :
                    return $this->load_gravatar( $params );
                    break;
            }
        }

        /**
         * BPs default Gravatar handling in a function
         *
         * From bp-core-avatars.php
         *
         * @global BuddyPress $bp
         * @param arr $params
         * @return str Gravatar URL
         */
        protected function load_gravatar( $params ) {
            global $bp;
            extract( $params, EXTR_SKIP );

            // Set gravatar size
            if ( false !== $width ) {
                    $grav_size = $width;
            } else if ( 'full' == $type ) {
                    $grav_size = bp_core_avatar_full_width();
            } else if ( 'thumb' == $type ) {
                    $grav_size = bp_core_avatar_thumb_width();
            }

            // Set gravatar type
            if ( empty( $bp->grav_default->{$object} ) ) {
                    $default_grav = 'wavatar';
            } else if ( 'mystery' == $bp->grav_default->{$object} ) {
                    $default_grav = apply_filters( 'bp_core_mysteryman_src', bp_core_avatar_default(), $grav_size );
            } else {
                    $default_grav = $bp->grav_default->{$object};
            }

            // Set gravatar object
            if ( empty( $email ) ) {
                    if ( 'user' == $object ) {
                            $email = bp_core_get_user_email( $item_id );
                    } else if ( 'group' == $object || 'blog' == $object ) {
                            $email = "{$item_id}-{$object}@{bp_get_root_domain()}";
                    }
            }

            // Set host based on if using ssl
            $host = 'http://www.gravatar.com/avatar/';
            if ( is_ssl() ) {
                    $host = 'https://secure.gravatar.com/avatar/';
            }

            // Filter gravatar vars
            $email    = apply_filters( 'bp_core_gravatar_email', $email, $item_id, $object );
            $gravatar = apply_filters( 'bp_gravatar_url', $host ) . md5( strtolower( $email ) ) . '?d=' . $default_grav . '&amp;s=' . $grav_size;

            // Gravatar rating; http://bit.ly/89QxZA
            $rating = get_option( 'avatar_rating' );
            if ( ! empty( $rating ) )
                    $gravatar .= "&amp;r={$rating}";

            return $gravatar;
        }
    }

    add_action('bp_include', array('BP_DefaultGroupAvatar', 'init'));
endif;