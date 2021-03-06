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
            $statement = $model_obj->getCompanyRecord1($userid);
            $count = $statement->rowCount();
            if ($count > 0){
                while($row=$statement->fetch(PDO::FETCH_NUM)){
                    $city = $model_obj->getCity($row[2]);
                    ?>
                    <h2><?php echo $row[1] ?></h2>
                    
                    <img class='description-img' id='description-company-img' src="<?php echo $row[7]?>" alt='company logo'/>
                    <dl class='decription' id='description-company'>
                        <dt>City:</dt>
                        <dd><?php echo $city ?></dd>
                        <dt>Email:</dt>
                        <dd><a href='mailto:<?php echo $row[3] ?>'><?php echo $row[3] ?></a></dd>
                        <dt>Tel:</dt>
                        <dd><a href='tel:+<?php echo $row[4] ?>'><?php echo $row[4] ?></a></dd>
                        <dt>Open Posisition:</dt>
                        <dd><?php echo $row[5] ?></dd>
                        <dt>Posisition Details:</dt>
                        <dd><?php echo $row[6] ?></dd>
                    </dl>
        <?php }}} ?>
        <?php if ($_SESSION['userid'] == $_GET['id'] && $_SESSION['usertype'] == "company"){ ?>
        <p class="back-edit-link">
            <a  href="companies.php" >Back to Company List</a> <span>|</span> <a href="add-company.php?is_edit=0&id=<?php echo $_GET['id'] ?>">Edit</a>
        </p>
        <?php } else { ?>
        <p class="back-edit-link">
            <a href="companies.php" >Back to Company List</a>
        </p>
        <?php } ?>      
    <aside class="company_aside">
        <h2>Similar Students</h2>
        <p>
            Another companies in same location looking for students...
        </p>
    </aside>
</main>
<?php include "parts/_footer.php" ?>

