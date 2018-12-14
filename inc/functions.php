<?php
define("DB_NAME", "/opt/lampp/htdocs/CRUD-Student-Management/data/data.txt");
define("DB_USERNAME", "/opt/lampp/htdocs/CRUD-Student-Management/data/users.txt");

function seed() {

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

function displayData() {
    $unserializedData = file_get_contents(DB_NAME);
    $data             = unserialize($unserializedData);
    if (!empty($data)) :
        ?>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Class</th>
                <th>Roll</th>
                <?php if (isset($_SESSION['user']) && (isAdmin($_SESSION['user']) || isEditor($_SESSION['user']))) { ?>
                    <th>Action</th>
                <?php } ?>
            </tr>
            </thead>
            <?php

            foreach ($data as $singleData) {
                echo "<tr>";
                echo "<td>{$singleData['id']} </td>";
                echo "<td>{$singleData['fname']} {$singleData['lname']}</td>";
                echo "<td>{$singleData['class']}</td>";
                echo "<td>{$singleData['roll']}</td>";
                if (isset($_SESSION['user']) && (isAdmin($_SESSION['user']) || isEditor($_SESSION['user']))) {
                    echo "<td> <a href='index.php?task=edit&id={$singleData['id']}'>Edit</a> ";
                }
                if (isset($_SESSION['user']) && isAdmin($_SESSION['user'])) {
                    echo "| <a class='delete' href='index.php?task=delete&id={$singleData['id']}'>Delete</a> </td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
    <?php
    else: echo "<div class=\"alert alert-warning\" role=\"alert\">There is no data available to see. Please insert some data.</div>";
    endif;
}

function addNewStudent($fname, $lname, $roll, $class) {

    $data     = file_get_contents(DB_NAME);
    $students = unserialize($data);
    $found    = false;
    foreach ($students as $student) {
        if ($student['roll'] == $roll && $student['class'] == $class) {
            $found = true;
        }
    }

    // If student not found then add new student
    if (!$found) {
        $student = array(
            'id'    => getNewId($students),
            'fname' => $fname,
            'lname' => $lname,
            'roll'  => $roll,
            'class' => $class
        );
        array_push($students, $student);

        $serializeData = serialize($students);

        if (is_writable(DB_NAME)) {
            file_put_contents(DB_NAME, $serializeData, LOCK_EX);
        }
        return true;
    } else {
        return false;
    }

}


function getStudent($id) {
    $unserializedData = file_get_contents(DB_NAME);
    $students         = unserialize($unserializedData);

    foreach ($students as $student) {
        if ($student['id'] == $id) {
            return $student;
        }
    }
    return false;
}


function updateStudent($fname, $lname, $roll, $class, $id) {
    $unserializedData = file_get_contents(DB_NAME);
    $students         = unserialize($unserializedData);

    $found = false;
    foreach ($students as $student) {
        if ($student['roll'] == $roll && $student['class'] == $class && $student['id'] != $id) {
            $found = true;
        }
    }

    // If student not found in same id and class then update
    if (!$found) { // This means if not found / found == false

        $students[$id - 1]['fname'] = $fname;
        $students[$id - 1]['lname'] = $lname;
        $students[$id - 1]['roll']  = $roll;
        $students[$id - 1]['class'] = $class;

        $serializeData = serialize($students);

        if (is_writable(DB_NAME)) {
            file_put_contents(DB_NAME, $serializeData, LOCK_EX);
        }
        return true;
    }
    return false;
}

function deleteStudent($id) {
    $unserializeData = file_get_contents(DB_NAME);
    $students        = unserialize($unserializeData);

    unset($students[$id - 1]);

    $serializeData = serialize($students);
    file_put_contents(DB_NAME, $serializeData, LOCK_EX);
}

function getNewId($students) {

    $id = max(array_column($students, 'id'));

    return $id + 1;
}

function isAdmin($username) {
    $fp = fopen(DB_USERNAME, 'r');
    while ($data = fgetcsv($fp)) {
        if ($data[0] == $username && $data[2] == 'admin') {
            return true;
        }
    }
    return false;
}

function isEditor($username) {
    $fp = fopen(DB_USERNAME, 'r');
    while ($data = fgetcsv($fp)) {
        if ($data[0] == $username && $data[2] == 'editor') {
            return true;
        }
    }
    return false;
}























