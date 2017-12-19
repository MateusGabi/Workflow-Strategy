<?php

namespace App\Workflows;

abstract class Workflow
{

    public static $STARTED_STATUS_VALUE = "STARTED";
    public static $ENDED_STATUS_VALUE = "FINISHED";

    /**
     * Cada workflow possui uma entidade que devemos registrar seu estado. Ex.: PurchaseWorkflow temos o compra,
     * EditalWorkflow temos edital
     * @var \Object artifact
     */
    protected $artifact;

    /**
     * Tipos de usuários no qual o artifact pode estar presente.
     * @var array places
     */
    protected $places = [];

    /**
     * Transições que o artifact tem. Exemplo:
     * <code>
     *  "transition_name" => [
     *      "from" => "previous_place",
     *      "to" => "next_place"
     * ]
     * </code>
     * @var array transitions
     */
    protected $transitions = [];

    /**
     * CRUD
     *
     * @var array
     */
    protected $actions = [
        'create',
        'read',
        'update',
        'delete'
    ];

    /**
     * Retorna array de estados
     */
    private function flushTransitions() : array {
        $temp = [];

        foreach ($this->transitions as $transition => $value) {
            array_push($temp, $transition);
        }

        return $temp;
    }

    /**
     * Dado um estado, retorna próximo estado
     */
    protected function getNext($string) : string {

        $transitions = $this->flushTransitions();

        if($string == null) return $transitions[0];
        if($string == Workflow::$ENDED_STATUS_VALUE) return Workflow::$ENDED_STATUS_VALUE;

        $length = sizeof($transitions);

        for ($i = 0; $i < $length; $i++) {
            if($transitions[$i] == $string) {
                if($i == $length - 1) {
                    return Workflow::$ENDED_STATUS_VALUE;
                }
                return $transitions[$i + 1];
            }
        }

        return $transitions[0];

    }

    /**
     * Dado um estado, retorna ao estado posterior.
     */
    protected function getPrevious($string) : string {

        $transitions = $this->flushTransitions();
        $length = sizeof($transitions);

        if($string == null) return Workflow::$STARTED_STATUS_VALUE;
        if($string == Workflow::$STARTED_STATUS_VALUE) return Workflow::$STARTED_STATUS_VALUE;
        if($string == Workflow::$ENDED_STATUS_VALUE) return $transitions[$length - 1];


        for ($i = -1; $i < $length - 1; $i++) {
            if($transitions[$i + 1] == $string) {
                if($i == -1) {
                    return Workflow::$STARTED_STATUS_VALUE;
                }
                return $transitions[$i];
            }
        }

        return $transitions[0];

    }

    /**
     * Função responsável por voltar o estado do $artifact
     */
    public function previous() {
        $oldStatus = $this->artifact->status;

        $newStatus = $this->getPrevious($oldStatus);

        $this->artifact->status = $newStatus;

        $this->notify($oldStatus, $newStatus, false);
    }

    /**
     * Função responsável por avançar o estado do $artifact
     */
    public function next() {

        $oldStatus = $this->artifact->status;

        $newStatus = $this->getNext($oldStatus);

        $this->artifact->status = $newStatus;

        $this->notify($oldStatus, $newStatus, true);
    }
    
    /**
     * Função Handler que é chamada sempre quando ocorre mudança no estado do Workflow.
     *
     * @param $oldStatus
     * @param $newStatus
     * @param bool $isNext
     * @return void
     */
    private function notify($oldStatus, $newStatus, $isNext = true) {

        
        $oldStatus = ucfirst(strtolower($oldStatus));
        $newStatus = ucfirst(strtolower($newStatus));
        $method = "onChangeFrom{$oldStatus}To{$newStatus}";

        if(method_exists($this, $method)) {
            $this->{$method}();
        }


        

        $text = $isNext ? "avancou" : "voltou";
        
        //.. envio de e-mail, início de outro workflow, etc..

        print("Alerta! Status mudou: ({$text}) {$oldStatus} => {$newStatus}. Novo Objeto: {$this->artifact->toJson()} \n");
        
    }

    /**
     * Configura o artefato principal do projeto.
     * 
     * @param WorkflowArtifact $artifact
     */
    public function setArtifact($artifact) {
        $this->artifact = $artifact;
    }

    public function getArtifact($id = null) {
        return $this->artifact;
    }

    /**
     * Função responsável por fazer um filtro por usuário. A função é o ponto de encontro em Workflow$places e
     * Workflow$actions.
     * @return boolean
     */
    abstract function authorize($action) : boolean;
}