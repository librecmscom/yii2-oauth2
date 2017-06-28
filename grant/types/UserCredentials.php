<?php
/**
 * @link https://github.com/borodulin/yii2-oauth2-server
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-oauth2-server/blob/master/LICENSE
 */

namespace yuncms\oauth2\grant\types;

use Yii;
use yuncms\oauth2\models\AccessToken;
use yuncms\oauth2\models\RefreshToken;
use yuncms\oauth2\BaseModel;
use yuncms\oauth2\OAuth2IdentityInterface;

/**
 * For example, the client makes the following HTTP request using
 * transport-layer security (with extra line breaks for display purposes
 * only):
 *
 * ```
 * POST /token HTTP/1.1
 * Host: server.example.com
 * Authorization: Basic czZCaGRSa3F0MzpnWDFmQmF0M2JW
 * Content-Type: application/x-www-form-urlencoded
 *
 * response_type=password&username=johndoe&password=A3ddj3w
 * ```
 *
 * @link https://tools.ietf.org/html/rfc6749#section-4.3
 * @author Dmitry Fedorenko
 */
class UserCredentials extends BaseModel
{
    /** @var  \yuncms\user\models\User */
    private $_user;

    /**
     * Value MUST be set to "password"
     * @var string
     */
    public $grant_type;

    /**
     * The resource owner username.
     * @var string
     */
    public $username;

    /**
     * The resource owner password.
     * @var string
     */
    public $password;

    /**
     * Access Token Scope
     * @link https://tools.ietf.org/html/rfc6749#section-3.3
     * @var string
     */
    public $scope;

    /**
     * @var string
     */
    public $client_id;

    /**
     * @var string
     */
    public $client_secret;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['grant_type', 'client_id', 'username', 'password'], 'required'],
            ['grant_type', 'required', 'requiredValue' => 'password'],
            [['client_id'], 'string', 'max' => 80],
            [['client_id'], 'validateClient_id'],
            [['client_secret'], 'validateClient_secret'],
            [['scope'], 'validateScope'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Yii::t('oauth2', 'Invalid username or password'));
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function getResponseData()
    {
        $identity = $this->getUser();

        $accessToken = AccessToken::createAccessToken([
            'client_id' => $this->client_id,
            'user_id' => $identity->id,
            'expires' => $this->accessTokenLifetime + time(),
            'scope' => $this->scope,
        ]);

        $refreshToken = RefreshToken::createRefreshToken([
            'client_id' => $this->client_id,
            'user_id' => $identity->id,
            'expires' => $this->refreshTokenLifetime + time(),
            'scope' => $this->scope,
        ]);

        return [
            'access_token' => $accessToken->access_token,
            'expires_in' => $this->accessTokenLifetime + time(),
            'token_type' => $this->tokenType,
            'scope' => $this->scope,
            'refresh_token' => $refreshToken->refresh_token,
        ];
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        /** @var \yuncms\user\models\User $identityClass */
        $identityClass = Yii::$app->user->identityClass;

        $identityObject = Yii::createObject($identityClass);
        if (!$identityObject instanceof OAuth2IdentityInterface) {
            $this->errorServer(Yii::t('oauth2', 'OAuth2IdentityInterface not implemented'));
        }

        if ($this->_user === null) {
            $this->_user = $identityClass::findIdentityByUsername($this->username);
        }

        return $this->_user;
    }
}
