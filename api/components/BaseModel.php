<?php
namespace api\components;

use api\exceptions\OperateException;
use api\exceptions\ValidateException;
use common\models\User;
use Yii;
use yii\base\Model;

class BaseModel extends Model
{
    /**
     * 获取模型错误
     * @param $model \yii\base\Model
     * @throws ValidateException
     */
    public static function getErrorMessage($model, $isThrow = true)
    {
        $error = null;
        if ($model->hasErrors()) {
            $errors = $model->getErrors();
            foreach ($errors as $value) {
                $error = $value[0];
                break;
            }
        }
        if ($isThrow && !(null === $error)) {
            throw new ValidateException($error);
        } elseif (!$isThrow && !(null === $error)) {
            return $error;
        } else {
            return true;
        }
    }

    /**
     * @param null $uid
     * @return mixed|null|static
     * @throws OperateException
     */
    protected function getUser($uid = null)
    {
        if (null === $uid) {
            $uid = Yii::$app->user->id;
        }

        $user = User::findOne($uid);
        if (null === $user) {
            throw new OperateException(100001);
        }

        return $user;
    }
}