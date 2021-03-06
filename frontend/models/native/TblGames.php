<?php

namespace app\models\native;

use Yii;

/**
 * This is the model class for table "tbl_games".
 *
 * @property integer $id
 * @property integer $type
 * @property string $name
 * @property string $logo
 * @property string $content
 * @property integer $sort
 * @property integer $status
 * @property integer $begin_time
 * @property integer $end_time
 * @property integer $number
 * @property string $result
 * @property integer $createtime
 */
class TblGames extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_games';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'name', 'logo', 'content', 'sort', 'status', 'begin_time', 'end_time', 'number', 'result', 'createtime'], 'required'],
            [['type', 'sort', 'status', 'begin_time', 'end_time', 'number', 'createtime'], 'integer'],
            [['content', 'result'], 'string'],
            [['name', 'logo'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '类型',
            'name' => '大赛名称',
            'logo' => '大赛logo',
            'content' => '大赛描述',
            'sort' => '排序',
            'status' => '状态',
            'begin_time' => '开始时间',
            'end_time' => '结束时间',
            'number' => '参与作品数',
            'result' => '大赛结果',
            'createtime' => '创建时间',
        ];
    }
}
