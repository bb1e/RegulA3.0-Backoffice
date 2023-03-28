<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@github.com:MarusDod/RegulA.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

set('ssh_multiplexing', true); // Speeds up deployments;
set('git_tty', true);

// Hosts

set('rsync_src', function () {
    return __DIR__ . "/projeto-backoffice"; // If your project isn't in the root, you'll need to change this.
});

add('rsync', [
    'exclude' => [
        '.git',
        '/.env',
        '/storage/',
        '/vendor/',
        '/node_modules/',
        '.github',
        'deploy.php',
    ],
]);


host('34.105.76.171')
    #->stage('prod')
    ->user('marosdody_gmail_com')
    ->multiplexing(true)
    ->forwardAgent(true)
    ->set('remote_user', 'marosdody_gmail_com')
    ->set('deploy_path', '/var/www/html');


// Tasks
task('deploy:secrets', function () {
    file_put_contents(__DIR__ . '/.env', getenv('DOT_ENV'));
});

task('build', function () {
    cd('{{release_path}}');
});

after('deploy:failed', 'deploy:unlock');

desc('Deploy the application');

task('deploy', [

    'deploy:info',

    'deploy:prepare',

    'deploy:lock',

    'deploy:release',

    'rsync', // Deploy code & built assets

    'deploy:secrets', // Deploy secrets

    'deploy:shared',

    'deploy:vendors',

    'artisan:view:cache',   // |

    'artisan:config:cache', // | Laravel specific steps

    'artisan:optimize',     // |

    'deploy:unlock',

    'cleanup',

]);

