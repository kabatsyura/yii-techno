<?php

declare(strict_types=1);

namespace api\modules\api\v1\controllers;

use api\modules\api\v1\ApiController;
use api\modules\api\v1\models\forms\SiteCheckNameForm;
use common\models\UserLog;
use Yii;
use yii\data\ActiveDataProvider;

final class SiteController extends ApiController
{
  public function actionCheckName(): array
  {
    $siteCheckName = new SiteCheckNameForm([
      'user' => Yii::$app->user->identity,
    ]);

    if ($siteCheckName->load(Yii::$app->request->get(), '') && $siteCheckName->validate()) {
      return [
        'success' => true,
        'name' => $siteCheckName->get(),
      ];
    }

    Yii::$app->response->statusCode = 400;

    return [
      'success' => false,
      'message' => $siteCheckName->getErrors(),
    ];
  }

  public function actionShowLogs(?int $user_id = null): array
  {
    $query = UserLog::find()->orderBy(['created_at' => SORT_DESC]);

    if ($user_id !== null) {
      $query->andWhere(['user_id' => $user_id]);
    }

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'pagination' => [
        'pageSize' => Yii::$app->request->get('pageSize', 20),
      ],
    ]);

    return [
      'logs' => $dataProvider->getModels(),
      'pagination' => [
        'page' => $dataProvider->getPagination()->getPage() + 1,
        'pageCount' => $dataProvider->getPagination()->getPageCount(),
        'totalCount' => $dataProvider->getTotalCount(),
        'pageSize' => $dataProvider->getPagination()->getPageSize(),
      ],
    ];
  }
}