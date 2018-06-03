<?php
namespace Deployer;

require 'recipe/symfony4.php';

set('application', 'pdfmerger.aarhof.eu');
set('repository', 'git@github.com:lsv/pdf_merger.git');
set('git_tty', true);

host('pdfmerge.aarhof.eu')
    ->user('root')
    ->set('deploy_path', '/ext/{{application}}')
    ->set('writable_mode', 'chmod')
    ->set('writable_chmod_mode', '0777')
    ->set('writable_chmod_recursive', true)
;

after('success', 'deploy:writable');
after('deploy:failed', 'deploy:unlock');
