<?php
/**
 * @link https://github.com/borodulin/yii2-oauth2-server
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-oauth2-server/blob/master/LICENSE
 */

namespace yuncms\oauth2\console;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
use yuncms\oauth2\models\App;
use yuncms\oauth2\models\RefreshToken;
use yuncms\oauth2\models\AccessToken;
use yuncms\oauth2\models\AuthorizationCode;


/**
 * Oauth2 apps manage
 */
class Oauth2Controller extends Controller
{
    public $defaultAction = 'clear';

    /**
     * Deletes a app.
     *
     * @param int $id app id
     */
    public function actionDelete($id)
    {
        if ($this->confirm(Yii::t('oauth2', 'Are you sure? Deleted app can not be restored'))) {
            $user = App::findOne(['id' => $id]);
            if ($user === null) {
                $this->stdout(Yii::t('oauth2', 'app is not found') . "\n", Console::FG_RED);
            } else {
                if ($user->delete()) {
                    $this->stdout(Yii::t('oauth2', 'app has been deleted') . "\n", Console::FG_GREEN);
                } else {
                    $this->stdout(Yii::t('oauth2', 'Error occurred while deleting app') . "\n", Console::FG_RED);
                }
            }
        }
    }

    /**
     * Clear expires token
     */
    public function actionClear()
    {
        AuthorizationCode::deleteAll(['<', 'expires', time()]);
        RefreshToken::deleteAll(['<', 'expires', time()]);
        AccessToken::deleteAll(['<', 'expires', time()]);
    }
}