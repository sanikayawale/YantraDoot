<?php
// Start the session (not necessary if already started in login page)
session_start();

// Include the database connection file
include 'dbconnect.php';
// Check if the user is logged in
// if (!isset($_SESSION['user_id'])) {
//     // User is not logged in, alert the message and exit
//     echo "<script>alert('User is not logged in. Please log in first.');</script>";
//     exit;
// }
// Check if the user is logged in (i.e., if agency_id session variable is set)
if (isset($_SESSION['agency_id'])) {
    // Retrieve agency_id from the session
    $agencyId = $_SESSION['agency_id'];
} else {
    // User is not logged in, redirect them to the home page or login page
    header('Location: Agency_login.php'); // Change the redirect URL if needed
    exit;
}
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $modelBrand = $_POST['modelBrand'];
    $modelYear = $_POST['modelyear'];
   
    $rentalCost = $_POST['rentalCost'];
    $description = $_POST['description'];
    $category = $_POST['category']; // Retrieve the selected category
    $count = $_POST['count'];


   // Check for duplicate entries
   $checkQuery = "SELECT * FROM products WHERE model_brand = '$modelBrand' AND model_year = '$modelYear' AND agency_id = '$agencyId'";
  $result = mysqli_query($conn, $checkQuery);

  if (mysqli_num_rows($result) > 0) {
    // Duplicate entry found
    echo "<script>alert('This product has already been uploaded.');</script>";
    exit;
  }
    // Retrieve the uploaded image file
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        // Read the image file into binary data
        $imageData = file_get_contents($_FILES['image']['tmp_name']);

         // Construct the query to insert data into the products table, including the category
        $query = "INSERT INTO products (agency_id, model_brand, model_year, count, rental_cost, description, image, category)
        VALUES ('$agencyId', '$modelBrand', '$modelYear','$count', '$rentalCost', '$description', '" . addslashes($imageData) . "', '$category')";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            echo "<script>
            alert('Product added successfully!');
            setTimeout(function() {
                window.location.href = 'agency_portal.php';
            }, 2000);
        </script>";
        } else {
            echo "<script>
        alert('Failed to add product: " . mysqli_error($conn) . "');
        setTimeout(function() {
            window.location.href = 'agency_portal.php';
        }, 2000);
    </script>";
        }
    } else {
        echo "Failed to upload image: " . $_FILES['image']['error'];
    }
}

