<?php

declare(strict_types=1);

namespace api\modules\api\v1\controllers;

use api\modules\api\v1\ApiController;
use api\modules\api\v1\models\forms\SiteCheckNameForm;
use api\modules\api\v1\models\forms\UserIdForm;
use common\models\UserLog;
use Yii;

final class SiteController extends ApiController
{
  public function actionCheckName(): array
  {
    $nameDTO = new SiteCheckNameForm([
      'user' => Yii::$app->user->identity,
    ]);

    if ($nameDTO->load(Yii::$app->request->get(), '') && $nameDTO->validate()) {
      return [
        'success' => true,
        'name' => $nameDTO->get(),
      ];
    }

    Yii::$app->response->statusCode = 400;

    return [
      'success' => false,
      'message' => $nameDTO->getErrors(),
    ];
  }

  public function actionShowLogs()
  {
    $userIdDTO = new UserIdForm([
      'user' => Yii::$app->user->identity,
    ]);

    if ($userIdDTO->load(Yii::$app->request->get(), '') && $userIdDTO->validate()) {
      return UserLog::getPaginatedLogs($userIdDTO->get());
    }

    Yii::$app->response->statusCode = 400;

    return [
      'success' => false,
      'message' => $userIdDTO->getErrors(),
    ];
  }
}