<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\Exception;
use yii\console\ExitCode;
use app\components\OrderHandler;

class OrderController extends Controller
{

    public function actionUpdateNet(string $url = 'https://zelenka.ru/sample/orders.json')
    {

        $handler = new OrderHandler();
        $handler->updateNet($url);

        return ExitCode::OK;
    }


    public function actionUpdateLocal(string $filename = "sample/orders.json")
    {

        $handler = new OrderHandler();
        $handler->updateLocal($filename);

        return ExitCode::OK;
    }


    public function actionInfo(int $id)
    {

        $handler = new OrderHandler();
        print_r($handler->getInfo($id) . "\n");

        return ExitCode::OK;
    }

}