Behavior для генерации URL адреса модели при сохранении.

### Install

Выполните команду

```
$ php composer.phar require pesto/yii2-path-behavior "*"
```

или добавьте

```
"pesto/yii2-path-behavior": "*"
```

в секцию ```require``` вашего `composer.json` файла.


### Usage

Теперь можно в методе `behaviors()` модели указать:

```php
  public function behaviors()
  {
      return [
          ...
          [
              'class' => PathBehavior::className(),
              'fieldName' => 'path',          //Поле для генерации пути
              'fromFieldName' => 'title'      //Поле, за основу которого берется строка
          ]
          ...
      ];
  }
```
