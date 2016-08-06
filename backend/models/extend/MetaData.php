<?php

namespace app\models\extend;

class MetaData extends \app\models\native\TblMetaData {

    public function rules() {
        return [
            [['group_key', 'key', 'value', 'sort'], 'required'],
            [['sort', 'status'], 'integer'],
            [['group_key'], 'string', 'max' => 64],
            [['key'], 'string', 'max' => 65],
            [['value'], 'string', 'max' => 128],
        ];
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->status = 1;
        }
        return parent::beforeSave($insert);
    }

}
