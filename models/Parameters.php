<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class Parameters extends ActiveRecord
{
    public $icon;
    public $icon_gray;

    public static function tableName()
    {
        return 'parameters';
    }

    public function rules()
    {
        return [
            [['title', 'type'], 'required'],
            [['type'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['icon', 'icon_gray'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 2],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            foreach (['icon', 'icon_gray'] as $file) {
                $uploadedFile = UploadedFile::getInstance($this, $file);
                if ($uploadedFile) {
                    $fileName = strtolower(preg_replace('/[^a-zA-Z0-9-_\.]/', '', str_replace(' ', '_', $uploadedFile->baseName))) . '.' . $uploadedFile->extension;
                    $filePath = 'uploads/' . $fileName;
                    $uploadedFile->saveAs($filePath);
                    $this->$file = $filePath;
                }
            }
            return true;
        }
        return false;
    }
}

