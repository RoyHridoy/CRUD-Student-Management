<?php
define( "DB_NAME" , "/opt/lampp/htdocs/CRUD-Student-Management/data/data.txt" );

    function seed(){
        
        $data = array(
            array(
                'id' => 1,
                'fname' => 'Rajib',
                'lname' => 'Ahmed',
                'class' => '8',
                'roll' => 15,
            ),
            array(
                'id' => 2,
                'fname' => 'Mihir',
                'lname' => 'Chowdhury',
                'class' => '8',
                'roll' => 13,
            ),
            array(
                'id' => 3,
                'fname' => 'Safa',
                'lname' => 'Kabir',
                'class' => '8',
                'roll' => 10,
            ),
            array(
                'id' => 4,
                'fname' => 'Khalil',
                'lname' => 'Ahmed',
                'class' => '8',
                'roll' => 9,
            ),
            array(
                'id' => 5,
                'fname' => 'Karim',
                'lname' => 'Khan',
                'class' => '8',
                'roll' => 5,
            )
        );

        $serializeData = serialize($data);
        if (is_writable(DB_NAME)) {
            file_put_contents(DB_NAME,$serializeData,LOCK_EX);
        }
    }

    function displayData(){
        $unserializedData = file_get_contents(DB_NAME);
        $data = unserialize($unserializedData);
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
                echo "<td> <a href='#'>Edit</a> | <a href='#'>Delete</a> </td>";
                echo "</tr>";
            }
            ?>
        </table>
<?php
    }
