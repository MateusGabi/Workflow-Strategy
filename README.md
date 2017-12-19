# Worflow Strategy

*Using workflows to dev your apps*

Hello bro 🖖,

Workflow Strategy (WS) is not a framework, it's an methodology. WS has three classes: [Strategy](https://github.com/MateusGabi/Workflow-Strategy/blob/master/src/Strategies/Strategy.php), [Workflow](https://github.com/MateusGabi/Workflow-Strategy/blob/master/src/Workflows/Workflow.php) and [WorkflowArtifact](https://github.com/MateusGabi/Workflow-Strategy/blob/master/src/Model/WorkflowArtifact.php). Of Course you can copy-and-paste our files.

This classes are generics and you shall create concret-class that inherit WS Classes (See examples).

## Simple Example

A workflow encapsulates an object of interest. For example, if you have a sales process (SalesWorkflow), you have a single object of type Sale that will be manipulated. Sale class must extends WorkflowArtifact.

```
class SalesWorkflow extends Workflow {

    // array of user roles 
    protected $places = (...);

    // see examples
    protected $transitions = (...);
	
	
    function authorize($action) : boolean {		
	return true;				
    } 

    // handlers methods..

}
```

```
class Sale extends WorkflowArtifact {

    protected $foo;
    protected $bar;

     public function __construct($foo, $bar) {

        //!important
        parent::__construct();

        $this->foo = $foo;
        $this->bar = $bar;
    }

}
```

In order to keep the business rules encapsulated in a single object, there is Strategy object. Strategy represents a solution to a particular problem. This solution is a workflow and an artifact.

```
class SaleStrategy extends Strategy {
		
	protected $workflow;
	
	function __construct() {		
		$this->workflow = new SalesWorflow();		
	}
	
	public function foo($bar) {		
		
            $sale = new Sale($bar);
        
            $this->workflow->setArtifact($sale);

            // goes ahead (next status)
            $this->workflow->next();

            // goes back (previous status)
            $this->workflow->previous();

            // force ending (end status)
            $this->workflow->finish();
				
    }
		
}
```

Artifacts change state as the process progresses, for this, we have handlers methods. When an WorkflowArtifact change status, an handler ixecuted.

```
class SaleWorkflow extends Workflow {

    //...

    protected $transitions = [
        'old_status' => [
            'from' => 'a',
            'to' => 'b'
        ],
        'new_status' => [
            'from' => 'b',
            'to' => 'c'
        ]
    ];

    function onChangeFromOldStatusToNewStatus() {
        //...
    }

}
```

## License
MIT
