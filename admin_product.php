<?php

include('Connection.php');

if (isset($_POST["submit"])) {

  if (isset($_POST['name'])) {
    $productName = $_POST['name'];
    $category = $_POST['category'];
    $sports = $_POST['sports'];
    $brand = $_POST['brand'];
    $productImage = $_FILES['image']['name'];
    $productPrice = $_POST['price'];
    $gender = $_POST['gender'];
    $description = $_POST['description'];

    // Move uploaded file to desired location
    move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $productImage);
    // Insert into database
    $sql = "INSERT INTO product (name, image,price,gender_id,description,category_id,sports_id,brand_id) 
      VALUES ('$productName','$productImage','$productPrice','$gender','$description','$category','$sports','$brand')";
    // Execute SQL query
    if (mysqli_query($conn, $sql)) {
      $_SESSION['status'] = "Product added successfully!";
    } else {
      $_SESSION['status'] = "Product addition failed!";
    }
  } else {
    echo "Product value is not set or empty.";
  }
} elseif (isset($_POST["delete"])) {

  $product_id = $_POST['delete'];
  $sql = "DELETE FROM product WHERE product_id='$product_id'";
  if (mysqli_query($conn, $sql)) {
    $_SESSION['status'] = "Category deleted successfully!";
  } else {
    $_SESSION['status'] = "Category deletion failed!";
  }
} elseif (isset($_POST["update"])) {
  $productId = $_POST['update'];
  $product = $_POST['name'];
  $category = $_POST['category'];
  $price = $_POST['price'];
  $description = $_POST['description'];

  // Handle image upload if necessary
  if ($_FILES['image']['name']) {
    $Image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $Image);
    $sql = "UPDATE product SET name='$product', image='$Image', category_id='$category', price='$price', description='$description' WHERE product_id='$productId'";
  } else {
    $sql = "UPDATE product SET name='$product', category_id='$category', price='$price', description='$description' WHERE product_id='$productId'";
  }

  if (mysqli_query($conn, $sql)) {
    $_SESSION['status'] = "Product updated successfully!";
  } else {
    $_SESSION['status'] = "Product update failed!";
  }
}

?>

<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product</title>
  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
  <style>
    /* Ensure table cells wrap text correctly */
    .description {
      white-space: normal;
      word-break: break-word;
    }

    /* Set a maximum width for the description cell to control the text wrapping */
    .max-w-md {
      max-width: 28rem;
      /* Adjust the width as needed */
    }
  </style>
</head>

