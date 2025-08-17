<?php

declare(strict_types=1);

namespace api\modules\api\v1;

use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\Response;

/**
 * ApiRestFullController api v1
 */
class ApiActiveController extends ActiveController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ]);
    }
}
