<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\authclient\ClientInterface;
use app\models\User;

class AuthController extends Controller
{
    public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess(ClientInterface $client)
    {
        $attributes = $client->getUserAttributes();

        $githubId = $attributes['id'];
        $email = $attributes['email'] ?? null;
        $username = $attributes['login'];

        $user = null;

        if ($email) {
            $user = User::find()->where(['email' => $email])->one();
        }

        if (!$user) {
            $user = User::find()->where(['github_id' => $githubId])->one();
        }

        if (!$user) {
            $user = new User();
            $user->github_id = $githubId;
            $user->name = $username;
            $user->email = $email;
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->save(false);
        } else {
            if (!$user->github_id) {
                $user->github_id = $githubId;
                $user->save(false);
            }
        }

        Yii::$app->user->login($user);

        return $this->goHome();
    }
}
