<?php

use \yii\widgets\ActiveForm;
use \yii\bootstrap\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Transfer */
/* @var $message string */
/* @var $chat string */


$this->title = 'сообщение';
//$this->params['breadcrumbs'][] = $this->title;

?>
    <div class="site-index">

        <div class="jumbotron">
            <p class="lead">Панель управления</p>
            <p class="lead">Сейчас работает только для карты генезис</p>
            <p class="lead">Далее сделаю выбор карт</p>
        </div>

        <div class="body-content">

            <!--        < ?php $form = ActiveForm::begin(); ?>-->
            <?php $form = \yii\widgets\ActiveForm::begin([
                'id' => 'my-form-id',
                'action' => 'message',
                'enableAjaxValidation' => true,
//            'validationUrl' => 'my-validation-url',
            ]); ?>

            <div class="row">
                <div class="col-lg-4">
                    <?php echo $form->field($model, 'command')->dropDownList([
                        'ServerChat' => 'Сообщение в чат',
                        'BroadCast' => 'Всплывающее сообщение всем',
//                    '2' => 'Команда'
                    ])->label('Команда');
                    ?>

                </div>
                <div class="col-lg-4">

                    <?php echo $form->field($model, 'user')->dropDownList([
                        '0' => '',
                        '1' => 'Yrick',
                        '2' => 'Suron',
                        '3' => 'Yrick',
                        '4' => 'Magic-pipl',
                        '5' => 'Жора',
                        '6' => 'Yrick',
                    ])->label('Имя игрока'); ?>

                </div>

                <div class="col-lg-4">

                    <?php echo $form->field($model, 'property')->dropDownList([
                        '0' => '',
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                    ])->label('дополнительно'); ?>

                </div>

            </div>

            <div class="row">
                <div class="col-lg-12">
                    <?php echo $form->field($model, 'message')->textInput()->label('Сообщение'); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <?= Html::submitButton('Отправить сообщение', ['class' => 'btn btn-success']); ?>
                    <!--                < ?= Html::a('Отправить', ['dashboard/message'], ['class' => 'btn btn-success']) ?>-->
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12" >
                <?php echo $form->field($model, 'chat')->textarea(['rows' => '6'])->label('Чат'); ?>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>

    <div class="row">
        <div class="col-lg-12" id="chat">
        </div>
    </div>

<?php
$js = <<<JS
     $('form').on('beforeSubmit', function(){
	 var data = $(this).serialize();
	 $.ajax({
	    url: '/dashboard/message',
	    type: 'POST',
	    data: data,
	    success: function(res){
	       console.log(res);
	    },
	    error: function(){
	       alert('Error!');
	    }
	 });
	 return false;
     });
JS;
$this->registerJs($js);

$script = <<< JS
$(document).ready(function() {
    setInterval(function(){ 
	 // var data = $(this).serialize();
	 // var data = "$ chat";
	 // var data = $("$ chat" + "dfg").serialize();
	 var data = {chat:"$chat", id:555};
	 
	 $.ajax({
	    url: '/dashboard/refresh-chat',
	    type: 'POST',
	    // contentType: 'application/json',
	    data: data,
	    success: function(res){
	        $('#chat').text("$chat" + res);
	       console.log(res);
	    },
	    error: function(){
	       alert('Error!');
	    }
	 });
    }, 1000);
});
JS;
$this->registerJs($script);

//$js = <<<JS
//$(document).ready(function() {
//    $('#form').on('beforeSubmit', function () {
//        var $ yiiform = $(this);
//        // отправляем данные на сервер
//        $.ajax({
//                type: $ yiiform.attr('method'),
//                url: $ yiiform.attr('action'),
//                data: $ yiiform.serializeArray()
//            }
//        )
//        .done(function(data) {
//            if(data.success) {
//                // данные сохранены
//            } else {
//                // сервер вернул ошибку и не сохранил наши данные
//            }
//        })
//        .fail(function () {
//            // не удалось выполнить запрос к серверу
//        });
//
//        return false; // отменяем отправку данных формы
//    })
//});
//JS;

?>