<?php

namespace app\models;

use Yii;
use yii\imagine\Image;
use Imagine\Image\Box;

/**
 * This is the model class for table "guestbook".
 *
 * @property integer $id
 * @property string $ip
 * @property string $browser
 * @property string $name
 * @property string $email
 * @property string $homepage
 * @property string $message
 * @property string $msgputtime
 * @property string $image
 * @property string $file
 */
class Guestbook extends \yii\db\ActiveRecord
{
    public $fileImage;
    public $fileFile;
    public $verifyCode;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'guestbook';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'message', 'verifyCode'], 'required'],
            ['name', 'match', 'pattern' => '/^[a-z]\w*$/i'],
            [['message'], 'string'],
            [['msgputtime'], 'safe'],
            ['email', 'email'],
            ['homepage', 'url', 'defaultScheme' => 'http'],
            ['verifyCode', 'captcha'],
            [['fileImage'], 'file', 'extensions' => ['jpg', 'gif', 'png']],
            [['fileFile'], 'file', 'extensions' => ['txt'], 'maxSize' => 1024 *100],
            [['ip', 'browser', 'name', 'email', 'homepage', 'image', 'file'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
            'browser' => 'Browser',
            'name' => 'Name',
            'email' => 'Email',
            'homepage' => 'Homepage',
            'message' => 'Message',
            'msgputtime' => 'Message put time',
            'image' => 'Image',
            'file' => 'File',
            'verifyCode' => 'Verification Code',
        ];
    }

    public function uploadImage($path)
    {
           $dir = Yii::getAlias($path);
           $uid = md5(uniqid(rand(), true));
           $gen_path = $path . $uid;

           if( !is_dir($gen_path) ) 
                mkdir($gen_path, 777, true);

           $fileName = $this->fileImage->baseName . '.' . $this->fileImage->extension;
           $photo = Image::getImagine()->open($this->fileImage->tempName);
           $photo->thumbnail(new Box(320, 240))->save($gen_path . '/' . $fileName);
           $this->image = '/' . $dir . $uid . '/' . $fileName;
    }

    public function uploadFile($path)
    {
           $dir = Yii::getAlias($path);
           $uid = md5(uniqid(rand(), true));
           $gen_path = $path . $uid;

           if( !is_dir($gen_path) ) 
                mkdir($gen_path, 777, true);

           $fileName = $this->fileFile->baseName . '.' . $this->fileFile->extension;
           $this->fileFile->saveAs($gen_path . '/' .$fileName);
           $this->file = '/' . $dir . $uid . '/' . $fileName;
    }


}
