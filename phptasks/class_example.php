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

$s1->name = "Kaushiki";
$s1->rno = 6;
$s1->marks=98;

$s1->display();

?>