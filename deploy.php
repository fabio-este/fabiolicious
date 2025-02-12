<?php

namespace Deployer;

use Deployer\Host\Localhost;
use Deployer\Task\Context;
use PhpParser\Comment;

require 'recipe/common.php';
require 'recipe/typo3.php';
require 'contrib/rsync.php';

date_default_timezone_set('Europe/Berlin');

/**
 * Configuration
 */

// Project name
set('application', 'fabio-licio.us');

// Import hosts
import('servers.yaml');

// Public dir
set('typo3_public', 'public');

set('repository', 'git@github.com:fabio-este/fabiolicious.git');

// [Optional] Allocate tty for git clone. Default value is false.
//set('git_tty', true);
set('ssh_multiplexing', false);

// quiet bash
set('shell', '/bin/bash --noprofile --norc');

//rsync build files and directories to remote server
set('rsync_src', function () {
        return __DIR__ . '/public/build';
});

set('rsync_dest','{{release_path}}/public/build');


// get local bin/php path
set('bin/php', static function () {
    if (has('bin')) {
        $bin = get('bin');
        if (is_array($bin) && isset($bin['php'])) {
            return $bin['php'];
        }
    }
    return locateBinaryPath('php');
});

// get local bin/composer path
set('bin/composer', static function () {
    if (has('bin')) {
        $bin = get('bin');
        if (is_array($bin) && isset($bin['composer'])) {
            return $bin['composer'];
        }
    }
    return locateBinaryPath('composer');
});


/**
 * Shared
 */
// Shared directories
set('shared_dirs', [
    '{{typo3_public}}/fileadmin',
    '{{typo3_public}}/typo3temp',
    '{{typo3_public}}/uploads',
    'config',
    'var'
]);

// Shared files
set('shared_files', [
    '{{typo3_public}}/robots.txt',
    '{{typo3_public}}/.htaccess'
]);


/**
 * Writable
 */

// Writable directories
set('writable_dirs', [
    '{{typo3_public}}/fileadmin',
    '{{typo3_public}}/typo3temp',
    '{{typo3_public}}/typo3conf',
    '{{typo3_public}}/uploads',
    'config',
    'var'
]);

// Writable options
set('writable_tty', true);
set('writable_mode', 'chmod');
set('writable_use_sudo', false);
set('writable_chmod_mode', '0775');
set('writable_chmod_recursive', true);

/**
 * composer
 */
set('composer_action', 'install');
set('composer_options', '--verbose --prefer-dist --no-progress --no-interaction --no-dev --optimize-autoloader');


/**
 * rsync
 */

$rsync = get('rsync');
$rsync['options'] = ['chmod=Dug=rwx,Do=rx,Fug=rw,Fo=r'];
set('rsync', $rsync);


// task to rsync build folder to remote server
task('rsync', function () {
    $config = get('rsync');

    $src = get('rsync_src');
    while (is_callable($src)) {
        $src = $src();
    }

    if (!trim($src)) {
        // if $src is not set here rsync is going to do a directory listing
        // exiting with code 0, since only doing a directory listing clearly
        // is not what we want to achieve we need to throw an exception
        throw new \RuntimeException('You need to specify a source path.');
    }

    $dst = get('rsync_dest');
    while (is_callable($dst)) {
        $dst = $dst();
    }

    if (!trim($dst)) {
        // if $dst is not set here we are going to sync to root
        // and even worse - depending on rsync flags and permission -
        // might end up deleting everything we have write permission to
        throw new \RuntimeException('You need to specify a destination path.');
    }

    $host = Context::get()->getHost();
    if ($host instanceof Localhost) {
        runLocally("rsync -{$config['flags']} {{rsync_options}}{{rsync_includes}}{{rsync_excludes}}{{rsync_filter}} '$src/' '$dst/'", $config);
        return;
    }

    $sshArguments = $host->connectionOptionsString();
    runLocally("rsync -{$config['flags']} -e 'ssh $sshArguments' {{rsync_options}}{{rsync_includes}}{{rsync_excludes}}{{rsync_filter}} '$src/' '{$host->connectionString()}:$dst/'", $config);
});


/**
 * Main task
 */
task('deploy')->desc('Deploy your project');
after('deploy:failed', 'deploy:unlock');
after('deploy:symlink', 'rsync');

/**
 * Parse the .htaccess file for the right environment
 */
task('htaccess', static function () {

    // read the stage
    $stage = NULL;
    if (input()->hasArgument('stage')) {
        $stage = input()->getArgument('stage');
    }

    if ($stage === NULL) {
        writeln('You need to specify a stage.');
        return;
    }

    $stageUC = strtoupper($stage);

    $filePath = 'htaccess.txt';
    // check if .htaccess exists
    if (!file_exists($filePath)) {
        writeln('.htaccess file not found');
        return;
    }

    // read file into array
    $htaccessContent = explode(PHP_EOL, file_get_contents($filePath));

    if (count($htaccessContent) > 0) {
        //iterate over each line
        foreach ($htaccessContent as $key => $line) {
            // check if the markup syntax is present in the line
            $match = preg_match_all('/#\[(.*)\]#/', $line);

            if ($match > 0) {
                $startPos = strpos($line, '#[');
                $endPos = strpos($line, ']#');
                // get the possible stages
                $stagesFromLine = substr($line, $startPos, $endPos);

                if (str_contains($stagesFromLine, $stageUC)) {
                    // if so, remove the comment
                    $htaccessContent[$key] = substr($line, 0, $startPos) . substr($line, $endPos + 2, strlen($line));
                } else {
                    // else, remove the line
                    unset($htaccessContent[$key]);
                }
            }
        }
    }

    $processedContent = implode(PHP_EOL, $htaccessContent);
    run('touch {{release_path}}/public/.htaccess');
    run('echo "' . base64_encode($processedContent) . '" | base64 --decode > {{release_path}}/public/.htaccess');

    writeln('Processing .htaccess for ' . $stageUC . ' done!');
});
