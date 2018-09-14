<?php 
namespace App\Shell;

use Cake\Console\Shell;

class EmailShell extends Shell {

    public $uses = array('Users');

    public function main() {
        $this->out('Hello world.');
    }

    public function preflight() {
        $this->Users->query()
            ->where([
                'Users.role' => 'volunteer'
            ]);
        
    }
}