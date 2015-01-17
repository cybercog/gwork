<?php

namespace Faryshta\gwork\models;

use Yii;

/**
 * This is the model class for table "{{%gwork_auth}}".
 *
 * @property integer $stage_id
 * @property string $item_name
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Stage $stage
 */
class Auth extends \Faryshta\gwork\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gwork_auth}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stage_id', 'item_name'], 'required'],
            [['stage_id', 'created_at', 'updated_at'], 'integer'],
            [['item_name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'stage_id' => Yii::t('app', 'Stage ID'),
            'item_name' => Yii::t('app', 'Item Name'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStage()
    {
        return $this->hasOne(Stage::className(), ['id' => 'stage_id']);
    }
}
