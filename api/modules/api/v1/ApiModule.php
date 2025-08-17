<?php

declare(strict_types=1);

namespace api\modules\api\v1;

use yii\base\Module;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

/**
 * ApiModule api v1
 */
class ApiModule extends Module
{
    public $controllerNamespace = 'api\modules\api\v1\controllers';
    public $basePath = '@app/modules/api/v1';

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'authenticator' => [
                'class' => CompositeAuth::class,
                'except' => [
                    'auth/login',
                ],
                'authMethods' => [
                    QueryParamAuth::class,
                    HttpBearerAuth::class,
                ],
            ],
        ];
    }
}