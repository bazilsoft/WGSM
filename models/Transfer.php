<?php


namespace app\models;

use Yii;
use yii\base\Model;

class Transfer extends Model
{

    public $message;
    public $command;
    public $user;
    public $chat;
    public $property;


    public function rules() {
        return [
            [['message' ,'command'], 'required'], // поля обязательные для заполнения
            [['chat' ], 'string'],
//            ['email', 'email'], // поле email должно быть электронным адресом
        ];
    }

//    /**
//     * @return array the validation rules.
//     */
//    public function rules()
//    {
//        return [
//            // username and password are both required
////            [['message', 'command'], 'text'],
//            // rememberMe must be a boolean value
////            ['rememberMe', 'boolean'],
//            // password is validated by validatePassword()
////            ['password', 'validatePassword'],
//        ];
//    }
//
//    public function setChat($message){
//        $this->chat = $this->chat . $message;
//    }
//
//    public function getChat(){
//        return $this->chat;
//    }

}