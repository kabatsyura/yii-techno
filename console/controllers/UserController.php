<?php

declare(strict_types=1);

namespace console\controllers;

use common\models\User;
use Throwable;
use yii\console\Controller;
use yii\helpers\VarDumper;

/**
 * UserController console
 */
final class UserController extends Controller
{
    /**
     * @param $phone
     * @param $password
     * @return void
     */
    public function actionCreateDefault($phone, $password): void
    {
        $user = new User([
            'phone' => $phone,
        ]);

        $user->generateAuthKey();
        $user->generateAccessToken();
        $user->setPassword($password);

        try {
            if (!$user->save()) {
                echo 'Error: ' . VarDumper::dumpAsString($user->errors) . PHP_EOL;
                return;
            }
        } catch (Throwable $e) {
            echo 'Throwable: ' . VarDumper::dumpAsString($user->errors) . PHP_EOL;
            return;
        }

        echo 'success' . PHP_EOL;
    }
}
