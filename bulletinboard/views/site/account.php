<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AccountForm */
/* @var $form ActiveForm */
?>
<div>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],
        /*'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ]*/]) ?>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'username')->textInput(['readonly' => true, 'style'=>'width:200px']) ?>
            <?= $form->field($model, 'email')->textInput(['readonly' => true, 'style'=>'width:200px']) ?>
            <?= $form->field($model, 'password')->textInput(['maxlength'=>20, 'style'=>'width:200px']) ?>
            <?= $form->field($model, 'information')->textArea(['rows' => '6', 'maxlength'=>250, 'style'=>'width:400px']) ?>
            <?= $form->field($model, 'avatar')->fileInput() ?>
            <!--?= Html::fileInput($model->avatar)?-->
        </div>
        <div class="col-md-5">
            <br>
            <br>
            <?= Html::img($model->avatar)?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div><!-- account -->
