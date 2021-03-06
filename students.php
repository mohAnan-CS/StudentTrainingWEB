<?php include "parts/_header.php" ?>
<?php include_once 'parts/_db.php'; ?>
<?php include_once 'model.php'; ?>
<main>
    <?php 
    if (!isset($_SESSION['userid'])){
        header("location:index.php");
    }
    ?>

        <?php
            $model_obj = new Model;
            $model_obj->updateLastHit($_SESSION['userid']);
            ?>
    <h2>Students List</h2>
    <form class="list-form"action="?" method="get">
        <div>
            <label>Student Study Major:</label>
            <input class="text-field-major" type="text" name="major"/>
            <label>City:</label>
            <select name="city">
                <option>Select City</option>
                <?php
                    $object_model = new Model;
                    $stm = $object_model->getCitys();
                    $count = $stm->rowCount();
                    if ($count > 0){
                        while($row=$stm->fetch(PDO::FETCH_NUM)){
                            echo "<option>$row[2]</option>";
                        }
                    }?>
            </select>
            <input class="btn-search" type="submit" value="Search" name="search"/>
        </div>
    </form>
    <table class="table-data">
        <thead>
            <tr>
                <th>Photo</th>
                <th>Name</th>
                <th>City</th>
                <th>University</th>
                <th>Major</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(!isset($_GET['search'])){
                $model_obj = new Model;
                $statement = $model_obj->getStudentsRecord();
                $count = $statement->rowCount();
                if ($count > 0){
                    while($row=$statement->fetch(PDO::FETCH_NUM)){
                        $city = $model_obj->getCity($row[2]); ?>            
                        <tr>
                            <td><img class='student-img' src='<?php echo $row[9]?>' alt='student photo'/></td>
                            <td><a class='link-table' href='student.php?id=<?php echo $row[10] ?>' alt='student link information'><?php echo $row[1] ?></a></td>        
                            <td><?php echo $city ?></td>
                            <td><?php echo $row[5] ?></td>
                            <td><?php echo $row[6] ?></td>
                        </tr>
            <?php } } }         
            else {
                $major = $_GET['major'] ;
                $city = $_GET['city'] ;
                $model_obj = new Model;
                $statement = $model_obj->searchStudents($major , $city);
                if ($statement != 0){
                    $count = $statement->rowCount();
                    if ($count > 0){
                        while($row=$statement->fetch(PDO::FETCH_NUM)){
                            $city = $model_obj->getCity($row[2]);?>
                            <tr>
                                <td><img class='student-img' src='<?php echo $row[9]?>' alt='student photo'/></td>
                                <td><a class='link-table' href='student.php?id=<?php echo $row[10] ?>' alt='student link information'><?php echo $row[1] ?></a></td>        
                                <td><?php echo $city ?></td>
                                <td><?php echo $row[5] ?></td>
                                <td><?php echo $row[6] ?></td>
                            </tr>
                    <?php } } else{ ?>
                            <tr>
                                <td><img class='student-img' src='images/not-found.png' alt='student photo'/></td>
                                <td>???</td>        
                                <td>???</td>
                                <td>???</td>
                                <td>???</td>
                            </tr>
                <?php } } else {echo "<h5>Please enter information</h5>" ;
                $model_obj = new Model;
                $statement = $model_obj->getStudentsRecord();
                $count = $statement->rowCount();
                if ($count > 0){
                    while($row=$statement->fetch(PDO::FETCH_NUM)){
                        $city = $model_obj->getCity($row[2]); ?>            
                        <tr>
                            <td><img class='student-img' src='<?php echo $row[9]?>' alt='student photo'/></td>
                            <td><a class='link-table' href='student.php?id=<?php echo $row[10] ?>' alt='student link information'><?php echo $row[1] ?></a></td>        
                            <td><?php echo $city ?></td>
                            <td><?php echo $row[5] ?></td>
                            <td><?php echo $row[6] ?></td>
                        </tr>
            <?php } } } }?>
        </tbody>
    </table>
    <!-- if statement to check if usertype equal student to access add link or not -->
    <?php 
        $userid = $_SESSION['userid'];
        $obj = new Model;
        $stm = $obj->getStudentRecord1($userid);
        $counter = $stm->rowCount();
        if ($counter == 1 && $_SESSION['usertype'] == 'student'){ 
    ?>
    <div class="add-link-div">
        <a class="add-student-link" href="add-student.php?is_edit=0&id=<?php echo $_SESSION['userid']?>" >Edit Student</a>
    </div>    
    <?php } else if ($counter == 0 && $_SESSION['usertype'] == 'student'){ //echo $counter?>
    <div class="add-link-div">
        <a class="add-student-link" href="add-student.php?is_edit=1&id=<?php echo $_SESSION['userid']?>" >Add Student</a>
    </div> 
    <?php } ?>
    <aside class="students_aside">
        <h2>Distinguished Students</h2>
        <p>
            Student Ali Ahmad from Birzeit is very special and he is looking for training in Computer Science...
        </p>
    </aside>
</main>
<?php include "parts/_footer.php" ?>

