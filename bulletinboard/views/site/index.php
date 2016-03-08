<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\widgets\Pjax;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],
    ])?>
    <!-- modal dialog for adding bulletin start -->
    <div class="modal fade" id="addBulletinModal" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="gridSystemModalLabel">Add bulletin</h4>
                </div>
                <div class="modal-body" style="font-size:16px">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="form-group">
                                <?= $form->field($newBulletin, 'title')->textInput(['maxlength' => 30]) ?>
                                <br>
                                <?= $form->field($newBulletin, 'description')->textArea(['rows' => '6', 'maxlength'=>200]) ?>
                                <br>
                                <label for="usr">Images:</label>
                                <br>
                                <?= Html::fileInput('imageFiles[]', null, ['multiple' => true, 'accept' => 'image/*'])?>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <?= Html::submitButton('Add', ['site/index', 'class' => "btn btn-default", 'id' => 'add']) ?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div><!-- /.modal-content -->

        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- modal dialog for adding bulletin ends -->
    <?php ActiveForm::end(); ?>
        <?php
            if(!Yii::$app->user->isGuest){
               echo '<button id="addBulletin" type="button" class="btn btn-default pull-right" data-target="addBulletinModal">Add bulletin</button>';
            }
        ?>
    <h3><?= $response ?></h3>
        <?php foreach ($bulletins as $bulletin): ?>
            <div class="bulletin">
                <div class="bulletin-head">
                    <?= Html::label($bulletin->addedDate)?>
                </div>
                <div class="bulletin-body">
                    <?= Html::label($bulletin->title, null, ['style' => 'border-bottom: 2px solid maroon'] )?>
                    <br>
                    <?= Html::label($bulletin->description )?>
                </div>
                <br>
                <br>
                <div class="bulletin-footer">
                    <?= Html::a($bulletin->authorId, Url::toRoute(['/site/comment', 'user' =>  $bulletin->authorId]))?>
                </div>
            </div>
        <?php endforeach; ?>
    <footer>
            <div class="paginator" align="center">
                <?= LinkPager::widget(['pagination' => $pagination]) ?>
            </div>

    </footer>
    </body>
</html>
