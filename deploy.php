<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@github.com:mowangjuanzi/laravel-skeleton.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

set('http_user', 'ubuntu');
set('http_group', 'ubuntu');
set('writable_mode', 'skip');

// Hosts

host('skeleton.baoguoxiao.com')
    ->set('ssh_multiplexing', false)
    ->set('remote_user', 'ubuntu')
    ->set('identity_file', '~/.ssh/id_rsa')
    ->set('deploy_path', '~/laravel-skeleton');

// Hooks

after('deploy:failed', 'deploy:unlock');
