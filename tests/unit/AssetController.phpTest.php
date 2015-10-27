<?php
use \assayerpro\assetClean\AssetController;
use yii\helpers\FileHelper;

class AssetControllerTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
        yii\helpers\FileHelper::createDirectory(Yii::getAlias('@webroot/assets'));
        yii\helpers\FileHelper::createDirectory(Yii::getAlias(__DIR__ . '/test'));
        foreach ([
            '2f583088', '3e1a549', '8d691dd2', 'c9d16bd5', 'css', 'd6e74ee9',
            'e8b72499',  'f585e903',  'fbce137b', 'js'] as $dir)
        {
             FileHelper::createDirectory(Yii::getAlias('@webroot/assets/'.$dir));
             FileHelper::createDirectory(Yii::getAlias(__DIR__ . '/test/'.$dir));
        };
    }

    protected function _after()
    {
        yii\helpers\FileHelper::removeDirectory(Yii::getAlias('@webroot/assets'));
        yii\helpers\FileHelper::removeDirectory(Yii::getAlias(__DIR__.'/assets'));
    }

    // tests
    public function testCleanAssetsDir()
    {
      $assetController = new AssetController('AssetController', 'command');
      $assetController->dryRun = true;
      $assetController->cleanAssetsDir();
      $assetDirs = glob(Yii::getAlias('@webroot/assets/') . '/*' , GLOB_ONLYDIR);
      $this->assertEquals(count($assetDirs), 10);

      $assetController->dryRun = false;
      $assetController->ignoreDirs = ['js', 'css'];
      $assetController->cleanAssetsDir();
      $assetDirs = glob(Yii::getAlias('@webroot/assets/') . '/*' , GLOB_ONLYDIR);
      $this->assertEquals(count($assetDirs), 2);

      $assetController->ignoreDirs = [];
      $assetController->cleanAssetsDir();
      $assetDirs = glob(Yii::getAlias('@webroot/assets/') . '/*' , GLOB_ONLYDIR);
      $this->assertEquals(count($assetDirs), 0);

      $assetController->assetsDir = __DIR__ . '/test';
      $assetController->ignoreDirs = ['js', 'css'];
      $assetController->quiet = true;
      $assetController->cleanAssetsDir();
      $assetDirs = glob(__DIR__ . '/test/*' , GLOB_ONLYDIR);
      $this->assertEquals(count($assetDirs), 2);
    }

}
