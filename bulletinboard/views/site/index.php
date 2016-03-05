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
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>

    <!-- modal dialog for adding bulletin start -->
    <div class="modal fade" id="addBulletinModal" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <?php Pjax::begin([
                'timeout' => 10000,
            ]); ?>
            <?= Html::beginForm(['site/add'], 'post', ['data-pjax' => '', 'options' => ['enctype' => 'multipart/form-data']]); ?>
            <?php
            if($response == 2) {
                echo '<div class="alert alert-success">
                        <strong>Success!</strong> Bulletin was added successfully!
                        </div>';
            }
            else if($response == 1){
                echo    '<div class="alert alert-danger">
                        <strong>Error!</strong> Oooops! There are some problems with adding bulletin!
                        </div>';
            }
            ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="gridSystemModalLabel">Add bulletin</h4>
                </div>
                <div class="modal-body" style="font-size:16px">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="form-group">

                                <label for="usr">Title:</label>
                                <?= Html::input('text', 'title', Yii::$app->request->post('title'), ['id' => 'title', 'class' => 'form-control']) ?>
                                <br>
                                <label for="usr">Description:</label>
                                <br>
                                <?= Html::textarea('description', Yii::$app->request->post('description'), ['id' => 'description', 'class' => 'form-control', 'rows' => '6']) ?>
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
                    <?= Html::submitButton('Add', ['site/add', 'class' => "btn btn-default", 'id' => 'add']) ?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div><!-- /.modal-content -->
            <?= Html::endForm() ?>
            <?php Pjax::end(); ?>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- modal dialog for adding bulletin ends -->
        <?php
            if(!Yii::$app->user->isGuest){
               echo '<button id="addBulletin" type="button" class="btn btn-default pull-right" data-target="addBulletinModal">Add bulletin</button>';
            }
        ?>
    <h3><?= $response ?></h3>
        <?php foreach ($bulletins as $bulletin): ?>
            <div class="bulletin">
                <?= Html::encode("{$bulletin->authorId} ({$bulletin->addedDate})") ?>:
                <?= $bulletin->description ?>
            </div>
        <?php endforeach; ?>
    <footer>
            <div class="paginator" align="center">
                <?= LinkPager::widget(['pagination' => $pagination]) ?>
            </div>

    </footer>
    </body>
</html>
