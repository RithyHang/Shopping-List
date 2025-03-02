<?php
$successMessage = "";
if(isset($_GET["success"])){
    $successMessage = "Student has been updated successfully.";
}
?>


<?php
    $id;

    $db = new mysqli("localhost", "root", "", "db_shopping_list");
    if($db->connect_errno > 0){
        die(
            "Error number:" . $db->connect_errno . "<br>" .
            "Error message:" . $db->connect_error 
        );
    }

    $sql = "SELECT id, title, description, amount FROM lists";
    $result = $db->query($sql);
    if($db->errno > 0){
        die(
            "Error number:" . $db->errno . "<br>" .
            "Error message:" . $db->error 
        );
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>Read Lists</title>
</head>
<body class="bg-[url('./images/BG.jpg')] bg-cover flex flex-col items-center h-screen">
    <!-- wrapper -->
    <div class="flex flex-col text-white">
        
        <div class="flex justify-between w-7xl pl-3 pr-15 py-5 bg-blue-800/60">
            <div class="text-white font-bold text-2xl font-bold">Shopping List</div>
            <div class="text-white px-10 py-1 border rounded-sm">
                <a href="create.php?">Add List</a>
            </div>
        </div>

        <?=
            $successMessage != "" ? "<div class='success'>$successMessage</div>" : null;
        ?>

        <?php
            echo "<div class = 'row w-7xl text-2xl font-bold bg-white/30 flex self-center px-3 py-5'>";
                echo "<div class = 'col-2 w-[20%]'> Title </div>";
                echo "<div class = 'col-3 w-[40%]'> Description </div>";
                echo "<div class = 'col-4 w-[20%]'> Amount </div>";
                echo "<div class = 'col-5 w-[10%] text-green-600'> Update </div>";
                echo "<div class = 'col-6 w-[10%] text-red-600  '> Delete </div>";
            echo "</div>";

            while($list = $result->fetch_assoc()):
                $id = $list["id"];
                echo "<div class = 'row flex w-7xl px-3 border-b-1'>";
                    echo "<div class = 'col-2 w-[20%] py-2 text-md font-bold'>" . $list["title"] . "</div>";
                    echo "<div class = 'col-3 w-[40%] py-2'>" . $list["description"] . "</div>";
                    echo "<div class = 'col-4 w-[20%] py-2'>" . $list["amount"] . "</div>";

                    echo "<div class = 'col-5 w-[10%] py-2 text-green-600 font-bold'><a href='update.php?id=$id'>Update</a></div>";
                    echo "<div class = 'col-6 w-[10%] py-2 text-red-600 font-bold'><a href='delete.php?id=$id'>Delete</a></div>";
                echo "</div>";
            endwhile;
        ?>
        
        
    </div>
</body>
</html>

<script>
    let success = document.getElementsByClassName("success");
    if( success != null ){
        success[0].style.opacity = 1;
        success[0].style.transition = "all ease-in-out 1s";
        setTimeout(
            function(){
                success[0].style.opacity = 0;
                setTimeout(
                    success[0].remove();
                ),
                1000
            },
            5000
        );
    }
</script>