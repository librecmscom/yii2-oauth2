<?php
/**
 * @link https://github.com/borodulin/yii2-oauth-server
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-oauth-server/blob/master/LICENSE
 */

namespace yuncms\oauth2\actions;

use Yii;
use yii\base\Action;
use yii\web\Response;
use yuncms\oauth2\BaseModel;
use yuncms\oauth2\Exception;

/**
 *
 * @author Andrey Borodulin
 *
 */
class Token extends Action
{
    /**
     * Format of response
     * @var string
     */
    public $format = Response::FORMAT_JSON;

    /**
     * @var array Grant Types
     */
    public $grantTypes = [
        'authorization_code' => 'yuncms\oauth2\grant\types\Authorization',
        'refresh_token' => 'yuncms\oauth2\grant\types\RefreshToken',
        'client_credentials' => 'yuncms\oauth2\grant\types\ClientCredentials',
        'password' => 'yuncms\oauth2\grant\types\UserCredentials',
        'wechat' => 'yuncms\oauth2\grant\types\WechatCredentials',
//         'urn:ietf:params:oauth:grant-type:jwt-bearer' => 'yuncms\oauth2\grant\types\JwtBearer',
    ];

    /**
     * 初始化
     */
    public function init()
    {
        Yii::$app->response->format = $this->format;
        $this->controller->enableCsrfValidation = false;
    }

    /**
     * run
     * @throws Exception
     */
    public function run()
    {
        if (!$grantType = BaseModel::getRequestValue('grant_type')) {
            throw new Exception(Yii::t('oauth2', 'The grant type was not specified in the request'));
        }
        if (isset($this->grantTypes[$grantType])) {
            $grantModel = Yii::createObject($this->grantTypes[$grantType]);
        } else {
            throw new Exception(Yii::t('oauth2', "An unsupported grant type was requested"), Exception::UNSUPPORTED_GRANT_TYPE);
        }
        $grantModel->validate();
        Yii::$app->response->data = $grantModel->getResponseData();
    }
}