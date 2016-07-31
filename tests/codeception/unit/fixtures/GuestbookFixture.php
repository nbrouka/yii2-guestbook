<?php
namespace tests\unit\fixtures;

use yii\test\ActiveFixture;

class GuestbookFixture extends ActiveFixture
{
    public $modelClass = 'app\models\Guestbook';
    public $dataFile = 'tests/codeception/unit/fixtures/data/guestbook.php';
}