<?php

require_once __DIR__ . '/vendor/autoload.php';

use smtech\AdvisorDashboard\Toolbox;
use smtech\ReflexiveCanvasLTI\LTI\ToolProvider;
use smtech\ReflexiveCanvasLTI\Exception\ConfigurationException;
use Battis\DataUtilities;

define('CONFIG_FILE', __DIR__ . '/config.xml');
define('CANVAS_INSTANCE_URL', 'canvas_instance_url');
define('ACCOUNT_ID', 'account_id');
define('COURSE_ID', 'course_id');
define('OAUTH_STATE', 'oauth_state');

session_start();

/* prepare the toolbox */
if (empty($_SESSION[Toolbox::class])) {
	$_SESSION[Toolbox::class] = Toolbox::fromConfiguration(CONFIG_FILE);
}
$toolbox =& $_SESSION[Toolbox::class];
$toolbox->smarty_addTemplateDir(__DIR__ . '/templates', basename(__DIR__));
$toolbox->smarty_assign('category', DataUtilities::titleCase(preg_replace('/[\-_]+/', ' ', basename(__DIR__))));

/* set the Tool Consumer's instance URL, if present */
if (empty($_SESSION[CANVAS_INSTANCE_URL]) &&
	!empty($_SESSION[ToolProvider::class]['canvas']['api_domain'])
) {
	$_SESSION[CANVAS_INSTANCE_URL] = 'https://' . $_SESSION[ToolProvider::class]['canvas']['api_domain'];
}
