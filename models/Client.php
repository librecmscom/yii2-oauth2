<?php
/**
 * @link https://github.com/borodulin/yii2-oauth2-server
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-oauth2-server/blob/master/LICENSE
 */

namespace yuncms\oauth2\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\web\Application as WebApplication;
use yuncms\user\models\User;

/**
 * This is the model class for table "oauth2_client".
 *
 * @property string $client_id
 * @property string $client_secret
 * @property string $redirect_uri
 * @property string $grant_type
 * @property string $scope
 * @property string $name
 * @property string $domain
 * @property string $provider
 * @property string $icp
 * @property integer $user_id
 * @property string $registration_ip
 *
 * @property AccessToken[] $accessTokens
 * @property AuthorizationCode[] $authorizationCodes
 * @property RefreshToken[] $refreshTokens
 * @property User $user
 */
class Client extends ActiveRecord
{
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
            [['name', 'domain', 'provider', 'redirect_uri'], 'required'],
            [['name', 'scope', 'provider', 'icp'], 'string'],
            [['grant_type'], 'string'],
            [['grant_type'], 'default', 'value' => Null],
            [['scope'], 'string'],
            [['redirect_uri'], 'url'],
            [['created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => BlameableBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'user_id',
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'client_id' => Yii::t('oauth2', 'App Key'),
            'client_secret' => Yii::t('oauth2', 'App Secret'),
            'redirect_uri' => Yii::t('oauth2', 'Redirect URI'),
            'grant_type' => Yii::t('oauth2', 'Grant type'),
            'scope' => Yii::t('oauth2', 'Scope Authority'),
            'name' => Yii::t('oauth2', 'App Name'),
            'domain' => Yii::t('oauth2', 'App Domain'),
            'provider' => Yii::t('oauth2', 'App Provider'),
            'icp' => Yii::t('oauth2', 'ICP Beian'),
            'created_at' => Yii::t('oauth2', 'Created At'),
            'updated_at' => Yii::t('oauth2', 'Updated At'),
        ];
    }

    /**
     * 生成 ClientKey
     */
    public function generateClientKey()
    {
        $this->client_secret = Yii::$app->security->generateRandomString();
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->generateClientKey();
            if (Yii::$app instanceof WebApplication) {
                $this->registration_ip = Yii::$app->request->userIP;
            }
        }
        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessTokens()
    {
        return $this->hasMany(AccessToken::className(), ['client_id' => 'client_id']);
    }

    /**
     * User Relation
     * @return \yii\db\ActiveQueryInterface
     */
    public function getUser()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'user_id']);
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
}
