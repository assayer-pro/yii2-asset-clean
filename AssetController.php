<?php
/**
 * @copyright 2015 Assayer Pro Company http://assayer.pro
 * @author Serge Larin <serge.larin@gmail.com>
 * @license GNU Public License http://opensource.org/licenses/gpl-license.php
 * @link http://assayer.pro
 */

namespace assayerpro\assetClean;

use Yii;
use yii\helpers\Console;
use yii\helpers\FileHelper;

/**
 * AssetController
 *
 * @package app\console
 */
class AssetController extends \yii\console\controllers\AssetController
{
    /**
     * @var array
     */
    public $ignoreDirs = [];
    /**
     * @var string do not delete anything
     */
    public $dryRun = false;
    /**
     * @var boolean echo rules being run, dir/file being deleted
     */
    public $verbose = false;
    /**
       @var boolean quiet;  do  not  write  anything to standard output.
     */
    public $quiet = false;
    /**
     * @var string assets cached directory
     */
    public $assetsDir = '@webroot/assets';

    /**
     * @inheritdoc
     */
    public function options($actionID)
    {
        return array_merge(
            parent::options($actionID),
            ($actionID == 'clean') ? ['assetsDir', 'quiet', 'verbose', 'dryRun'] : []
        );
    }

    /**
     * message
     *
     * @param string $string
     * @access private
     * @return integer|null
     */
    private function message($string)
    {
        if (!empty($string) && !$this->quiet) {
            $args = func_get_args();
            array_shift($args);
            $string = Console::ansiFormat($string, $args);
            return Console::stdout($string);
        }
    }
    /**
     * Clean cached assets in @webroot/assets directory
     *
     */
    public function actionClean()
    {
        $this->cleanAssetsDir();
        return true;
    }

    public function cleanAssetsDir()
    {
        $this->message("Cleaning assets dir...\n", Console::FG_GREEN);
        $assetsDirs = glob(Yii::getAlias($this->assetsDir).'/*', GLOB_ONLYDIR);
        foreach ($assetsDirs as $dir) {
            if (in_array(basename($dir), $this->ignoreDirs)) {
                $this->message('ignored '.$dir.', last modified '.Yii::$app->formatter->asDatetime(filemtime($dir))."\n", Console::FG_YELLOW);
                continue;
            }
            $this->message('removed '.$dir.', last modified '.Yii::$app->formatter->asDatetime(filemtime($dir))."\n", Console::BOLD);
            if (!$this->dryRun) {
                FileHelper::removeDirectory($dir);
            }
        }
        $this->message("Done. Assets dir cleaned\n", Console::FG_GREEN);

    }
}
