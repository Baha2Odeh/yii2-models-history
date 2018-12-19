Model updates history stored in Mongo
==================================
Extension is automatically saves all ActiveRecords inserts, updates and deletes at collection `cms_log`

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist qvalent/yii2-models-history "*"
```

or add

```
"qvalent/yii2-models-history": "*"
```

to the require section of your `composer.json` file.

Then apply migration:

```
php yii migrate --migrationPath="@vendor/qvalent/yii2-models-history/migrations"
```

Usage
-----

No other steps required. Extension is working now, you can test it by update some project ActiveRecord and see updates in `{{%models_history}}`.

Feel free to create issues if something is wrong.
