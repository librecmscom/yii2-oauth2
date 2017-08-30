<?php
/**
 * @link https://github.com/borodulin/yii2-oauth2-server
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-oauth2-server/blob/master/LICENSE
 */

namespace yuncms\oauth2\filters;

use Yii;
use yii\base\ActionFilter;
use yuncms\oauth2\BaseModel;
use yuncms\oauth2\Exception;
/**
 *
 * @author Andrey Borodulin
 *
 */
class Authorize extends ActionFilter
{

    /**
     * @var string
     */
    private $_responseType;

    public $responseTypes = [
        'token' => 'yuncms\oauth2\response\types\Implicit',
        'code' => 'yuncms\oauth2\response\types\Authorization',
    ];

    /**
     *
     * @var boolean
     */
    public $allowImplicit = true;

    /**
     * @var string
     */
    public $storeKey = 'ear6kme7or19rnfldtmwsxgzxsrmngqw';

    /**
     * 初始化
     */
    public function init()
    {
        if (!$this->allowImplicit) {
            unset($this->responseTypes['token']);
        }
    }

    /**
     * Performs OAuth 2.0 request validation and store granttype object in the session,
     * so, user can go from our authorization server to the third party OAuth provider.
     * You should call finishAuthorization() in the current controller to finish client authorization
     * or to stop with Access Denied error message if the user is not logged on.
     */
    public function beforeAction($action)
    {
        if (!$responseType = BaseModel::getRequestValue('response_type')) {
            throw new Exception(Yii::t('oauth2', 'Invalid or missing response type'));
        }
        if (isset($this->responseTypes[$responseType])) {
            $this->_responseType = Yii::createObject($this->responseTypes[$responseType]);
        } else {
            throw new Exception(Yii::t('oauth2', "An unsupported response type was requested."), Exception::UNSUPPORTED_RESPONSE_TYPE);
        }

        $this->_responseType->validate();

        if ($this->storeKey) {
            Yii::$app->session->set($this->storeKey, serialize($this->_responseType));
        }

        return true;
    }

    /**
     * If user is logged on, do oauth login immediatly,
     * continue authorization in the another case
     */
    public function afterAction($action, $result)
    {
        if (Yii::$app->user->isGuest) {
            return $result;
        } else {
            $this->finishAuthorization();
        }
    }

    /**
     * @throws Exception
     * @return \yuncms\oauth2\BaseModel
     */
    protected function getResponseType()
    {
        if (empty($this->_responseType) && $this->storeKey) {
            if (Yii::$app->session->has($this->storeKey)) {
                $this->_responseType = unserialize(Yii::$app->session->get($this->storeKey));
            } else {
                throw new Exception(Yii::t('oauth2', 'Invalid server state or the User Session has expired'), Exception::SERVER_ERROR);
            }
        }
        return $this->_responseType;
    }

    /**
     * Finish oauth authorization.
     * Builds redirect uri and performs redirect.
     * If user is not logged on, redirect contains the Access Denied Error
     */
    public function finishAuthorization()
    {
        $responseType = $this->getResponseType();
        if (Yii::$app->user->isGuest) {
            $responseType->errorRedirect(Yii::t('oauth2', 'The User denied access to your application'), Exception::ACCESS_DENIED);
        }
        $parts = $responseType->getResponseData();

        $redirectUri = http_build_url($responseType->redirect_uri, $parts, HTTP_URL_JOIN_QUERY | HTTP_URL_STRIP_FRAGMENT);

        if (isset($parts['fragment'])) {
            $redirectUri .= '#' . $parts['fragment'];
        }

        Yii::$app->response->redirect($redirectUri);
    }

    /**
     * @return boolean
     */
    public function getIsOauthRequest()
    {
        return !empty($this->storeKey) && Yii::$app->session->has($this->storeKey);
    }
}

