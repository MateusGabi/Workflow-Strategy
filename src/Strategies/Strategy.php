<?php

namespace App\Strategies;

abstract class Strategy {

    protected $workflow;

    /**
     * Configura o artefato principal do projeto.
     */
    function setWorkflowArtifact($artifact) {
        $this->workflow->setArtifact($artifact);
    }

}