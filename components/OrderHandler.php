<?php

namespace app\components;

use app\models\Order;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;
use yii\console\Exception;

class OrderHandler extends Client
{

    public function __construct() {
        parent::__construct();
    }

    public $requestConfig = [
        'format' => Client::FORMAT_JSON
    ];
    public $responseConfig = [
        'format' => Client::FORMAT_JSON
    ];

    public function beforeSend($request)
    {
        $request->setHeaders(['Content-Type' => 'application/json']);
        parent::beforeSend($request);
    }


    /**
     * @param array $orders
     * @throws Exception
     */
    public function _update(array $orders) {
        foreach ($orders as $order) {
            $model = Order::findOne(['real_id' => $order['id']]);
            $order['items_count'] = count($order['items']);
            $order['real_id'] = $order['id'];
            $order['created_at'] = \DateTime::createFromFormat("Y-m-d H:i:s", $order['created_at'])->getTimestamp();
            if (!$model) {
                $model = new Order();
            }
            if (!($model->load($order) && $model->save())) {
                throw new Exception("Ошибка сохранения заказа");
            }
        }
    }


    /**
     * @param string $url
     * @throws Exception
     * @throws \yii\httpclient\Exception
     */
    public function updateNet(string $url) {

        $response = $this->get($url)->send();

        if (!$response->isOk)
            throw new Exception("Ошибка при получении списка заказов");

        $orders = $response->data['orders'];
        $this->_update($orders);

    }


    /**
     * @param string $filename
     * @throws Exception
     */
    public function updateLocal(string $filename) {

        $file = file_get_contents($filename);
        $data = json_decode($file, true);
        $orders = $data['orders'];
        $this->_update($orders);

    }

    /**
     * @param int $id
     * @return false|string
     * @throws Exception
     */
    public function getInfo(int $id) {

        if (!($id >= 0))
            throw new Exception("Введите корректный id заказа");

        $model = Order::findOne(['real_id' => $id]);

        if (!$model)
            throw new Exception('Заказ не найден');

        $order = $model->toArray();
        $order['created_at'] = date("Y-m-d H:i:s", $order['created_at']);
        $order['updated_at'] = date("Y-m-d H:i:s", $order['updated_at']);

        return json_encode($order, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

}