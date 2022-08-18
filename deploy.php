<?php

namespace Deployer;

require 'recipe/symfony.php';

// Config

set('repository', 'git@github.com:yivi/bgg-personal-library.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('ludoteca-portal-ludico.yivoff.com')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '/var/www/ludoteca-portal-ludico');

// Hooks

after('deploy:failed', 'deploy:unlock');