<body>


  <!--new Product Modal -->
  <!-- Modal backdrop. This what you want to place close to the closing body tag -->
  <div>
    <div
      x-show="isModalOpen"
      x-transition:enter="transition ease-out duration-150"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-150"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
      class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
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
        id="modal">
        <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
        <header class="flex justify-end">
          <button
            class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700"
            aria-label="close"
            @click="closeModal">
            <svg
              class="w-4 h-4"
              fill="currentColor"
              viewBox="0 0 20 20"
              role="img"
              aria-hidden="true">
              <path
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"
                fill-rule="evenodd"></path>
            </svg>
          </button>
        </header>
        <!-- Modal body -->

        <!-- Modal title -->

        <!-- Modal description -->
        <form action="" method="POST" enctype="multipart/form-data">
          <div class="mt-4 mb-6">

            <div class="mt-1 mb-1">
              <span class="text-gray-700 dark:text-gray-400">Name</span>
              <input type="text" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                name="name" placeholder="Name" />
            </div>

            <div class="mt-1 mb-1">
              <span class="text-gray-700 dark:text-gray-400">Image</span>
              <input type="file" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                name="image" placeholder="Choose file" />
            </div>

            <div class="flex space-x-4 mt-1 mb-1">
              <div class="flex-1">
                <span class="text-gray-700 dark:text-gray-400">Price</span>
                <input type="text" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  name="price" placeholder="Price" />
              </div>

              <div class="flex-1">
                <span class="text-gray-700 dark:text-gray-400">Gender</span>
                <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  id="gender" name="gender">
                  <option value="" selected disabled>Select gender</option> <!-- This will be the default option -->
                  <?php
                  $sql = "SELECT * FROM gender";
                  $result = mysqli_query($conn, $sql);

                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                      echo '<option value="' . $row['gender_id'] . '">' . $row['gender'] . '</option>';
                    }
                  } else {
                    // If query fails, display an error message
                    echo '<option>Error fetching categories: ' . mysqli_error($connection) . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>

            <div class="mt-1 mb-1">
              <span class="text-gray-700 dark:text-gray-400">Description</span>
              <textarea class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                name="description" placeholder="Description" rows="4" cols="50"></textarea>
            </div>

            <div class="mt-1 mb-1">
              <span class="text-gray-700 dark:text-gray-400">Category</span>
              <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                id="category" name="category">
                <option value="" selected disabled>Select category</option> <!-- This will be the default option -->
                <?php
                $sql = "SELECT * FROM category";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                  while ($row = mysqli_fetch_array($result)) {
                    echo '<option value="' . $row['category_id'] . '">' . $row['name'] . '</option>';
                  }
                } else {
                  // If query fails, display an error message
                  echo '<option>Error fetching categories: ' . mysqli_error($connection) . '</option>';
                }
                ?>
              </select>
            </div>

            <div class="mt-1 mb-1">
              <span class="text-gray-700 dark:text-gray-400">Sports</span>
              <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                id="sports" name="sports">
                <option value="" selected disabled>Select sports</option> <!-- This will be the default option -->
                <?php
                $sql = "SELECT * FROM sports";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                  while ($row = mysqli_fetch_array($result)) {
                    echo '<option value="' . $row['sports_id'] . '">' . $row['name'] . '</option>';
                  }
                } else {
                  // If query fails, display an error message
                  echo '<option>Error fetching categories: ' . mysqli_error($connection) . '</option>';
                }
                ?>
              </select>
            </div>

            <div class="mt-1 mb-1">
              <span class="text-gray-700 dark:text-gray-400">Brand</span>
              <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                id="brand" name="brand">
                <option value="" selected disabled>Select brand</option> <!-- This will be the default option -->
                <?php
                $sql = "SELECT * FROM brand";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                  while ($row = mysqli_fetch_array($result)) {
                    echo '<option value="' . $row['brand_id'] . '">' . $row['name'] . '</option>';
                  }
                } else {
                  // If query fails, display an error message
                  echo '<option>Error fetching categories: ' . mysqli_error($connection) . '</option>';
                }
                ?>
              </select>
            </div>

            <footer
              class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
              <button
                @click="closeModal"
                class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                Cancel
              </button>
              <button
                type="submit" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                name="submit">
                Submit
              </button>
            </footer>
          </div>
        </form>

      </div>
    </div>
  </div>
  <!-- End of modal backdrop -->


  <!-- endModal -->




  <main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-6 mx-auto">
      <h2
        class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Table: Product
      </h2>

      
      <!-- Button trigger modal -->


      <div>
        <button
          @click="openModal"
          class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
          New Product
        </button>
      </div>
      <!-- End Button trigger modal -->


      <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr
                class="text-xs font-semibold tracking-wide text-left text-gray-1000 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                <th class="px-4 py-3">No.</th>
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">Image</th>
                <th class="px-4 py-3">Price</th>
                <th class="px-4 py-3">Description</th>
                <th class="px-4 py-3">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
              <?php

              $sql = "SELECT * FROM product";
              $count = 0;
              $result = mysqli_query($conn, $sql);
              while ($row = mysqli_fetch_array($result)) {
                $count += 1;
              ?>
                <tr class="text-gray-700 dark:text-gray-400">
                  <td><?php echo $count; ?></td>
                  <td><?php echo $row['name']; ?> </td>
                  <td><img style="width:150px;height:150px;" class="img-responsive" src="./uploads/<?php echo $row['image']; ?>" /> </td>
                  <td><?php echo $row['price']; ?> </td>
                  <td class="px-4 py-3 max-w-md break-words whitespace-normal description">
                    <?php echo $row['description']; ?>
                  </td>

                  <td class="px-4 py-3">
                    <div class="flex items-center space-x-4 text-sm">
                      <button type="button"
                        class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                        onclick="fetchProductDetails(<?php echo $row['product_id']; ?>);" @click="openEditModal">
                        Edit
                      </button>

                      <form method="POST" action="">
                        <input type="hidden" name="delete" value="<?php echo $row['product_id']; ?>">
                        <button type="submit" name="ids" value="Delete"
                          class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Delete
                        </button>
                      </form>
                    </div>
                  </td>
                <?php } ?>

                </tr>

            </tbody>
          </table>
        </div>
      </div>
    </div>
    </div>
  </main>

  <!-- edit Product Modal -->
  <div>
    <div
      x-show="isEditModalOpen"
      x-transition:enter="transition ease-out duration-150"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-150"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
      class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
      <!-- Modal -->
      <div
        x-show="isEditModalOpen"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 transform translate-y-1/2"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0  transform translate-y-1/2"
        @click.away="closeEditModal"
        @keydown.escape="closeEditModal"
        class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
        role="dialog"
        id="editmodal">
        <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
        <header class="flex justify-end">
          <button
            class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700"
            aria-label="close"
            @click="closeEditModal">
            <svg
              class="w-4 h-4"
              fill="currentColor"
              viewBox="0 0 20 20"
              role="img"
              aria-hidden="true">
              <path
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"
                fill-rule="evenodd"></path>
            </svg>
          </button>
        </header>
        <!-- Modal body -->

        <!-- Modal title -->

        <!-- Modal description -->
        <form action="" method="POST" enctype="multipart/form-data">
          <div class="mt-4 mb-6">

            <div class="mt-1 mb-1">
              <span class="text-gray-700 dark:text-gray-400">Name</span>
              <input type="text" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                name="name" id="edit_productname" placeholder="Name" />
            </div>

            <div class="mt-1 mb-1">
              <label for="current_image" class="text-gray-700 dark:text-gray-400">Current Image</label><br>
              <img id="current_image" src="" alt="Current Image" style="width: 150px; height: 150px;" /><br>
              <label for="edit_image" class="text-gray-700 dark:text-gray-400">Upload New Image (optional)</label>
              <input type="file" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                name="image" id="edit_image">
            </div>

            <div class="flex space-x-4 mt-1 mb-1">
              <div class="flex-1">
                <span class="text-gray-700 dark:text-gray-400">Price</span>
                <input type="text" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  name="price" id="edit_price" placeholder="Price" />
              </div>

              <div class="flex-1">
                <span class="text-gray-700 dark:text-gray-400">Category</span>
                <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  id="edit_category" name="category">
                  <option value="" selected disabled>Select category</option> <!-- This will be the default option -->
                  <?php
                  $sql = "SELECT * FROM category";
                  $result = mysqli_query($conn, $sql);

                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                      echo '<option value="' . $row['category_id'] . '">' . $row['name'] . '</option>';
                    }
                  } else {
                    // If query fails, display an error message
                    echo '<option>Error fetching categories: ' . mysqli_error($connection) . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>

            <div class="mt-1 mb-1">
              <span class="text-gray-700 dark:text-gray-400">Description</span>
              <textarea class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                name="description" id="edit_description" placeholder="Description" rows="4" cols="50"></textarea>
            </div>

            <footer
              class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
              <button
                @click="closeEditModal"
                class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                Cancel
              </button>
              <button
                type="submit" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                name="update" id="edit_product_id">
                Update
              </button>
            </footer>
          </div>
        </form>

      </div>
    </div>
  </div>
  <!-- end Edit Product Modal -->

  <script>
    // JavaScript function to fetch product details and populate edit modal
    function fetchProductDetails(productId) {

      console.log(productId); // Check if the productId is correct
      $.ajax({
        url: 'getProducts.php',
        type: 'POST',
        data: {
          id: productId
        },
        success: function(data) {
          console.log(data); // Check the returned data
          var product = JSON.parse(data);
          $('#edit_product_id').val(product.product_id);
          $('#edit_productname').val(product.name);
          $('#edit_category').val(product.category_id);
          $('#edit_price').val(product.price);
          $('#edit_description').val(product.description);
          // alert(product.price);

          // Set the image source and make it visible if there is an image
          if (product.image) {
            $('#current_image').attr('src', './uploads/' + product.image).show();
          } else {
            $('#current_image').hide();
          }

          // $('#editmodal').modal('show');// Show the modal after populating data

        },
        error: function() {
          alert('Failed to fetch product details.');
        }
      });
    }
  </script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
</body>

</html>