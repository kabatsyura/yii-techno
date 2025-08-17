<?php

declare(strict_types=1);

namespace common\models;

use Throwable;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * @property int $id
 * @property string $phone
 * @property string $password_hash
 * @property string $auth_key
 * @property string $access_token
 * @property int $created_at
 * @property int $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id): ?User
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null): ?User
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @param string $phone
     * @return self|null
     */
    public static function findByPhone(string $phone): ?self
    {
        return static::findOne(['phone' => $phone]);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @param string $password
     * @return bool
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @param string $password
     * @return void
     * @throws Throwable
     */
    public function setPassword(string $password): void
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function generateAuthKey(): void
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function generateAccessToken(): void
    {
        $this->access_token = Yii::$app->security->generateRandomString();
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): int|string
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->auth_key === $authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['phone', 'access_token', 'auth_key', 'password_hash'], 'required'],
            [['phone', 'access_token'], 'unique'],
            [['phone', 'access_token', 'auth_key', 'password_hash'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'phone' => 'Phone Number',
            'password_hash' => 'Password Hash',
            'auth_key' => 'Authentication Key',
            'access_token' => 'Access Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserLogs()
    {
        return $this->hasMany(UserLog::class, ['user_id' => 'id']);
    }
}