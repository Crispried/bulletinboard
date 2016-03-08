<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],
        /*'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ]*/]) ?>
    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'username')->textInput(['readonly' => true, 'style'=>'width:200px']) ?>
            <?= $form->field($model, 'email')->textInput(['readonly' => true, 'style'=>'width:200px']) ?>
            <?= $form->field($model, 'password')->textInput(['maxlength'=>20, 'style'=>'width:200px']) ?>
            <?= $form->field($model, 'information')->textArea(['rows' => '6', 'maxlength'=>250, 'style'=>'width:400px']) ?>
            <?= $form->field($model, 'avatar')->fileInput() ?>
        </div>
        <div class="col-md-3">
            <div class="avatar">
                <?= Html::label("My rate is " . $model->rate, null, ['style' => 'border: 2px ridge black; padding: 5px']) ?>
                <br>
                <br>
                <?= Html::img($model->avatar)?>
            </div>

        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('My comments', ['/site/comment', 'user' =>  $model->username], ['class'=>'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div><!-- account -->
