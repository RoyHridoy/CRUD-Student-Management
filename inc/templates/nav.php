<?php
//session_name('crudStudentManagement');
session_start();
?>

<div class="header-area">
    <div class="container">
        <div class="row">
            <div class="col-3">
                <div class="logo">
                    <a href="index.php">CURD <span> SM </span></a>
                </div>
            </div>
            <div class="col-9">
                <div class="mainmenu">
                    <ul>
                        <li><a href="index.php?task=report">All students</a></li>
                        <li><a href="index.php?task=add">Add new student</a></li>
                        <li><a href="index.php?task=seed">Seed</a></li>
                        <?php if (isset($_SESSION['loggedIn'])) : ?>
                            <li><a href="index.php"><?php echo $_SESSION['user']; ?></a></li>
                            <li><a href="auth.php?logout=true">logout</a></li>
                        <?php else: ?>
                        <li><a href="auth.php">login</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
