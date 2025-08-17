<?php

declare(strict_types=1);

namespace api\modules\api\v1\models\forms;

use common\models\User;
use yii\base\Model;

/**
 * AuthLoginForm api v1
 */
class SiteCheckNameForm extends Model
{
    public ?string $name = null;
    public User $user;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'min' => 1, 'max' => 20],
            [['name'], 'filter', 'filter' => 'trim'],
        ];
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->name;
    }
}