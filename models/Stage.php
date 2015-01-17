<?php

namespace Faryshta\gwork\models;

use Yii;

/**
 * This is the model class for table "{{%gwork_stage}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $initial
 * @property string $event_class
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Auth[] $Auths
 * @property StageAssignment[] $stageAssignments
 * @property Procedure[] $procedures
 */
class Stage extends \Faryshta\gwork\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gwork_stage}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['initial', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['description', 'event_class'], 'string', 'max' => 255],
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
            'description' => Yii::t('app', 'Description'),
            'initial' => Yii::t('app', 'Initial'),
            'event_class' => Yii::t('app', 'Event Class'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuths()
    {
        return $this->hasMany(Auth::className(), ['stage_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStageAssignments()
    {
        return $this->hasMany(StageAssignment::className(), ['stage_id' => 'id'])
            ->inverseOf('stage');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcedures()
    {
        return $this->hasMany(Procedure::className(), ['id' => 'procedure_id'])
            ->via('stageAssignments');
    }
}
