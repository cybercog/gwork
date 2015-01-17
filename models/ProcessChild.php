<?php

namespace Faryshta\gwork\models;

use Yii;

/**
 * This is the model class for table "{{%gwork_process_child}}".
 *
 * @property integer $parent_id
 * @property integer $child_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Process $parent
 * @property Process $child
 */
class ProcessChild extends \Faryshta\gwork\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gwork_process_child}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'child_id'], 'required'],
            [['parent_id', 'child_id', 'created_at', 'updated_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent_id' => Yii::t('app', 'Parent ID'),
            'child_id' => Yii::t('app', 'Child ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Process::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChild()
    {
        return $this->hasOne(Process::className(), ['id' => 'child_id']);
    }
}
