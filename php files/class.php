<?php

class student {
    public $name;
    public $rno;
    public $marks;

    public function display() {
        echo "Student Name : " . $this->name . "<br>";
        echo "Student Roll number : " . $this->rno . "<br>";
        echo "Student Marks : " . $this->marks . "<br>";
    }
}

$s1 = new student();

$s1->name = "suraj";
$s1->rno = 23;
$s1->marks=98;

$s1->display();

?>