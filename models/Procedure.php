<?php

namespace Faryshta\gwork\models;

use Yii;

/**
 * This is the model class for table "{{%gwork_procedure}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Process[] $Processes
 * @property StageAssignment[] $StageAssignments
 * @property Stage[] $stages
 */
class Procedure extends \Faryshta\gwork\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gwork_procedure}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'created_at' => Yii::t('app', 'Created Time'),
            'updated_at' => Yii::t('app', 'Updated Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcesses()
    {
        return $this->hasMany(Process::className(), ['procedure_id' => 'id'])
            ->inverseOf('procedure');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStageAssignments()
    {
        return $this->hasMany(
            StageAssignment::className(),
            ['procedure_id' => 'id']
        )->inverseOf('procedure');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStages()
    {
        return $this->hasMany(Stage::className(), ['id' => 'stage_id'])
            ->via('stageAssignments');
    }
}
