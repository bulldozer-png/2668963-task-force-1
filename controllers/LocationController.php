<?php

namespace app\controllers;

use yii\web\Response;
use yii\web\Controller;
use app\models\Location;

class LocationController extends Controller
{
    public function actionSearch($q)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (mb_strlen($q) < 2) {
            return [];
        }

        $cities = \app\models\City::find()
            ->select(['id', 'name'])
            ->where(['like', 'name', $q])
            ->limit(10)
            ->asArray()
            ->all();

        if (!empty($cities)) {
            return array_map(fn($city) => [
                'id'    => $city['id'],
                'label' => $city['name'],
            ], $cities);
        }

    }
}
