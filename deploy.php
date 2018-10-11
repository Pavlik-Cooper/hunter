<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'hunter');

// Project repository
set('repository', 'git@github.com:Pavlik-Cooper/hunter.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);
set('allow_anonymous_stats', false);

// Hosts

host('pavlique.site')
    ->user('deployer')
    ->identityFile('~/.ssh/id_rsa')
    ->set('deploy_path', '/var/www/html/{{application}}');

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

