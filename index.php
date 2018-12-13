<?php require_once "./inc/functions.php"; ?>

<?php

//
//if (false == $loggedIn){
//    header('location: login.php');
//}



$task = $_GET['task'] ?? 'report';
$error = $_GET['error'] ?? '0';
$fname = '';
$lname = '';
$roll = '';
$class = '';
if (isset($_POST['submit'])) {
    $fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING);
    $lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING);
    $roll = filter_input(INPUT_POST, 'roll', FILTER_SANITIZE_STRING);
    $class = filter_input(INPUT_POST, 'class', FILTER_SANITIZE_STRING);
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

    if ($id) {
        // Update the student
        if ($fname != '' && $lname != '' && $roll != '' && $class != '') {
            $result = updateStudent($fname,$lname,$roll,$class,$id);
            if ($result){
                header('location: index.php?task=report');
            } else {
                $error = 1;
            }
        }
    } else {
        // If not found id then create the student
        if ($fname != '' && $lname != '' && $roll != '' && $class != '') {
            $result = addNewStudent($fname, $lname, $roll, $class);
            if ($result) {
                header("location: index.php?task=report");
            } else {
                $error = 1;
            }
        }
    }
}

if ('delete' == $task){
    $id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_STRING);

    if ($id>0){
        deleteStudent($id);
        header('location: index.php?task=report');
    }

}

?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link rel="stylesheet" href="./inc/templates/style.css">

    <title>CRUD - Student Management</title>
</head>
<body>

<?php include_once "./inc/templates/nav.php"; ?>

<div class="container">
    <div class="row">
        <div class="col">
            <div class="contents">

                <?php if ('seed' == $task) {
                    seed();
                    echo "<h2 class='page-title'> Seed Data </h2>";
                    echo "<div class=\"row\"><div class=\"col-8 offset-2\"><div class=\"alert alert-success text-center\" role=\"alert\">Data Seeding is Successfully Completed!</div></div></div>";
                }

                if ('report' == $task) {
                    echo "<h2 class='page-title'> All students </h2>";
                    displayData();
                }
                ?>

                <?php
                if ('1' == $error) {
                    echo "<div class='alert alert-danger text-center'>Roll Number Dublicate</div>";
                }
                ?>

                <?php if ('add' == $task) : ?>
                    <?php echo "<h2 class='page-title'> Add new student </h2>"; ?>
                    <div class="row">
                        <div class="col-8 offset-2">
                            <form action="index.php?task=add" method="POST">
                                <div class="form-group">
                                    <label for="fname">First Name</label>
                                    <input type="text" name="fname" id="fname" class="form-control"
                                           value="<?php echo $fname; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="lname">Last Name</label>
                                    <input type="text" name="lname" id="lname" class="form-control"
                                           value="<?php echo $lname; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="class">Class</label>
                                    <input type="number" name="class" id="class" class="form-control"
                                           value="<?php echo $class; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="roll">Roll Number</label>
                                    <input type="number" name="roll" id="roll" class="form-control"
                                           value="<?php echo $roll; ?>">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" name="submit">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>


                <?php if ('edit' == $task) :
                    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
                    $student = getStudent($id);
                    if ($student) :
                        ?>
                        <?php echo "<h2 class='page-title'> Edit student </h2>"; ?>
                        <div class="row">
                            <div class="col-8 offset-2">
                                <form action="" method="POST">
                                    <input type="hidden" value="<?php echo $id; ?>" name="id">
                                    <div class="form-group">
                                        <label for="fname">First Name</label>
                                        <input type="text" name="fname" id="fname" class="form-control"
                                               value="<?php echo $student['fname']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="lname">Last Name</label>
                                        <input type="text" name="lname" id="lname" class="form-control"
                                               value="<?php echo $student['lname']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="class">Class</label>
                                        <input type="number" name="class" id="class" class="form-control"
                                               value="<?php echo $student['class']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="roll">Roll Number</label>
                                        <input type="number" name="roll" id="roll" class="form-control"
                                               value="<?php echo $student['roll']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary" name="submit">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php
                    endif;
                endif;
                ?>

            </div>
        </div>
    </div>
</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
<script type="text/javascript" src="assets/script.js"></script>
</body>
</html>