<?php

declare(strict_types=1);

namespace api\modules\api\v1\models\forms;

use common\models\User;
use yii\base\Model;

/**
 * AuthLoginForm api v1
 */
class UserIdForm extends Model
{
    public ?int $user_id = null;
    public User $user;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id'], 'integer'],
        ];
    }

    /**
     * @return int
     */
    public function get(): int
    {
        return $this->user_id;
    }
}