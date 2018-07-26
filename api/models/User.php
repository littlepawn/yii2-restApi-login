<?php
namespace api\models;

use Yii;

class User extends \common\models\User implements \OAuth2\Storage\UserCredentialsInterface{

    /**
     * Implemented for Oauth2 Interface
     * @throws \yii\base\InvalidConfigException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        /** @var \filsh\yii2\oauth2server\Module $module */
        $module = Yii::$app->getModule('oauth2');
        $token = $module->getServer()->getResourceController()->getToken();
        return !empty($token['user_id'])
                    ? static::findIdentity($token['user_id'])
                    : null;
    }

    /**
     * Implemented for Oauth2 Interface
     */
    public function checkUserCredentials($username, $password)
    {
        $user = static::findByUsernameOrEmail($username);
        if (empty($user)) {
            return false;
        }
        return $user->validatePassword($password);
    }

    /**
     * Implemented for Oauth2 Interface
     */
    public function getUserDetails($username)
    {
        $user = static::findByUsernameOrEmail($username);
        return ['user_id' => $user->getId()];
    }
}