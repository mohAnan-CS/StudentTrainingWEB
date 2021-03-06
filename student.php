<?php include "parts/_header.php" ?>
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

    <?php
        if(isset($_GET['id'])){
            $userid = $_GET['id'];
            $model_obj = new Model;
            $statement = $model_obj->getStudentRecord1($userid );
            $count = $statement->rowCount();
            if ($count > 0){
                while($row=$statement->fetch(PDO::FETCH_NUM)){
                    $city = $model_obj->getCity($row[2]);
                    ?>
                    <h2><?php echo $row[1] ?></h2>
                    <img class='description-img' id='description-student-img' src='<?php echo $row[9]?>' alt='student image'/>
                    <dl class='decription' id='description-student'>
                        <dt>City:</dt>
                        <dd><?php echo $city ?></dd>
                        <dt>Email:</dt>
                        <dd><a href='mailto:<?php echo $row[3] ?>'><?php echo $row[3] ?></a></dd>
                        <dt>Tel:</dt>
                        <dd><a href='tel:+<?php echo $row[4] ?>'><?php echo $row[4] ?></a></dd>
                        <dt>Major:</dt>
                        <dd><?php echo $row[6] ?></dd>
                        <dt>Projects:</dt>
                        <dd><?php echo $row[7] ?></dd>
                        <dt>Intrests:</dt>
                        <dd><?php echo $row[8]?></dd>
                    </dl>
        <?php }}} ?>
        <?php if ($_SESSION['userid'] == $_GET['id'] && $_SESSION['usertype'] == "student"){ ?>
        <p class="back-edit-link">
            <a  href="students.php" >Back to Students List</a> <span>|</span> <a href="add-student.php?is_edit=0&id=<?php echo $_GET['id'] ?>">Edit</a>
        </p>
        <h2>Training Offer</h2>
        <table class="table-data">
        <thead>
            <tr>
                <th>Company Name</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $obj = new Model ;
        $student_id = $obj->getStudentId($_GET['id']);
        
        $statement = $obj->getOffers($student_id);
        $count = $statement->rowCount();
                if ($count > 0){
                    while($row=$statement->fetch(PDO::FETCH_NUM)){
                        $city_name = $obj->getCompanyName($row[2]);
                ?>
            <form action = "" method="post">            
            <tr>
                <td><?php echo $city_name?></td>
                <td><?php echo $row[3] ?></td>
                <td><?php echo $row[4] ?></td>
                <td><a  href="process2.php?accept&studentid=<?php echo $row[1] ?>&companyid=<?php echo $row[2] ?>" >Accept</a> <span>|</span> <a href="process2.php?reject&studentid=<?php echo $row[1] ?>&companyid=<?php echo $row[2] ?>">Reject</a></td>
            </tr>
            </form>
            <?php }}?>
        </tbody>
    </table>
        <?php } else { if ($_SESSION['usertype'] == "company" && $_SESSION['companyid'] != 0 ){?>
            <?php 
                $obj = new Model ;
                $id = $obj->getStudentId($_GET['id']);
                $company_id = $obj->getCompanyId($_SESSION['userid']);
                $is_offered = $obj->isOffered($id , $company_id);
                $status = $obj->getStatus($id , $company_id);
                if($is_offered == 1){
                    echo "
                    <p class='back-edit-link'>
                        <a href='' >Offered ($status)</a> <span>|</span> <a href='students.php'>Back to Students List</a>
                    </p>
                ";
                }else{
                    echo "
                    <p class='back-edit-link'>
                        <a href='process2.php?offer&studentid=".$id."&companyid=".$company_id."&userid=".$_SESSION['userid']."' >Offer A Training</a> <span>|</span> <a href='students.php'>Back to Students List</a>
                    </p>
                ";
                }
                ?>
        <?php }else { ?>
        <p class="back-edit-link">
            <a  href="students.php" >Back to Students List</a>
        </p>
        <?php }} ?>      
    <aside class="student_aside">
        <h2>Similar Students</h2>
        <p>
            A student or 2 students with same major3
        </p>
    </aside>
</main>
<?php include "parts/_footer.php" ?>

