<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Guestbook;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Displays guestbook.
     *
     * @return string
     */
    public function actionGuestbook()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Guestbook::find(),
            'pagination' => [
                'pageSize' => 25,
            ],
            'sort' => [
                'defaultOrder' => [
                    'msgputtime' => SORT_DESC,
                ],
                'attributes' => [
                     'name', 'email', 'msgputtime'   
                ]
            ]
        ]);

        $model = new Guestbook();

        if ( $model->load(Yii::$app->request->post()) )
        {
            $model->msgputtime = date("c");
            $model->ip = Yii::$app->request->userIP;
            $model->browser = Yii::$app->userAgent->user_browser(Yii::$app->request->userAgent);

            $model->fileImage = UploadedFile::getInstance($model, 'fileImage');
            if($model->validate(['fileImage']) && $model->fileImage && $model->fileImage->tempName)
                $model->uploadImage("uploads/img/");

            $model->fileFile = UploadedFile::getInstance($model, 'fileFile');
            if($model->validate(['fileFile']) && $model->fileFile && $model->fileFile->tempName)
                $model->uploadFile("uploads/files/");

            $model->fileImage = NULL;
            $model->fileFile = NULL;
             // var_dump($model->image);
             // var_dump($model->file);
           // exit();
           $model->save();
        }


        return $this->render('guestbook', [
            'dataProvider' => $dataProvider,
            'model'=> new Guestbook()
        ]);
    }
}
