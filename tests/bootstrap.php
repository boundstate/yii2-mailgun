<?php
// report all errors
error_reporting(-1);
define('YII_ENABLE_ERROR_HANDLER', false);
define('YII_DEBUG', true);

$_SERVER['SCRIPT_NAME'] = '/' . __DIR__;
$_SERVER['SCRIPT_FILENAME'] = __FILE__;

require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

Yii::setAlias('@boundstate/mailgun/tests', __DIR__);
Yii::setAlias('@boundstate/mailgun', dirname(__DIR__) . '/src');

if (!getenv('CI')) {
    // Load environment from `.env`
    $dotenv = Dotenv\Dotenv::create(__DIR__ . '/..');
    $dotenv->load();
    $dotenv->required(['MAILGUN_DOMAIN', 'MAILGUN_KEY', 'TEST_RECIPIENT']);
}