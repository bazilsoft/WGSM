<?php

namespace app\controllers;

//use cont\MyClass;
use app\models\Transfer;
use Exception;
//use SourceQuery\SourceQuery;
use app\controllers\SourceQuery\SourceQuery;
use app\controllers\cont\MyClass;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\FormatConverter;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class DashboardController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionInfo()
    {
//        $m = new MyClass();
        $n = new MyClass();
//        return $this->render('info', $n->test());

        $Query = new SourceQuery();

        $param = Yii::$app->params['servers'][0];
        $serverAddress = $param['address'];
        $serverPort =  $param['port'];
        $pass =  $param['pass'];
        $timeout = 1;
        $engine = SourceQuery::SOURCE;

        $Timer = MicroTime(true);
        $Info = Array();
        $Rules = Array();
        $Players = Array();

        $Query = new SourceQuery();

        try {

            $Query->Connect($serverAddress, $serverPort, $timeout, $engine);
            //$Query->SetUseOldGetChallengeMethod( true ); // Use this when players/rules retrieval fails on games like Starbound

            $Info = $Query->GetInfo();
            $Players = $Query->GetPlayers();
            $Rules = $Query->GetRules();
            $Timer = Number_Format(MicroTime(true) - $Timer, 4, '.', '');

            $result = "ok";

        } catch (Exception $e) {
            $Exception = $e;
        } finally {
            $Query->Disconnect();
        }
        return $this->render('info', ['Info' => $Info, 'Players' => $Players, 'Rules' => $Rules, 'Timer' => $Timer]);
    }


    public function actionMessage()
    {
        $param = Yii::$app->params['servers'][0];
        $serverAddress = $param['address'];
        $serverPort =  $param['port'];
        $pass =  $param['pass'];
        $timeout = 1;
        $engine = SourceQuery::SOURCE;
        $Query = new SourceQuery();
        $message = " wrong";
        $chat = '';
        $model = new Transfer();
        $mes = '';
        $type = null;
        $types = [0 => 'ServerChat', 1 => 'BroadCast'];
        $request = \Yii::$app->getRequest();
        try {

            if (
                $request->isAjax
                &&
                $model->load($request->post())
//                Yii::$app->request->isPost &&
//                $model->load(Yii::$app->request->post())
            ) {
                $type = $model->command;
                $mes = $model->message;
                $chat = $model->chat;

                $code = mb_detect_encoding($mes);
                $message = $type . ' ' . $mes;

//                $message = 'ServerChat Admin: ' . iconv('utf-8', 'windows-1251', $model->message) ."\n \n" ;

                $Query->Connect($serverAddress, $serverPort, $timeout, $engine);
                $Query->SetRconPassword($pass);
//                $convertedText = utf8_encode ( $message );
//                $convertedText = mb_convert_encoding($message, 'utf-8', mb_detect_encoding($message));

//                $var = iconv('utf-8', 'windows-1251', $var);
                $an = $Query->Rcon($message); // отправка сообщения
//                $an ='';
//                $chatData = $Query->Rcon('getLogChat');

                $chatData = $Query->Rcon('GetChat');

                if($chat !== $chatData){
                    $chat .= "\n" . $chatData;
                }
//                $code = mb_detect_encoding($chatData);
                Yii::$app->response->format = Response::FORMAT_JSON;

//                return $this->render('message', ['model' => $model, 'message' => $an]);
                return ['success' => $chatData , 'chat' => $model];
//                return ['success' => $chatData . " " . $code, 'chat' => $model];
            } else {
                $message = 'ServerChat Admin: not valid ' .date('H:i:s');

//            if(is_null($type) || empty($mes)){
//                return $this->render('message', ['model'=>$model, 'message' => '']);
//            }

                $Query->Connect($serverAddress, $serverPort, $timeout, $engine);
                $Query->SetRconPassword($pass);
                $an = $Query->Rcon($message); // отправка сообщения
//
//            if ($an == 'Server received, But no response!! '){
//                $message = "Сощбщение отправлено";
//            } else {
//                $message = "it ok / result = " . $an;
//            }

//            $an = $Query->Rcon('GetChat');
                //echo print_r( $an);
                //echo "=== \n";
//	var_dump( $Query->Rcon( 'ServerChat Admin: Hi ppl !!~!' ) );

//            echo "=== \n";
//            $model->setChat('jjjjjjj');
//            $model->chat = 'jjjjjjj';

                $chatData = $Query->Rcon('getLogChat');

//            $chatData = $Query->Rcon('Enable Admin-Log'); //logCommands
//            $chatData = $Query->Rcon('GetChat');

                if (!empty($model->chat)) {
//                foreach ($chatData as $data){
                    $model->chat .= "\n" . $chatData;
//                }
                }
//            else {
//                $model->chat = $chatData . "";
//            }

//            $message = "it ok / result = " . $an;

            }

        } catch (Exception $e) {
            echo $e->getMessage();
        } finally {
            $Query->Disconnect();
        }
//        $model->setAttributes(['chat' => 'popopop']);

        $chat = '';
        return $this->render('message', ['model' => $model, 'message' => $an, 'chat' => $chat]);
//        $message
    }


    public function actionRefreshChat()
    {
        $param = Yii::$app->params['servers'][0];
        $serverAddress = $param['address'];
        $serverPort =  $param['port'];
        $pass =  $param['pass'];
        $timeout = 1;
        $engine = SourceQuery::SOURCE;
        $Query = new SourceQuery();
        $message = " wrong";
        $chat = '';

        try {

//            $res =json_encode(Yii::$app->request);
//            $res = json_encode(Yii::$app->request->post());
//            $res = Yii::$app->request->post();
//            $data = \Yii::$app->request->getRawBody();
//            $res = json_encode($data);
//            $data = \Yii::$app->request->post();
//            $userDate = Yii::$app->request->post();
//            $userDate = \Yii::$app->request->post('myid');     // Только post
//            $userDate = \Yii::$app->request->getQueryParam('myid'); // 'myid'

//            $userDate = \Yii::$app->request->getParams();    // Для post и get
//            $res = $data['rty'];
//            $res = json_encode($userDate, JSON_UNESCAPED_UNICODE);

            $chat = '';
            if (Yii::$app->request->isAjax) {
                $data ='';
                $d = Yii::$app->request->post();
                $chat = $d['chat'];

            }

            $Query->Connect($serverAddress, $serverPort, $timeout, $engine);
            $Query->SetRconPassword($pass);
            $chat = $Query->Rcon('GetChat');

            if($chat == "Server received, But no response!! \n "){
                return  '';
            }

//            if (is_array($chatData)) {
//                foreach ($chatData as $data) {
//                    $chat .= $data . "==\n";
//                }
//            } else {
//                $chat = '|'.$chatData.'|';
//            }


        } catch (Exception $e) {
            echo $e->getMessage();
        } finally {
            $Query->Disconnect();
        }

        return  $chat;
    }


}