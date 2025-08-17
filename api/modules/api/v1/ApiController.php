<?php

declare(strict_types=1);

namespace api\modules\api\v1;

use common\models\UserLog;
use Yii;
use yii\filters\ContentNegotiator;
use yii\rest\Controller;
use yii\web\Response;

/**
 * ApiController api v1
 */
class ApiController extends Controller
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

    public function beforeAction($action): bool
    {
        $result = parent::beforeAction($action);
        $user = Yii::$app->user->identity;

        if ($result && $user) {
            try {
                $log = new UserLog();
                $log->user_id = $user->id;
                $log->message = sprintf(
                    'Request to %s/%s with params: %s by %s',
                    $action->controller->id,
                    $action->id,
                    json_encode(Yii::$app->request->get()),
                    $user ? "user_id={$user->id}" : 'guest'
                );
                $log->save(false);
            } catch (\Throwable $e) {
                Yii::error('Failed to save user log: ' . $e->getMessage(), __METHOD__);
            }
        }

        return $result;
    }
}