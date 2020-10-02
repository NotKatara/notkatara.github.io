<?php
namespace Deployer;

require 'recipe/common.php';

// Project name
set('application', 'trompcoding.com');

// Project repository
set('repository', 'git@github.com:NotKatara/notkatara.github.io.git');

// Shared files/dirs between deploys 
set('shared_files', []);
set('shared_dirs', []);

// Writable dirs by web server 
set('writable_dirs', []);

set('default_stage', 'staging');


// Hosts

host('trompcoding.com')
    ->stage('production')
    ->user('sokka')
    ->port(22)
    ->forwardAgent()
    ->set('deploy_path', '/home/sokka/{{application}}');
    
host('trompcoding.com')
    ->set('branch', 'develop')
    ->stage('staging')
    ->user('sokka')
    ->port(22)
    ->forwardAgent()
    ->set('deploy_path', '/home/sokka/staging_{{application}}');  
    

// Tasks

desc('Deploy to server');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');