<?php
include('connection.php');
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
}

if(isset($_POST["submit"])) {

      $size = $_POST['size'];
      $stock=$_POST['stock'];

      // Insert into database
      $sql = "INSERT INTO single_product (product_id, size_id, stock) VALUES ('$product_id','$size','$stock')";
      // Execute SQL query
      if(mysqli_query($conn, $sql)) {
       $_SESSION['status'] = "Size and stock added successfully!";
      } else {
       $_SESSION['status'] = "Size and stock addition failed!";
      }
   
  }

if(isset($_POST['update'])){

  $product_id=$_POST['update'];
  $stock=$_POST['stock'];
  $size=$_POST['size'];

  $current_stock=0;

  $sql="SELECT stock FROM single_product WHERE product_id='$product_id' AND size_id='$size'";
  $result=mysqli_fetch_array(mysqli_query($conn,$sql));
  $current_stock=$result['stock'];

  if($stock){
      $current_stock+=$stock;
  }

  $sql="UPDATE single_product SET stock='$current_stock' WHERE product_id='$product_id' AND size_id='$size'";
  mysqli_query($conn,$sql);
}
?>


<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Single Product</title>
    <link rel="stylesheet" href="adminstyle/css/tailwind.output.css" />
    <script
      src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
      defer
    ></script>
    <script src="adminstyle/js/init-alpine.js"></script>
    <script>
      if(window.history.replaceState){
        window.history.replaceState(null,null,window.location.href);
      }
    </script>
</head>
<body>
  <main class="h-full pb-16 overflow-y-auto">
    <?php 
      $sql1 = "SELECT * FROM product WHERE product_id=$product_id";
      $result1 = mysqli_query($conn, $sql1);
      $product = mysqli_fetch_array($result1);                            
    ?>
        
    <div class="flex items-center space-x-4">
        <!-- Image -->
        <img style="width:425px;height:425px;" class="img-responsive" src="./uploads/<?php echo $product['image']; ?>" />

        <!-- Text Content -->
        <div class="flex-1">
            <h2 class="font-bold" style="font-size: 30px;"><?php echo $product['name']; ?></h2>
            <h3 style="font-size: 30px;">₹ <?php echo $product['price']; ?></h3>
        </div>
    </div>
    <div class="container grid px-6 mx-auto">
  
      <!-- Table -->
      <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
        Stock Update
      </h4>

      <!-- Button trigger modal -->
        
      <div>
        <button
          @click="openModal"
          class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
        >
          Add Size
        </button>
      </div>

      <!-- End Button trigger modal -->


      <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr
                class="text-xs font-semibold tracking-wide text-left text-gray-1000 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
              >
                <th class="px-4 py-3">No.</th>
                <th class="px-4 py-3">Size</th>
                <th class="px-4 py-3">Stock</th>
                <th class="px-4 py-3"></th>
                <th class="px-4 py-3">Action</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
              <?php 
                $sql2 = "SELECT p.*, sp.*, s.size AS size
                FROM single_product sp
                INNER JOIN product p ON sp.product_id = p.product_id
                INNER JOIN size s  ON sp.size_id = s.size_id
                WHERE sp.product_id=$product_id";
                $result2 = mysqli_query($conn, $sql2); 
                $count = 0;

                while ($row = mysqli_fetch_array($result2)) {
                $count++;
              ?>  
              <tr class="text-gray-700 dark:text-gray-400">
                  <td><?php echo $count; ?></td>
                  <td><?php echo $row['size']; ?> </td>
                  <td><?php echo $row['stock']; ?> </td>

                  <div class="flex items-center space-x-4 text-sm">
                    <form method="POST" action="">
                      <td><input type="number" name="stock" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"></td>
                      <td class="px-4 py-3">
                      <input type="hidden" name="size" value="<?php echo $row['size_id']; ?>">
                      <input type="hidden" name="update" value="<?php echo $row['product_id']; ?>">
                      <button type="submit" name="id" value="Update"
                        class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                      >Update
                      </button>
                      </td>
                    </form>
                  </div>
                
            <?php } ?>
                
              </tr>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>



  <!-- Modal backdrop. This what you want to place close to the closing body tag -->
  <div
    x-show="isModalOpen"
    x-transition:enter="transition ease-out duration-150"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
  >
    <!-- Modal -->
    <div
      x-show="isModalOpen"
      x-transition:enter="transition ease-out duration-150"
      x-transition:enter-start="opacity-0 transform translate-y-1/2"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-150"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0  transform translate-y-1/2"
      @click.away="closeModal"
      @keydown.escape="closeModal"
      class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
      role="dialog"
      id="modal"
    >
      <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
      <header class="flex justify-end">
        <button
          class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700"
          aria-label="close"
          @click="closeModal"
        >
          <svg
            class="w-4 h-4"
            fill="currentColor"
            viewBox="0 0 20 20"
            role="img"
            aria-hidden="true"
          >
            <path
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd"
              fill-rule="evenodd"
            ></path>
          </svg>
        </button>
      </header>
      <!-- Modal body -->

        <!-- Modal title -->
        
      <!-- Modal description -->
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="mt-4 mb-6">
          <span class="text-gray-700 dark:text-gray-400">Size</span>
          <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" 
            id="size" name="size">
            <option value="" selected disabled>Select size</option> <!-- This will be the default option -->
            <?php
              $sql = "SELECT * FROM size s WHERE size_id NOT IN (SELECT sp.size_id FROM single_product sp WHERE sp.product_id = $product_id)";
              $result=mysqli_query($conn,$sql);
              if($result){
                  while($row=mysqli_fetch_array($result)) {
                      echo '<option value="'.$row['size_id'].'">'. $row['size'] . '</option>';
                  }
              } else {
                  // If query fails, display an error message
                  echo '<option>Error fetching categories: ' . mysqli_error($connection) . '</option>';
              }
            ?>
          </select>

          <span class="text-gray-700 dark:text-gray-400">Stock</span>
          <input type="text" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" 
          name="stock" placeholder="Stock"/>
        </div>

        <footer
        class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800"
        >
          <button
            @click="closeModal"
            class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray"
          >
            Cancel
          </button>
          <button
            type="submit" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
            name="submit"
          >
            Submit
          </button>
        </footer>

      </form>
    </div>
  </div>
  <!-- End of modal backdrop -->

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

</body>
</html>