// Close the database connection
//   mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <link href="add_product.css" rel="stylesheet"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Portal</title>
    <style>
         @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    body{
        font-family: 'Poppins';
    }
        body {
            /* font-family: Arial, sans-serif; */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            /* height: 100vh; */
        /* background-color: white; */
        background:linear-gradient(270deg, whitesmoke, lightgreen);

        }

        .box {
            width: 100%;
            padding: 2px;
            /* width: 90%; */
            /* padding: 20px; */
            /* height: auto; */
           
            /* border: 1px solid #d71313; */
            border-radius: 5px;
            /* background-color:  rgb(241, 235, 235); */
            background-color: white;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .left{
            height: 50px;
            margin-left: 20px;
        }

        .portal-title {
            font-size: 24px;
            font-weight: bold;
            /* margin-bottom: 20px; */
        }

        .horizontal-bar {
            margin-top: 5px;
            /* margin-bottom: 20px; */
            /* padding: 10px 0; */
            display: flex;
            height: 40px;
           padding: 3px;
            justify-content: center;
            align-items: center;
            background-color: white;
            /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */

;
            /* border-top: 1px solid #ccc; */
        }

        
        .horizontal-bar a {
         display: block; /* Make each link take up the full width and height of its container */
         padding: 0 20px; /* Add padding for better visibility */
         text-decoration: none;
         color: green;
         font-size: 20px;
         /* font-weight: bold; */
         
            text-align: center;       
         /* Ensures the link spans the full height of the container  */
}

          /* Hover effect for links in the horizontal bar */
         /* .horizontal-bar a:hover {
          background-color: #0056b3; 
         color: #fff; 
          border-radius: 5px;
         } */
          /* Hover effect for links in the horizontal bar */
          .horizontal-bar a:hover {
          background-color: green; 
         color: #fff; 
          border-radius: 3px;
          /* text-transform: capitalize; */
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100%; /* Make the link take up the full height of its container */
         }

         .horizontal-bar a:hover:before {
          /* content: ""; */
          display: block;
          width: 100%;
          height: 100%;
         }
        
         .main{
            /* border: solid black 1px; */
            height:auto;
            width: 85%;
            justify-content: center;
            align-items: center;
            display: flex;
            flex-direction: column;
         }
         /* #addproduct {
            display: none;
        } */
        p{
    margin-top: 30px;
    /* border: solid black 1px; */
    /* width: 30%; */
    /* height: 35px; */
    /* justify-content: center;
    align-items: center; */
    font-size: 30px;
    text-align: center;
    font-weight: bold;
    /* display: flex; */
    border-radius: 5px;
    /* background-color: rgb(240, 245, 245); */
    position: relative; /* Ensure z-index works */
    /* z-index: 1;  */
    /* Ensure the container appears above the overlay */
  }
    .container{
        position: relative; /* Ensure z-index works */
       z-index: 1; /* Ensure the container appears above the overlay */
        /* border: solid black 1px; */
        width: 700px;
        padding: 50px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
       display: flex;
       flex-direction: column;
       align-items: center;
       justify-content: center;
       border-radius: 10px;
       /* background-color: rgb(241, 235, 235); */
       background-color: white;
       
       /* margin-top: 120px; */
    }
    label{
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }
    .div1, .div2, .div3,.div5{
        /* margin-left: 50px; */
        display: flex;
        gap: 80px;
        /* justify-content: space-between; */
        margin-bottom: 20px;

    }
    .div4{
        /* margin-left: 50px; */
        margin-bottom: 15px;
    }
    
    .subdiv1, .subdiv2{
        /* display: flex; */
        align-items: center;
    }
    input[type="text"],input[type="date"],input[type="number"]{
        height: 30px;
        width: 250px;
        /* border-radius: 5px; */
        /* border: 1px rgb(113, 110, 110) solid; */
        border: none;
        border-bottom: 2px solid green;
        font-size: 15px;
    }
    textarea{
        width: 500px;
        /* border-radius: 5px; */
        font-size: 15px;
        padding: 5px 5px;
        border: none;
        border-bottom: 2px solid green;
    }
    input[type="file"]{
       font-size: 15px;
    }

    select{
        height:30px;
        width: 170px;
        /* border-radius:5px; */
        border: none;
        border-bottom: 2px solid green;
    }
    input[type="submit"]{
        width: 25%;
        height: 35px;
      
       margin:auto;
       color: white;
        font-size: 18px;
        border: none;
       border-radius: 5px;
        background-color:green;
        cursor: pointer;
        justify-content: center;
    align-items: center;
    display: flex;
    }   
    
    input[type="submit"]:hover{
        background-color: rgb(2, 101, 2);
        box-shadow: 0 10px 15px rgba(0, 0, 0, .3);
    }
    .check{
        margin-bottom:20px;
        /* margin-left: 22px;         */
    }
    input[type="checkbox"]{
        width: 20px;
    }
    
    </style>
</head>

<body>
    <div class="box" style="display: flex; gap: 100px;">
        <div class="left" style="display: flex; gap: 10px;">
            <img style="width: 80px; height: 60px;" src="home-images/Yantadoot.png" alt="logo">
        <div style="margin-top: 5px;" class="portal-title">Agency Portal</div>
    </div>
       
        <!-- Add more content here, such as welcome message, forms, or other information -->

        <!-- Horizontal bar with links -->
        <div class="horizontal-bar">
            <a href="agency_portal.php" id="addProductLink">Add Product</a>
            <a href="agency_products_copy.php" id="yourProductsLink">Your Products</a>
            <a href="agency_booked_copy.php" id="bookedProductsLink">Booked Products</a>
            <a href="agency_history.php">History</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
   
    <div class="main" id="mainSection">
        <div id="addproduct">
          <p>Add Product</p>
        <div class="container">
        <!-- <h2>Add Product</h2> -->
         <form  method="POST" enctype="multipart/form-data" >
        <div class="div1">
            <div class="subdiv1">
        <label for="modelBrand">Model Brand:</label>
        <input type="text" id="modelBrand" name="modelBrand" placeholder="Enter Brand" required>
          </div>
          <div class="subdiv2">
        <label>Model Year:</label>
        <input type="text" id="modelyear" name="modelyear" placeholder="Enter Year"  required>
        </div>
      </div>

      <div class="div5" style="gap:50px">
        <div class="subdiv1">
           <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required>
        </div>
        <div class="subdiv2">
        <label for="category">Select a category:</label>
        <select id="category" name="category" required>
            <option value="">--Choose a category--</option>
            <option value="Tractors">Tractors</option>
            <option value="Sprayer">Sprayer</option>
            <option value="Brush Cutters">Brush Cutters</option>
            <option value="Cultivaters">Cultivaters</option>
            <option value="Harvesters">Harvesters</option>
            <option value="Pipe & Spinklers">Pipe and Spinklers</option>
            <option value="Tillers">Tillers</option>
            <option value="Weeders">weeders</option>
            <option value="Planting-euipment">Planting-euipment</option>
        </select>
        </div>
      </div>

      <!-- <div class="div2">
        <div class="subdiv1">
      <label for="startDate">Starting Rental Date:</label>
      <input type="date" id="startDate" name="startDate" required>
     
    </div>
    <div class="subdiv2">
      <label for="endDate">Ending Date:</label>
      <input type="date" id="endDate" name="endDate" required>
    </div>
    </div> -->

       <div class="div3">
        <div class="subdiv1">
         <label for="count">No. of Products</label>
         <input type="number" id="count" name="count" placeholder="Enter Quantity" required>
      </div>
      <div class="subdiv2">
        <label for="rentalCost">Rental Cost/day:</label>
        <input type="number" id="rentalCost" name="rentalCost" placeholder="Enter Cost/Day" required>
      </div>
       </div>

      <div class="div4">
       <label for="description">Description:</label>
        <textarea id="description" name="description" rows="3" placeholder="Engine type, any problem in machine,etc" required></textarea>
       </div>
    
    
       
       <div class="check">
       <label class="check">
        <input type="checkbox" id="terms" name="terms" required>
        I accept the terms and conditions
       </label>
    </div>
    

       <input type="submit" value="Add Product">

         </form>

       </div>   
       </div>
    </div>


   
    <!-- <script>
        // JavaScript to control the visibility of the "addproduct" div
        document.getElementById('addProductLink').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default link action
            document.getElementById('addproduct').style.display = 'block';
        });
    </script> -->

<!-- <script>
    document.getElementById('yourProductsLink').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default link action
        // Make an AJAX request to fetch your_products.php
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'agency_products.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Update the main section with the response
                document.getElementById('mainSection').innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    });
</script> -->

  <!-- <script>
    // JavaScript to load booked products content
    document.getElementById('bookedProductsLink').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default link action
            var xhr = new XMLHttpRequest();
        xhr.open('GET', 'agency_booked.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Update the main section with the response
                document.getElementById('mainSection').innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    });
  </script> -->
  
</body>

</html>
