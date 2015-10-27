Yii2 console command to clean web/assets/ directory
===================================================

This extension added command 'asset/clean' to console application for removes caches from Yii's web/assets/ directory.

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```bash
$ composer require assayer-pro/yii2-asset-clean:dev-master
```

or add

```
"assayer-pro/yii2-asset-clean": "dev-master"
```

to the `require` section of your `composer.json` file.

Usage
-----
To use this extension, add the following code in your application configuration (console.php):
```php
'controllerMap' => [
    'asset' => [
        'class' => 'assayer-pro\assetClean\AssetController',
    ],
],
```
Then call the extension from the command line 

```bash
/path/yii/web/assets$ ls -l
total 4
lrwxrwxrwx 1 www-data www-data 58 Oct 27 17:49 114607b9 -> /path/yii/vendor/bower/some-package
lrwxrwxrwx 1 www-data www-data 65 Oct 27 17:49 2466e1a -> /path/yii/vendor/bower/some-package2 
lrwxrwxrwx 1 www-data www-data 50 Oct 27 17:49 420da4e -> /path/yii/vendor/yiisoft/yii2/assets
lrwxrwxrwx 1 www-data www-data 55 Oct 27 17:49 85c56229 -> /path/yii/vendor/fortawesome/font-awesome
lrwxrwxrwx 1 www-data www-data 56 Oct 27 17:49 e8db1cdd -> /path/yii/vendor/yiisoft/yii2-debug/assets

/path/yii$ php yii asset/clean
Cleaning assets dir...
removed /path/yii/web/assets/114607b9, last modified Oct 27, 2015, 2:55:06 PM
removed /path/yii/web/assets/2466e1a, last modified Oct 12, 2015, 11:08:59 AM
removed /path/yii/web/assets/420da4e, last modified Mar 30, 2015, 7:50:00 AM
removed /path/yii/web/assets/85c56229, last modified Apr 28, 2015, 4:03:04 PM
removed /path/yii/web/assets/e8db1cdd, last modified Aug 6, 2015, 4:14:06 PM
Done. Assets dir cleaned
```
For ignore some directories add ignoreDirs property, e.g.

```php
'controllerMap' => [
    'asset' => [
        'class' => 'assayer-pro\assetClean\AssetController',
        'ignoreDirs' => ['js', 'css'],
    ],
],
```

Additional arguments
--------------------
```
--assetsDir: string (defaults to '@webroot/assets')
  assets cached directory

--quiet: boolean, 0 or 1 (defaults to 0)
  quiet;  do  not  write  anything to standard output.

--verbose: boolean, 0 or 1 (defaults to 0)
  echo rules being run, dir/file being deleted
```
