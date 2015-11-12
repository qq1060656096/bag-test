<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%message}}".
 *
 * @property string $msg_id
 * @property string $from_uid
 * @property string $to_uid
 * @property string $title
 * @property string $content
 * @property string $add_time
 * @property string $last_update
 * @property integer $is_read
 * @property string $parent_id
 * @property integer $status
 * @property string $table
 * @property integer $table_id
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_uid', 'to_uid', 'last_update', 'is_read', 'parent_id', 'status', 'table_id'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['table'], 'string', 'max' => 64],
            [['add_time'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'msg_id' => 'Msg ID',
            'from_uid' => 'From Uid',
            'to_uid' => 'To Uid',
            'title' => 'Title',
            'content' => 'Content',
            'add_time' => 'Add Time',
            'last_update' => 'Last Update',
            'is_read' => 'Is Read',
            'parent_id' => 'Parent ID',
            'status' => 'Status',
            'table' => 'Table',
            'table_id' => 'Table ID',
        ];
    }
}
