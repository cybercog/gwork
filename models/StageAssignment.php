<?php

namespace Faryshta\gwork\models;

use Yii;

/**
 * This is the model class for table "{{%gwork_stage_assignment}}".
 *
 * @property integer $procedure_id
 * @property integer $stage_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property GworkFlow[] $gworkFlows
 * @property GworkProcedure $procedure
 * @property GworkStage $stage
 */
class StageAssignment extends \Faryshta\gwork\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gwork_stage_assignment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['procedure_id', 'stage_id'], 'required'],
            [
                ['procedure_id', 'stage_id', 'created_at', 'updated_at'],
                'integer'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'procedure_id' => Yii::t('app', 'Procedure ID'),
            'stage_id' => Yii::t('app', 'Stage ID'),
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
    public function getStage()
    {
        return $this->hasOne(Stage::className(), ['id' => 'stage_id']);
    }
}
