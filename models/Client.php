<?php
/**
 * @link https://github.com/borodulin/yii2-oauth2-server
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-oauth2-server/blob/master/LICENSE
 */

namespace yuncms\oauth2\models;

use Yii;
use yii\db\Query;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "oauth2_client".
 *
 * @property string $client_id 客户端ID
 * @property string $client_secret 密钥
 * @property string $redirect_uri
 * @property string $grant_type
 * @property string $scope
 * @property integer $user_id 用户ID
 * @property string $public_key
 *
 * @property AccessToken[] $accessTokens
 * @property AuthorizationCode[] $authorizationCodes
 * @property RefreshToken[] $refreshTokens
 */
class Client extends ActiveRecord
{
    const GRANT_TYPE_AUTHORIZATION_CODE = 1;
    const GRANT_TYPE_IMPLICIT = 2;
    const GRANT_TYPE_PASSWORD = 3;
    const GRANT_TYPE_CLIENT_CREDENTIALS = 4;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%oauth2_client}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['redirect_uri'], 'required'],
            [['scope'], 'string'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['client_secret', 'grant_type'], 'string', 'max' => 80],
            [['redirect_uri'], 'string', 'max' => 2000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'yii\behaviors\TimestampBehavior',
            'yii\behaviors\BlameableBehavior'
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'client_id' => Yii::t('oauth2', 'Client ID'),
            'client_secret' => Yii::t('oauth2', 'Client Secret'),
            'user_id' => Yii::t('oauth2', 'User ID'),
            'redirect_uri' => Yii::t('oauth2', 'Redirect URI'),
            'grant_type' => Yii::t('oauth2', 'Space-delimited list of grant types permitted, null = all'),
            'scope' => Yii::t('oauth2', 'Space-delimited list of approved scopes'),
        ];
    }

    /**
     * 是否是作者
     * @return bool
     */
    public function isAuthor()
    {
        return $this->user_id == Yii::$app->user->id;
    }

    /**
     * 一对一关联
     * @return \yii\db\ActiveQueryInterface
     */
    public function getUser()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessTokens()
    {
        return $this->hasMany(AccessToken::className(), ['client_id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorizationCodes()
    {
        return $this->hasMany(AuthorizationCode::className(), ['client_id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefreshTokens()
    {
        return $this->hasMany(RefreshToken::className(), ['client_id' => 'client_id']);
    }

    /**
     * 保存前
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->setAttribute('user_id', Yii::$app->user->id);
                $this->setAttribute('client_secret', Yii::$app->security->generateRandomString());
            }
            return true;
        } else {
            return false;
        }
    }

    public static function grants()
    {
        return [
            static::GRANT_TYPE_AUTHORIZATION_CODE => 'authorization_code',
            static::GRANT_TYPE_IMPLICIT => 'implicit',
            static::GRANT_TYPE_PASSWORD => 'password',
            static::GRANT_TYPE_CLIENT_CREDENTIALS => 'client_credentials',
        ];
    }
}
