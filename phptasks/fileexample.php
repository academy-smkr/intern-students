<?php

$file = fopen("student.txt","w"); //create a file or open in write mode
fwrite($file, "Student Name: Kaushiki \n");  //write the data inside the opened file
fwrite($file, "Course: PHP \n");
fwrite($file, "Marks: 90");
fclose($file); //to close the opened file
echo "File created and data written successfully. <br><br>";


$file = fopen("student.txt","r"); //to open the file in read mode
echo "Reading full file using fread() <br>";
echo fread($file, filesize("student.txt")). "<br><br>"; //to display and read the file
fclose($file);


$file = fopen("student.txt","r");
echo "Reading file line by line by fgets() <br>";
while(!feof($file)){   //feof() for checking if the pointer has reached the end of the line
    echo fgets($file) . "<br>";  //fgets() for reading file line by line
}
fclose($file);


$file = fopen("student.txt","r");
echo "<br>Reading file character by character using fgetc() <br>";
echo fgetc($file) . "<br>"; //fegetc() for reading file character by character we can use while loop with feof() if we need all the characters
fclose($file);


echo "<br>Displaying file using readfile() <br>";
readfile("student.txt");


// unlink("student.txt");   // this is for deleting the file you created 
?>