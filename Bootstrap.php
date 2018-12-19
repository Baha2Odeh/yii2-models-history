<?php

namespace qvalent;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Bootstrap implements BootstrapInterface
{
    const INSERT = 'INSERT';
    const UPDATE = 'UPDATE';
    const DELETE = 'DELETE';
    /**
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_INSERT, function ($event) {
            $this->insertHistory($event->sender, self::INSERT);
        });
        Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_UPDATE, function ($event) {
            $this->insertHistory($event->sender, self::UPDATE);
        });
        Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_DELETE, function ($event) {
            $this->insertHistory($event->sender, self::DELETE);
        });
    }
    /**
     * @param $model ActiveRecord
     * @param $type
     * @throws \yii\db\Exception
     */
    private function insertHistory($model, $type)
    {
        try {
            $collection = Yii::$app->mongodb->getCollection('cms_log');
            $collection->insert([
                    'changed_by' => Yii::$app->has('user') && Yii::$app->user->isGuest ? null : Yii::$app->user->id,
                    'userIP' => Yii::$app->has('request') ? Yii::$app->request->userIP : null,
                    'userAgent' => Yii::$app->has('request') ? Yii::$app->request->userAgent : null,
                    'date' => date('c'),
                    'model_class' => $model::className(),
                    'pk' => $model->getPrimaryKey(),
                    'operation_type' => $type,
                    'data' => ArrayHelper::toArray($model),
                ]);
        }catch (\Exception $e){

        }


    }
}
