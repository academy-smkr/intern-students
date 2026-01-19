<?php

class student {
    public $name;
    public $rno;
    public $marks;

    function __construct($n,$r,$m){
        $this->name = $n;
        $this->rno = $r;
        $this->marks = $m;
    }

    function display() {
        echo "Name : " . $this->name . "<br>";
        echo "Roll number : " . $this->rno . "<br>";
        echo "Marks : " . $this->marks . "<br>";
    }
}

$s1 = new student("suraj",23,98);
$s1->display();

?>
