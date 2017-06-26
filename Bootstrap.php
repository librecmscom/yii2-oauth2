<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */


namespace yuncms\oauth2;

use Yii;
use yii\web\GroupUrlRule;
use yii\i18n\PhpMessageSource;
use yii\base\BootstrapInterface;
use yii\console\Application as ConsoleApplication;
use yuncms\oauth2\console\Oauth2Controller;

/**
 * Class Bootstrap
 * @package yuncms\oauth2
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * 初始化
     * @param \yii\base\Application $app
     * @throws \yii\base\InvalidConfigException
     */
    public function bootstrap($app)
    {
        /** @var Module $module */
        /** @var \yii\db\ActiveRecord $modelName */
        if ($app->hasModule('oauth2') && ($module = $app->getModule('oauth2')) instanceof Module) {
            if ($app instanceof \yii\console\Application) {
                $app->controllerMap[$module->id] = [
                    'class' => Oauth2Controller::className(),
                ];
            }
        }
        /**
         * 注册语言包
         */
        if (!isset($app->get('i18n')->translations['oauth2*'])) {
            $app->get('i18n')->translations['oauth2*'] = [
                'class' => PhpMessageSource::className(),
                'sourceLanguage' => 'en-US',
                'basePath' => __DIR__ . '/messages',
            ];
        }
    }
}