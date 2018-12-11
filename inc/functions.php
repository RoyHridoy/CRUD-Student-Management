<?php
define("DB_NAME", "/opt/lampp/htdocs/CRUD-Student-Management/data/data.txt");

function seed(){

    $data = array(
        array(
            'id'    => 1,
            'fname' => 'Rajib',
            'lname' => 'Ahmed',
            'class' => '8',
            'roll'  => 15,
        ),
        array(
            'id'    => 2,
            'fname' => 'Mihir',
            'lname' => 'Chowdhury',
            'class' => '8',
            'roll'  => 13,
        ),
        array(
            'id'    => 3,
            'fname' => 'Safa',
            'lname' => 'Kabir',
            'class' => '8',
            'roll'  => 10,
        ),
        array(
            'id'    => 4,
            'fname' => 'Khalil',
            'lname' => 'Ahmed',
            'class' => '8',
            'roll'  => 9,
        ),
        array(
            'id'    => 5,
            'fname' => 'Karim',
            'lname' => 'Khan',
            'class' => '8',
            'roll'  => 5,
        )
    );

    $serializeData = serialize($data);
    if (is_writable(DB_NAME)) {
        file_put_contents(DB_NAME, $serializeData, LOCK_EX);
    }
}

function displayData(){
    $unserializedData = file_get_contents(DB_NAME);
    $data = unserialize($unserializedData);
    if (!empty($data)) :
        ?>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Class</th>
                <th>Roll</th>
                <th>Action</th>
            </tr>
            </thead>
            <?php

            foreach ($data as $singleData) {
                echo "<tr>";
                echo "<td>{$singleData['id']} </td>";
                echo "<td>{$singleData['fname']} {$singleData['lname']}</td>";
                echo "<td>{$singleData['class']}</td>";
                echo "<td>{$singleData['roll']}</td>";
                echo "<td> <a href='index.php?task=edit&id={$singleData['id']}'>Edit</a> | <a href='index.php?task=delete&id={$singleData['id']}'>Delete</a> </td>";
                echo "</tr>";
            }
            ?>
        </table>
    <?php
    else: echo "<div class=\"alert alert-warning\" role=\"alert\">There is no data available to see. Please insert some data.</div>";
    endif;
}

function addNewStudent($fname,$lname,$roll,$class){

    $data =    file_get_contents(DB_NAME);
    $students = unserialize($data);
    $found = false;
    foreach ($students as $student) {
        if ($student['roll'] == $roll && $student['class'] == $class){
            $found = true;
        }
    }

    if (!$found){
        $student = array(
            'id'    => count($students) +1,
            'fname' => $fname,
            'lname' => $lname,
            'roll'  => $roll,
            'class' => $class
        );
        array_push($students,$student);

        $serializeData = serialize($students);

        if (is_writable(DB_NAME)) {
            file_put_contents(DB_NAME, $serializeData, LOCK_EX);
        }
        return true;
    } else {
        return false;
    }

}


function getStudent($id){
    $unserializedData = file_get_contents(DB_NAME);
    $students = unserialize($unserializedData);

    foreach ($students as $student) {
        if ($student['id'] == $id){
            return $student;
        }
    }
    return false;
}


function updateStudent($fname,$lname,$roll,$class,$id){
    $unserializedData = file_get_contents(DB_NAME);
    $students = unserialize($unserializedData);

    $students[$id-1]['fname'] = $fname;
    $students[$id-1]['lname'] = $lname;
    $students[$id-1]['roll'] = $roll;
    $students[$id-1]['class'] = $class;

    $serializeData = serialize($students);

    if (is_writable(DB_NAME)) {
        file_put_contents(DB_NAME, $serializeData, LOCK_EX);
    }
}































