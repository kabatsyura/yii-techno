<?php

declare(strict_types=1);

namespace common\models;

// use yii\behaviors\TimestampBehavior;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_log".
 *
 * @property int $id
 * @property string $message
 * @property int $user_id
 *
 * @property User $user
 */
class UserLog extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%user_log}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
                'value' => time(),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['message', 'user_id'], 'required'],
            ['message', 'string'],
            ['user_id', 'integer'],
            ['user_id', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'message' => 'Message',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public static function getPaginatedLogs(?int $user_id = null): array
    {
        var_dump('here');
        $query = UserLog::find();

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