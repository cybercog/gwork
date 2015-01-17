<?php

namespace Faryshta\gwork\models;

use Yii;

/**
 * This is the model class for table "{{%gwork_journal}}".
 *
 * @property integer $id
 * @property integer $process_id
 * @property integer $procedure_id
 * @property integer $origin_id
 * @property integer $destiny_id
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $observation
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Procedure $procedure
 * @property Process $process
 * @property Stage $origin
 * @property Stage $destiny
 */
class Journal extends \Faryshta\gwork\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gwork_journal}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[
                'process_id',
                'procedure_id',
                'origin_id',
                'destiny_id',
                'observation',
            ], 'required'],
            [[
               'process_id',
               'procedure_id',
               'origin_id',
               'destiny_id',
               'created_by',
               'updated_by',
               'created_at',
               'updated_at'
            ], 'integer'],
            [['observation'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'process_id' => Yii::t('app', 'Process ID'),
            'procedure_id' => Yii::t('app', 'Procedure ID'),
            'origin_id' => Yii::t('app', 'Origin ID'),
            'destiny_id' => Yii::t('app', 'Destiny ID'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'observation' => Yii::t('app', 'Observation'),
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
    public function getProcess()
    {
        return $this->hasOne(Process::className(), ['id' => 'process_id']);
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
