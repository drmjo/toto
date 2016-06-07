<?php

namespace Coyote\BaseBundle\Composer;

use Symfony\Component\ClassLoader\ClassCollectionLoader;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\PhpExecutableFinder;
use Composer\Script\CommandEvent;
use Sensio\Bundle\DistributionBundle\Composer\ScriptHandler as SensioScriptHander;

class ScriptHandler extends SensioScriptHander
{
    public static function installAssets(CommandEvent $event)
    {
        if(!$event->isDevMode())
            return;

        $options = static::getOptions($event);
        $consoleDir = static::getConsoleDir($event, 'install assets');

        if (null === $consoleDir) {
            return;
        }

        $webDir = $options['symfony-web-dir'];

        $symlink = '';
        if ($options['symfony-assets-install'] == 'symlink') {
            $symlink = '--symlink ';
        } elseif ($options['symfony-assets-install'] == 'relative') {
            $symlink = '--symlink --relative ';
        }

        if (!static::hasDirectory($event, 'symfony-web-dir', $webDir, 'install assets')) {
            return;
        }

        static::executeCommand($event, $consoleDir, 'assets:install '.$symlink.escapeshellarg($webDir), $options['process-timeout']);
    }

    public static function cleanUp(CommandEvent $event)
    {
        if($event->isDevMode())
            $event->getIO()->Write('<info>Dev Mode no cleanup</info>');
        else
            static::removeNonProductionFiles($event);
    }

    public static function removeNonProductionFiles(CommandEvent $event)
    {
        $approot = static::getAppRoot();

        $files = [
            $approot . '/web/app_dev.php',
            $approot . '/web/config.php',
        ];

        $fs = new Filesystem();
        try {
            $fs->remove($files);
        } catch (IOException $e) {
            $event->getIO()->write('<warning>' . $e->getMessage() . '</warning>');
        } finally {
            $event->getIO()->write('<info>Dev Files Removed!</info>');
        }
    }

    public static function setPermissions(CommandEvent $event)
    {
        $approot = static::getAppRoot();
        $stdout = static::runBash('/bin/bash ' . $approot . '/bash/set_permissions');

        $event->getIO()->write('<info>' . $stdout . '</info>');
    }

    public static function getAppRoot()
    {
        return trim(static::runBash('/bin/pwd'));
    }

    public static function runBash($cmd)
    {
        $process = new Process($cmd, null, null, null, null);
        $vars = new \stdClass();

        $process->run(function ($type, $buffer) use ($vars) {
            $vars->buffer = $buffer;
        });

        if (!$process->isSuccessful()) {
            throw new \RuntimeException(sprintf('An error occurred when executing the "%s" command.', $cmd));
        }

        return $vars->buffer;
    }

    public static function migrate(CommandEvent $event)
    {
        static::executeCommand($event, static::getConsoleDir($event, 'migrate DB'), 'doctrine:migrations:migrate --no-interaction', null);

    }

    public static function createDb(CommandEvent $event)
    {
        $options = static::getOptions($event);
        $consoleDir = static::getConsoleDir($event, 'Create Database');

        if (null === $consoleDir) {
            return;
        }

        static::executeCommand($event, $consoleDir, 'doctrine:database:create --if-not-exists', $options['process-timeout']);
    }

    /**
     * Clears the Symfony cache.
     *
     * @param $event CommandEvent A instance
     */
    public static function clearCache(CommandEvent $event)
    {
        $options = static::getOptions($event);
        $consoleDir = static::getConsoleDir($event, 'clear the cache');

        if (null === $consoleDir) {
            return;
        }

        $warmup = '';
        if (!$options['symfony-cache-warmup']) {
            $warmup = ' --no-warmup';
        }

        static::executeCommand($event, $consoleDir, 'cache:clear -e prod' . $warmup, $options['process-timeout']);
    }
}