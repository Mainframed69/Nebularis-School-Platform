<?php
/*
Plugin Name: MasterStudy LMS Learning Management System
Plugin URI: http://masterstudy.stylemixthemes.com/lms-plugin/
Description: Create brilliant lessons with videos, graphs, images, slides and any other attachments thanks to flexible and user-friendly lesson management tool powered by WYSIWYG editor.
As the ultimate LMS WordPress Plugin, MasterStudy makes it simple and hassle-free to build, customize and manage your Online Education WordPress website.
Author: StylemixThemes
Author URI: https://stylemixthemes.com/
Text Domain: masterstudy-lms-learning-management-system
Version: 1.6
*/

if ( ! defined( 'ABSPATH' ) ) exit; //Exit if accessed directly

define('STM_LMS_FILE', __FILE__);
define('STM_LMS_PATH', dirname(STM_LMS_FILE));
define('STM_LMS_URL', plugin_dir_url(STM_LMS_FILE));
define('STM_LMS_DB_VERSION', '1.4');
$site_path = ( is_multisite() ) ? get_site()->path : "/";
define( 'STM_LMS_BASE_API_URL', $site_path.'1/api' );

if (!is_textdomain_loaded('masterstudy-lms-learning-management-system')) {
	load_plugin_textdomain(
		'masterstudy-lms-learning-management-system',
		false,
		'masterstudy-lms-learning-management-system/languages'
	);
}


require_once(STM_LMS_PATH . '/post_type/posts.php');
require_once(STM_LMS_PATH . '/db/tables.php');
require_once(STM_LMS_PATH . '/lms/main.php');
require_once(STM_LMS_PATH . '/lms/widgets/main.php');
require_once(STM_LMS_PATH . '/shortcodes/shortcodes.php');

require_once(STM_LMS_PATH . '/lms/classes/vendor/autoload.php');
require_once(STM_LMS_PATH . '/lms/classes/abstract/autoload.php');
require_once(STM_LMS_PATH . '/lms/classes/models/autoload.php');
require_once(STM_LMS_PATH . '/libraries/autoload.php');
require_once(STM_LMS_PATH . '/lms/init.php');
require_once(STM_LMS_PATH . '/lms/route.php');

if (is_admin()) {
	require_once(STM_LMS_PATH . '/settings/settings.php');
	require_once(STM_LMS_PATH . '/lms/generate_styles.php');
	require_once(STM_LMS_PATH . '/lms/admin_helpers.php');
	require_once(STM_LMS_PATH . '/export_options/export.php');
	require_once(STM_LMS_PATH . '/db/fix_rating.php');
	require_once(STM_LMS_PATH . '/content_filler/filler.php');
	require_once(STM_LMS_PATH . '/announcement/main.php');
}