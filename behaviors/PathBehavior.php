<?php

namespace pesto\path\behaviors;

use dosamigos\transliterator\TransliteratorHelper;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;

class PathBehavior extends AttributeBehavior {

    public $fieldName = 'path';
    public $fromFieldName = 'title';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => $this->fieldName,
                BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->fieldName,
            ];
        }
    }

    /**
     * @inheritdoc
     */
    protected function getValue($event) {

        //Если поле пустое
        if(empty($this->owner->{$this->fieldName})) {

            //Берем данные с другого поля
            $path = $this->owner->{$this->fromFieldName};

            //Конвертируем в латиницу и убираем лишние символы
            $path = \yii\helpers\Inflector::slug(TransliteratorHelper::process($path));

            $i = 0;
            $new_path = $path;
            /** @var ActiveRecord $class */
            $class = $this->owner->className();

            //Пока не найдем сводобный путь
            while($class::findOne([$this->fieldName => $new_path])) {
                $new_path = $path . '-' .$i++;
            }

            return $new_path;
        } else {
            return $this->owner->{$this->fieldName};
        }
    }
}