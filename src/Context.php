<?php 

namespace App;

use App\Strategies\AStrategy;
use App\Model\Foo;

class Context {

    protected $strategy;

    public function operation() {

        $artifact = new Foo("foo");

        $strategy = new AStrategy(); 
        $strategy->setWorkflowArtifact($artifact);
        $strategy->operation();
    }


}