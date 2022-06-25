<?php

namespace app\models;

use Yii;
use yii\db\BaseActiveRecord;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int $real_id
 * @property string|null $user_name
 * @property string|null $user_phone
 * @property string|null $warehouse_id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $status
 * @property int|null $items_count
 */
class Order extends \yii\db\ActiveRecord
{

    public function formName(): string
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['real_id'], 'required'],
            [['real_id', 'created_at', 'updated_at', 'status', 'items_count'], 'integer'],
            [['user_name', 'user_phone', 'warehouse_id'], 'string', 'max' => 255],
            [['real_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'real_id' => 'Real ID',
            'user_name' => 'User Name',
            'user_phone' => 'User Phone',
            'warehouse_id' => 'Warehouse ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'items_count' => 'Items Count',
        ];
    }

    public function behaviors(): array {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['updated_at'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

}
