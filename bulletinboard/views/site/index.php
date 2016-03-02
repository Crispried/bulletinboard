<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <?php
            if(!Yii::$app->user->isGuest){
               echo '<div align="right">'.Html::a('Add bulletin', ['/site/AddBulletin'], ['class'=>'btn btn-primary']).'</div>';
            }
        ?>
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
