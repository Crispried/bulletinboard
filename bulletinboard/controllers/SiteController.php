<?php

namespace app\controllers;

use Yii;
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
        $query = Bulletin::find();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $bulletins = $query->orderBy('addedDate')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'bulletins' => $bulletins,
            'pagination' => $pagination,
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
            $session = Yii::$app->session;
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

          //  $model->upload();
           // $model->update();
           // $imageName = $model->username;
            $model->avatar = UploadedFile::getInstance($model, 'avatar');
           // $image->saveAs('../images/account/' . $imageName . '.' . $image->extension);
            $model->update($user);
            return $this->redirect(['index']);
        }
        $model->password = $user->password;
        $model->email = $user->email;
        $model->information = $user->information;
        $model->avatar = $user->avatarUrl;
        return $this->render('account', ['model' => $model]);
    }
    public function actionAddBulletin(){
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new Bulletin();
        if ($model->load(Yii::$app->request->post())) {

        }
    }

    public function updateBulletin(){

    }
    public function addComment(){

    }
    public function updateComment(){

    }
    public function increaseRate(){

    }
}
