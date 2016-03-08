<?php


echo '<h3>';
echo Yii::$app->getRequest()->getQueryParam('user') . ' not found';
echo '</h3>';