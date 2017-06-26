<?php
/**
 * @link https://github.com/borodulin/yii2-oauth2-server
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-oauth2-server/blob/master/LICENSE
 */

namespace yuncms\oauth2;

use Yii;
use yii\console\Application as ConsoleApplication;
use yuncms\oauth2\console\Oauth2Controller;

/**
 * @author Andrey Borodulin
 */
class Module extends \yii\base\Module
{

    public $behaviors;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        if (!empty($this->behaviors)) {
            return $this->behaviors;
        } else {
            return parent::behaviors();
        }
    }
}