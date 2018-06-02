<?php
namespace Deployer;

require 'recipe/symfony4.php';

// Project name
set('application', 'pdfmerge.aarhof.eu');

// Project repository
set('repository', 'git@github.com:lsv/pdf_merger.git');

set('git_tty', true);

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);


host('pdfmerge.aarhof.eu')
    ->user('root')
    ->set('deploy_path', '/ext/{{application}}')
    ->set('writable_mode', 'chmod')
;
    
// Tasks
after('deploy:failed', 'deploy:unlock');