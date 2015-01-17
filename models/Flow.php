<?php

namespace Faryshta\gwork\models;

use Yii;

/**
 * This is the model class for table "{{%gwork_flow}}".
 *
 * @property integer $procedure_id
 * @property integer $origin_id
 * @property integer $destiny_id
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Procedure $procedure
 * @property Stage $origin
 * @property Stage $destiny
 */
class Flow extends \Faryshta\gwork\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gwork_flow}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['procedure_id', 'origin_id', 'destiny_id'], 'required'],
            [['procedure_id', 'origin_id', 'destiny_id', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'procedure_id' => Yii::t('app', 'Procedure ID'),
            'origin_id' => Yii::t('app', 'Origin ID'),
            'destiny_id' => Yii::t('app', 'Destiny ID'),
            'description' => Yii::t('app', 'Description'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcedure()
    {
        return $this->hasOne(Procedure::className(), ['id' => 'procedure_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrigin()
    {
        return $this->hasOne(Stage::className(), ['id' => 'origin_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestiny()
    {
        return $this->hasOne(Stage::className(), ['id' => 'destiny_id']);
    }
}
