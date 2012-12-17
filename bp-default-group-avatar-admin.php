<?php
/**
 * Admin page for BP Default Group Avatar - based on Vernon's original plugin
 * http://vfowler.com/2012/02/buddypress-default-group-avatar/
 */

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

if (!class_exists('BP_DefaultGroupAvatar_Admin')) :

    class BP_DefaultGroupAvatar_Admin    {

        /**
         * Creates an instance of the BP_DefaultGroupAvatar_Admin class
         *
         * @return BP_DefaultGroupAvatar_Admin object
         * @static
        */
        public static function &init() {
            static $instance = false;

            if (!$instance) {
                load_plugin_textdomain('bp-dga', false, BPDGA_DIR . '/languages/');
                $instance = new BP_DefaultGroupAvatar_Admin;
            }

            return $instance;
        }

        /**
         * Constructor
         */
        public function __construct() {
            add_action('admin_init', array ( &$this, 'register' ) );
            $this->plugin_menu();
        }

            /**
             * PHP4
             */
            public function BP_DefaultGroupAvatar_Admin() {
                $this->__construct();
            }

        public function register() {
            register_setting('BPDGA_admin_options', 'BPDGA_img_url');
        }

        /**
         * Adds an option submenu page under the BuddyPress menu
         */
        protected function plugin_menu() {
            add_submenu_page('bp-general-settings', __('Default Group Avatar', 'bp-dga'), __('BP Default Group Avatar', 'bp-dga'), 'manage_options', 'group_avatar', array ( &$this, 'plugin_options' ) );
        }

        /**
         * Display the main option's area
         *
         * @global object $wpdb
         */
        public function plugin_options() {
            global $wpdb;
            ?>
            <div class="wrap">
                <h2><?php _e('BuddyPress Default Group Avatar Settings', 'bp-dga') ?></h2>
                <form method="post" action="options.php">
                    <?php wp_nonce_field('update-options'); ?>
                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row"><?php _e('Avatar URL', 'bp-dga') ?></th>
                            <td>
                                <input type="url" size="110" name="BPDGA_img_url" value="<?php echo get_option('BPDGA_img_url'); ?>" placeholder="<?php bloginfo('stylesheet_directory');?>/_inc/images/" />
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" name="action" value="update" />
                    <input type="hidden" name="page_options" value="BPDGA_img_url" />
                    <p class="submit">
                        <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
                    </p>
                </form>
            <?php
            echo __('Your image preview:','bp-dga') . '<br><img src="' . get_option('BPDGA_img_url') .'" />';
        }

    }
    add_action('admin_menu', array('BP_DefaultGroupAvatar_Admin', 'init') );
endif;