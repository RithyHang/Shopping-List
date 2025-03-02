<?php
    $title = "";
    $description = "";
    $amount = "";

    $titleError = "";
    $descriptionError = "";
    $amountError = "";

    $success = "";
    $errors = [];

    if(isset($_POST['btnSubmit'])){
        $title = $_POST['txtTitle'];
        $description = $_POST['txtDescription'];
        $amount = $_POST['txtAmount'];

        //check title validation
        if(empty($title)){
            $titleError = "Title is required!";
            $errors[] = $titleError;
        }
        else{
            if(strlen($title) < 2){
                $titleError = "Title must be at least 2 characters!";
                $errors[] = $titleError;
            }
            elseif(!preg_match("/^[a-zA-Z ]*$/", $title)){
                $titleError = "Only letters and white space allowed!";
                $errors[] = $titleError;
            }
        }

        //check description validation
        if(empty($description)){
            $descriptionError = "Description is required!";
            $errors[] = $descriptionError;
        }
        else{
            if(strlen($description)<10){
                $descriptionError = "Description must be at least 10 characters!";
                $errors[] = $descriptionError;
            }
            elseif(!preg_match("/^[a-zA-Z0-9 ]*$/", $description)){
                $descriptionError = "Only letters and white space allowed!";
                $errors[] = $descriptionError;
            }
        }


        //check amount validation
        if(empty($amount)){
            $amountError = "Amount is required!";
            $errors[] = $amountError;
        }
        else{
            if(!is_numeric($amount)){
                $amountError = "Amount must be a number!";
                $errors[] = $amountError;
            }
        }


        //connect to database
        if(count($errors) === 0){
            $db = new mysqli("localhost", "root", "", "db_shopping_list");
            if($db->connect_errno > 0){
                die(
                    "Error number:" . $db->connect_errno . "<br>" .
                    "Error message:" . $db->connect_error 
                );
            }


            $sql = "INSERT INTO lists(title, description, amount) VALUES(?,?,?)";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("ssi", $title, $description, $amount);

            if($stmt->execute()){
                $success = "Your list has been created successfully!";
                $title = "";
                $description = "";
                $amount = "";
            }
            $stmt = null;
            $db->close();
        }

    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>Create Lists</title>
</head>
<body class="bg-[url('./images/BG.jpg')] bg-cover flex flex-col items-center h-screen">
    <h1 class="justify-self-center text-4xl text-white font-bold mt-10">
        Shopping Lists
    </h1>
    <form action="" method="post" 
            class="w-lg space-y-4 border border-white justify-items-center text-teal-950 bg-white/10 rounded-lg mt-10">
        

        <!-- Success Message -->
        <?=
            $success == "" ? null : "<div class='success text-green-500 pt-5 text-xl'>$success</div>";
        ?>

        <!-- Title Field -->
        <div class="field flex flex-col w-md pt-5">
            <label for="txtTitle">Title:</label>
            <input type="text" name="txtTitle" id="txtTitle" 
                    class="border border-white outline-none rounded-md h-10 p-3">

            <div class="error text-red-600"><?= $titleError?></div>
        </div>


        <!-- Description Field -->
        <div class="field flex flex-col w-md">
            <label for="txtDescription">Description:</label>
            <input type="text" name="txtDescription" id="txtDescription" 
                    class="border border-white outline-none rounded-md h-10 p-3">

            <div class="error text-red-600"><?= $descriptionError?></div>
        </div>


        <!-- Amount Field -->
        <div class="field flex flex-col w-md">
            <label for="txtAmount">Amount:</label>
            <input type="text" name="txtAmount" id="txtAmount" 
                    class="border border-white outline-none rounded-md h-10 p-3">

            <div class="error text-red-600"><?= $amountError?></div>
        </div>


        <!-- Error Message -->
        <?php
            foreach ($errors as $error) {
                echo "<div class='error text-red-600 m-0'>$error</div>";
            }
        ?>


        <!-- Submit Button -->
         <div class="field flex space-x-14 justify-center p-5">
            <input type="submit" value="SUBMIT" name="btnSubmit" class="bg-white/80 w-30 p-2 rounded-md border border-white">
            <input type="reset" value="RESET" name="btnReset" class="bg-white/80 w-30 p-2 rounded-md border border-white">
         </div>
    </form>

    <div class="flex w-md py-2 mt-5 bg-white/80 justify-center rounded-lg drops-shadow-">
        <a href="read.php" class="text-teal-950">View Lists</a>
    </div>

    <div class="w-screen h-screen flex flex-col justify-end items-center text-white/70 mb-10">
        <p>Hang Rithy | Uy Sophea | Ol Mengeim | You Muniraksmey</p>
    </div>
</body>
</html>