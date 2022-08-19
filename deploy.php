<?php

namespace Deployer;

require 'recipe/symfony.php';
require 'contrib/yarn.php';

// Config

set('repository', 'git@github.com:yivi/bgg-personal-library.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

task('deploy:frontend-build', function () {
    run("cd {{release_path}} && {{bin/yarn}} encore prod");
});

// Hosts
host('ludoteca-portal-ludico.yivoff.com')
    ->setRemoteUser('deployer')
    ->setDeployPath('/var/www/ludoteca-portal-ludico');

host('staging')
    ->setHostname('ludoteca-portal-ludico.yivoff.com')
    ->setRemoteUser('deployer')
    ->setDeployPath('/var/www/ludo-staging')
    ->set('branch', 'deploy-fixes')
;

// Hooks
after('deploy:failed', 'deploy:unlock');
after('deploy:vendors', 'yarn:install');
after('yarn:install', 'deploy:frontend-build');
