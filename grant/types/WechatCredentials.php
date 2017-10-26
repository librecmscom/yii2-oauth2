<?php
/**
 * @link https://github.com/borodulin/yii2-oauth2-server
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-oauth2-server/blob/master/LICENSE
 */

namespace yuncms\oauth2\grant\types;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\Query;
use yii\web\ServerErrorHttpException;
use yuncms\oauth2\models\AccessToken;
use yuncms\oauth2\models\RefreshToken;
use yuncms\oauth2\BaseModel;
use yuncms\user\models\Wechat;

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
 * response_type=token&code=johndoe
 * ```
 *
 * @link https://tools.ietf.org/html/rfc6749#section-4.3
 * @author Dmitry Fedorenko
 */
class WechatCredentials extends BaseModel
{
    /** @var  \yuncms\user\models\User */
    private $_user;

    /**
     * Value MUST be set to "wechat"
     * @var string
     */
    public $grant_type;

    /**
     * The resource wechat authorization_code.
     * @var string
     */
    public $code;

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
     * @var \xutl\wechat\Wechat
     */
    private $wechat;

    /**
     * 初始化模型
     */
    public function init()
    {
        parent::init();
        if (!Yii::$app->has('wechat')) {
            throw new InvalidConfigException("Unknown component ID: wechat.");
        }
        $this->wechat = Yii::$app->wechat;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['grant_type', 'client_id', 'code'], 'required'],
            ['grant_type', 'required', 'requiredValue' => 'wechat'],
            [['client_id'], 'string', 'max' => 80],
            [['client_id'], 'validateClient_id'],
            [['client_secret'], 'validateClient_secret'],
            [['scope'], 'validateScope'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function getResponseData()
    {
        /** @var \yuncms\user\models\User $identity */
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
            'expires_in' => $this->accessTokenLifetime,
            'token_type' => $this->tokenType,
            'scope' => $this->scope,
            'refresh_token' => $refreshToken->refresh_token,
        ];
    }

    /**
     * @return null|object|\yuncms\user\models\User
     * @throws ServerErrorHttpException
     */
    protected function getUser()
    {
        /** @var \yuncms\user\models\User $identityClass */
        $identityClass = Yii::$app->user->identityClass;
        if ($this->_user === null) {
            $client = $this->wechat->oauth;
            $client->validateAuthState = false;
            $token = $client->fetchAccessToken($this->code);
            if($token){

            }
            $tokenParams = $token->getParams();

            if (($account = Wechat::find()->where([
                    'unionid' => $tokenParams['unionid'],
                    'openid' => $tokenParams['openid']
                ])->one()) == null) {
                $account = Wechat::create($client);
            }
            if ($account->user instanceof $identityClass) {
                $this->_user = $account->user;
            } else {
                $nickname = '微信' . $account->nickname;
                // generate nickname like "user1", "user2", etc...
                while (!$this->validate(['username'])) {
                    $row = (new Query())->from('{{%user}}')->select('MAX(id) as id')->one();
                    $nickname = $account->nickname . ++$row['id'];
                }
                /** @var \yuncms\user\models\User $user */
                $user = Yii::createObject([
                    'class' => $identityClass,
                    'scenario' => $identityClass::SCENARIO_CREATE_MOBILE_WECHAT,
                    'nickname' => $nickname,
                ]);
                if ($user->create()) {
                    $account->connect($user);
                }
                if ($user->hasErrors()) {
                    throw new ServerErrorHttpException('Failed to login the user for unknown reason.');
                }
                $this->_user = $user;
            }
        }
        return $this->_user;
    }
}
