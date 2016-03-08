<?php

namespace app\controllers;

use app\models\entities\Comment;
use app\models\entities\Image;
use Faker\Provider\Biased;
use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\entities\Bulletin;
use yii\data\Pagination;
use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\AccountForm;
use app\models\entities\User;
use yii\web\UploadedFile;
use yii\helpers\Url;
use app\models\AddBulletinForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'signup'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login','register'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function actionIndex()
    {
        $query = Bulletin::find()->orderBy(['addedDate' => SORT_DESC])->limit(20);
        $countQuery = count($query->all());
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $countQuery
        ]);
        $bulletins = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        foreach($bulletins as $bulletin){
            $bulletin->authorId = User::getUsernameById($bulletin->authorId); // for view authorId will be authorName
        }
        $newBulletin = new Bulletin();
        if($newBulletin->load(Yii::$app->request->post())){
            $user = User::findByUsername(Yii::$app->user->identity->username);
            $newBulletin->authorId = $user->userId;
            $id = $newBulletin->saveBulletin(); // returns id of saved bulletin
            if($id){
                Image::upload($id);
            }
            return $this->redirect(Url::toRoute(['/site/index']));

        }
        return $this->render('index', [
            'bulletins' => $bulletins,
            'pagination' => $pagination,
            'newBulletin' => $newBulletin
        ]);
    }
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['index']);
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['index']);
    }
    public function actionRegister(){
        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $model->register()){
            return $this->redirect(['index']);
        }
        return $this->render('register', ['model' => $model]);
    }
    public function actionAccount(){

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user = User::findByUsername(Yii::$app->user->identity->username);
        $model = new AccountForm();
        $model->username = $user->username;
        if ($model->load(Yii::$app->request->post())){
            $model->avatar = UploadedFile::getInstance($model, 'avatar');
            $model->update($user);
            return $this->redirect(['account']);
        }
        $model->password = $user->password;
        $model->email = $user->email;
        $model->rate = $user->rate;
        $model->information = $user->information;
        $model->avatar = $user->avatarUrl;
        return $this->render('account', ['model' => $model]);
    }
    public function actionComment(){
        $username = Yii::$app->getRequest()->getQueryParam('user');
        $user = User::findByUsername($username);
        if($user == null){
            return $this->redirect(Url::toRoute(['/site/error', 'user' =>  $username]));
        }
        $query = Comment::find()->where(['userId' => $user->userId])->orderBy(['addedDate' => SORT_DESC]);
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count()
        ]);
        $comments = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        $newComment = new Comment();
        if($newComment->load(Yii::$app->request->post())){

            $author = User::getUsernameById(Yii::$app->user->getId());
            $newComment->addComment($user->userId, $author);
            return $this->redirect(Url::toRoute(['/site/comment', 'user' =>  $username]));

        }
        return $this->render('comment',[
            "user" => $user,
            "comments" => $comments,
            'pagination' => $pagination,
            'newComment' => $newComment
        ]);
    }
    public function actionRateup(){
        $username = Yii::$app->getRequest()->getQueryParam('user');
        $user = User::findByUsername($username);
        $user->rate = $user->rate + 1;
        $user->update();
        return $this->render('comment', ["user" => $user]);
    }
    public function actionRatedown(){
        $username = Yii::$app->getRequest()->getQueryParam('user');
        $user = User::findByUsername($username);
        $user->rate = $user->rate - 1;
        $user->update();
        return $this->render('comment', ["user" => $user]);
    }


    public function updateBulletin(){

    }
    public function addComment(){

    }
    public function updateComment(){

    }
    private function debugger($parameters){
        echo '<script>';
        foreach($parameters as $parameter){
            echo 'console.log("' . $parameter . '");';
        }
        echo '</script>';
    }
}
