<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use yii\helpers\Url;
use yii\widgets\Pjax;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div>
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],
            ])?>
            <div class="row">
                <div class="col-md-3">
                    <?= Html::label($user->username)?>
                    <br>
                    <?= Html::img($user->avatarUrl)?>
                    <br>
                    <?= Html::label($user->information)?>
                    <br>
                </div>
                <div class="col-md-5">
                    <?= Html::label("Rate") ?>
                    <br>
                    <?php Pjax::begin(['enablePushState' => false]); ?>
                    <?php
                    // if user is not guest OR
                    // if this is not page of logged user
                    if((!Yii::$app->user->isGuest) && (Yii::$app->user->identity->username != Yii::$app->getRequest()->getQueryParam('user'))) {
                        echo Html::a('', ['site/rateup', 'user' => $user->username], ['class' => 'btn btn-lg btn-warning glyphicon glyphicon-arrow-up']);
                        echo Html::a('', ['site/ratedown', 'user' => $user->username], ['class' => 'btn btn-lg btn-primary glyphicon glyphicon-arrow-down']);
                    }
                    ?>
                    <h1><?= Html::label($user->rate) ?></h1>
                    <?php Pjax::end(); ?>
                </div>

            </div>
            <div class="comments">
                <div class="comment">
                    <?php foreach ($comments as $com): ?>
                    <div class="comment-head">
                        <?= Html::label($com->addedDate) ?>
                    </div>
                    <div class="comment-body">
                        <?= Html::label($com->comment) ?>
                    </div>
                    <div class="comment-footer">
                        <?= Html::a($com->author, Url::toRoute(['/site/comment', 'user' =>  $com->author]))?>
                        <!--?= Html::label($com->author) ?-->
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="paginator" align="center">
                    <?= LinkPager::widget(['pagination' => $pagination]) ?>
                </div>
            </div>
            <?php
            if(!Yii::$app->user->isGuest) {
                echo '<div class="addComment">';
                echo $form->field($newComment, "comment")->textArea(["rows" => 5, "maxlength" => 150]);
                echo '</div>';
                echo Html::submitButton("Add comment", ["class" => "btn btn-primary btn pull-right"]);
            }
            ?>
            <?php ActiveForm::end(); ?>
        </div>
    </body>
</html>

