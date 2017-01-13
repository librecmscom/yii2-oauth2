<?php
/**
 * @link https://github.com/borodulin/yii2-oauth-server
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-oauth-server/blob/master/LICENSE
 */

namespace yuncms\oauth2;

use Yii;
use yii\base\Action;
use yii\web\Response;

/**
 *
 * @author Andrey Borodulin
 *
 */
class TokenAction extends Action
{

    public $grantTypes = [
        'authorization_code' => 'yuncms\oauth2\granttypes\Authorization',
        'refresh_token' => 'yuncms\oauth2\granttypes\RefreshToken',
//         'client_credentials' => 'yuncms\oauth2\granttypes\ClientCredentials',
//         'password' => 'yuncms\oauth2\granttypes\UserCredentials',
//         'urn:ietf:params:oauth:grant-type:jwt-bearer' => 'yuncms\oauth2\granttypes\JwtBearer',
    ];

    public function init()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $this->controller->enableCsrfValidation = false;
    }

    public function run()
    {
        if (!$grantType = BaseModel::getRequestValue('grant_type')) {
            throw new Exception('The grant type was not specified in the request');
        }
        if (isset($this->grantTypes[$grantType])) {
            $grantModel = Yii::createObject($this->grantTypes[$grantType]);
        } else {
            throw new Exception("An unsupported grant type was requested", Exception::UNSUPPORTED_GRANT_TYPE);
        }
        $grantModel->validate();
        Yii::$app->response->data = $grantModel->getResponseData();
    }
}