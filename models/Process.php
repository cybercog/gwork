<?php

namespace Faryshta\gwork\models;

use Yii;

/**
 * This is the model class for table "{{%gwork_process}}".
 *
 * @property integer $id
 * @property integer $procedure_id
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $description
 * @property string $deadline
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property GworkJournal[] $gworkJournals
 * @property GworkProcedure $procedure
 * @property User $createdBy
 * @property User $updatedBy
 * @property GworkProcessChild[] $gworkProcessChildren
 */
class Process extends \Faryshta\gwork\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gwork_process}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['procedure_id', 'description'], 'required'],
            [[
                'procedure_id',
                'created_by',
                'updated_by',
                'created_at',
                'updated_at'
            ], 'integer'],
            [['description'], 'string'],
            [['deadline'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'procedure_id' => Yii::t('app', 'Procedure ID'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'description' => Yii::t('app', 'Description'),
            'deadline' => Yii::t('app', 'Deadline'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGworkJournals()
    {
        return $this->hasMany(Journal::className(), ['process_id' => 'id'])
            ->inverseOf('process');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcedure()
    {
        return $this->hasOne(Procedure::className(), ['id' => 'procedure_id']);
    }
}
