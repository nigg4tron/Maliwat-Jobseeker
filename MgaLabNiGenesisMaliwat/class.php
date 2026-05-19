<?php

class student{
    public $damns;
    public function __construct($damns){
    foreach ($damns as $i => $damn){
    $this->damn=$damn;
    echo "object created for". " ".$this->damn. "<br>";
    }
    }
}
$c = new Student(["whsjdjadjad"]);
$c = new Student(["shit"]);













$c = new Student(["who?"]);
$c = new Student(["what?"]);




?>