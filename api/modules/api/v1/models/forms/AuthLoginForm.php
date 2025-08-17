<?php

declare(strict_types=1);

namespace api\modules\api\v1\models\forms;

use yii\base\Model;

/**
 * AuthLoginForm api v1
 */
class AuthLoginForm extends Model
{
    public string $phone = '';

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['phone'], 'required'],
            [['phone'], 'string', 'max' => 15],
            [['phone'], 'match', 'pattern' => '/^\+?\d{10,15}$/'],
        ];
    }

    /**
     * @return bool
     */
    public function login(): bool
    {
        return true;
    }
}
