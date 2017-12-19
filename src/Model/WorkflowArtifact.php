<?php

namespace App\Model;

use App\Workflows\Workflow;

class WorkflowArtifact {

    public $status;

    public function __construct() {

        // o artifact pode estar sendo armazenado no banco, com outro estado
        // então, não pode simplesmente atribuir ao atributo status o valor
        // default do estado inicial.
        if(!isset($this->status)) {
            $this->status = Workflow::$STARTED_STATUS_VALUE;
        }

    }

    /**
     * Retorna o objeto corrente em formato Json String
     */
    public function toJson() {
        return json_encode( (array) $this );
    }

}