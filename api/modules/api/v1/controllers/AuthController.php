<?php

declare(strict_types=1);

namespace api\modules\api\v1\controllers;

use api\modules\api\v1\ApiController;
use api\modules\api\v1\models\forms\AuthLoginForm;
use Yii;

/**
 * AuthController api v1
 */
final class AuthController extends ApiController
{
    /**
     * @return array
     */
    public function actionLogin(): array
    {
        $authLogin = new AuthLoginForm([]);

        if ($authLogin->load(Yii::$app->request->post(), '') && $authLogin->validate()) {
            if (!$authLogin->login()) {
                Yii::$app->response->statusCode = 500;

                return [
                    'success' => false,
                ];
            }

            return [
                'success' => true,
            ];
        }

        Yii::$app->response->statusCode = 400;

        return [
            'success' => false,
        ];
    }

    /**
     * @return array
     */
    public function actionConfirm(): array
    {
        return [
            'success' => true,
            'data' => [
                'access_token' => 'token',
                'roles' => [
                    'client',
                    'developer',
                ],
            ],
        ];
    }
}
