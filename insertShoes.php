<html>
  <head>
    <style>
      body {font-family: Arial, Helvetica, sans-serif;}
    
      form.a {padding-top: 16px; padding-right: 16px; padding-left: 16px; margin: 0}
      form.b {padding-right: 16px; padding-left: 16px; margin: 0}
      .topnav {
        background-color: #333;
        overflow: hidden;
      }
      .center {
        display: block;
        margin-left: auto;
        margin-right: auto;
      }
      input[type=text], [type=file], input[type=password] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
      }

      button.a {
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
      }
      button.b {
        background-color: blue;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
      }
      button.c {
        background-color: red;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
      }

      button:hover {
        opacity: 0.8;
      }

      .cancelbtn {
        width: auto;
        padding: 10px 18px;
        background-color: #f44336;
      }


      .container {
        padding: 16px;
        border: 3px solid #f1f1f1; width: 40%; margin: auto;
      }

      span.psw {
        float: right;
        padding-top: 16px;
      }
    </style>

  </head>
  <body>
   

    <div class="container">

    
      <form class="a" action="" method = "post" id="insert_shoes">
         <input type="hidden" name="act" value="insert_shoes">

         <label for="name"><b>Product Name</b></label>
         <input type="text" placeholder="Enter productName "  name="name" required>
        
         
         </br></br>
        
         </br></br>
      
         <label for="description"><b>Descirption</b></label>
         <input type="text" placeholder="Enter the product Description"  name="description" required>

         <label for="size"><b>Size</b></label>
         <input type="text" placeholder="Enter size"  name="size" required>

         <label for="gender"><b>Gender</b></label>
         <input type="text" placeholder="Enter gender"  name="gender" required>

          <label for="maker"><b>Maker</b></label> 
         <input type="text" placeholder="Enter maker"  name="maker" required>

         <label for="brand"><b>Brand</b></label>
         <input type="text" placeholder="Enter brand"  name="brand" required>

         <label for="model"><b>Model</b></label>
         <input type="text" placeholder="Enter brand"  name="model" required>
 













         <label for="price"><b>Price</b></label>
         <input type="text" placeholder="Enter price"  name="price" required>

         <label for="quantity"><b>Quantity</b></label>
         <input type="text" placeholder="Enter the quantity of your products"  name="quantity" required>
       
        <label for="prDisc"><b>percentage Discount</b></label>
        <input type="text" placeholder="Enter the discount that you want to give" name="prDisc" required>
      
        <label for="numPrDisc"><b>number of Products for Discount</b></label>
        <input type="text" placeholder="Enter Product Discount" name="numPrDisc" required>
        
       
         <button class="a" type="submit" value="insert_shoes">Submit</button>
      
       </form>
       <form class="b" action="home_seller.php" method = "" id="cancel">
           <button class="c" type="submit" value="register">cancel</button>
        </form>
    </div>

    <?php

      require_once "render.php";
      require_once "pdo.php";
      session_start();
      // echo "HERE ============IS SID PASSED TO Insert_shoes shoes";
      // echo $_SESSION['login_sid'];
      
      $description = $category = $price = $quantity = $image = $name =  $percentageDiscount =   $numProductsForDiscount= "" ;
      // echo $_POST['sid'];
      if($_SERVER['REQUEST_METHOD'] == "POST") {
        if(isset($_POST['act'])&& $_POST['act'] == 'insert_shoes'){

          $name = $_POST['name'];
            
          $sql = "SELECT COUNT(*) FROM Products";
          $stmt = $conn->prepare($sql);
          $stmt->execute();
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          // print_r($row);
          $count = $row["COUNT(*)"];
          // echo $count;
          // echo "fetched the product shoes";


          $pid  = $count + 1; 
          $price =$_POST['price'];   
          $description = $_POST['description'];    
          $image ="No image";         
          $name = $_POST['name']; 
          $percentageDiscount = $_POST['prDisc'];      
          $numProductsForDiscount= $_POST['numPrDisc'];       
          $category = "shoes";        
          $sid = $_SESSION['login_sid'];
          $quantity = $_POST['quantity'];
         
      
          $sql = "INSERT INTO Products (pid, price, description, image, name, percentageDiscount, numProductsForDiscount) VALUES (:pid, :price, :description, :image, :name, :percentageDiscount, :numProductsForDiscount)";
          $stmt = $conn->prepare($sql);
          
          $stmt->execute(array(
              ":pid"                    => $pid,                   
              ":price"                  => $price,                 
              ":description"            => $description,           
              ":image"                  => $image,                 
              ":name"                   => $name ,                 
              ":percentageDiscount"     => $percentageDiscount,
              ":numProductsForDiscount" => $numProductsForDiscount
          ));

        
          $sql = "INSERT INTO HasProd (pid, sid, quantity) VALUES (:pid, :sid, :quantity)";
          
          $stmt = $conn->prepare($sql);
         
  
          $stmt->execute(array(
              ":pid"         => $pid,                   
              ":sid"         => $sid,                 
              ":quantity"    => $quantity
          ));
          

          if($category == "shoes"){

            $size   = $_POST['size'];  
            $gender = $_POST['gender']; 
            $maker  = $_POST['maker']; 
            $brand   = $_POST['brand']; 
            $model   = $_POST['model']; 

           
            $sql = "INSERT INTO Shoes (pid, size, gender, model, brand) VALUES (:pid, :size, :gender, :model, :brand)";
           
            $stmt = $conn->prepare($sql);
            $stmt->execute(array(
                ":pid"   => $pid,                   
                ":size"  => $size, 
                ":gender"=> $gender, 
                ":model" => $model, 
                ":brand" => $brand  
            ));
           
            echo "<script type='text/javascript'>alert('PRODUCT INSERTED');</script>";
           
            echo "<script>window.location.href='./home_seller.php';</script>";
            exit;
          }
       }
      }  
    ?>

  </body>

  
</html>
