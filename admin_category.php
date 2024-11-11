<?php

include('Connection.php');

if (isset($_POST["submit"])) {

  if (isset($_POST['name'])) {
    $categoryName = $_POST['name'];
    $categoryImage = $_FILES['image']['name'];
    // Move uploaded file to desired location
    move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $categoryImage);
    // Check for duplicate category (case insensitive)
    $check_sql = "SELECT * FROM category WHERE LOWER(name) = LOWER('$categoryName')";
    $result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($result) > 0) {
      echo "<script>alert('Category already exists.');</script>";
    } else {
      // If no duplicate, insert the new category
      $sql = "INSERT INTO category (name, image) VALUES ('$categoryName','$categoryImage')";
      // Execute SQL query
      if (mysqli_query($conn, $sql)) {
        $_SESSION['status'] = "Category added successfully!";
      } else {
        $_SESSION['status'] = "Category addition failed!";
      }
    }
  } else {
    echo "Category value is not set or empty.";
  }
} elseif (isset($_POST["delete"])) {

  $category_id = $_POST['delete'];
  $sql = "DELETE FROM category WHERE category_id='$category_id'";
  if (mysqli_query($conn, $sql)) {
    $_SESSION['status'] = "Category deleted successfully!";
  } else {
    $_SESSION['status'] = "Category deletion failed!";
  }
}


?>


<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Category</title>
  <link rel="stylesheet" href="adminstyle/css/tailwind.output.css" />
  <script
    src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
    defer></script>
  <script src="adminstyle/js/init-alpine.js"></script>
  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
</head>

<body>



  <main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-6 mx-auto">

      <!-- Table -->
      <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Table: Category
      </h2>

      <!-- Button trigger modal -->

      <div>
        <button
          @click="openModal"
          class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
          New Category
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
                <th class="px-4 py-3">Action</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
              <?php
              $sql = "SELECT * FROM category";
              $count = 0;
              $result = mysqli_query($conn, $sql);
              while ($row = mysqli_fetch_array($result)) {
                $count += 1;
              ?>
                <tr class="text-gray-700 dark:text-gray-400">
                  <td><?php echo $count; ?></td>
                  <td><?php echo $row['name']; ?> </td>
                  <td><img style="width:150px;height:150px;" class="img-responsive" src="./uploads/<?php echo $row['image']; ?>" /> </td>

                  <td class="px-4 py-3">
                    <div class="flex items-center space-x-4 text-sm">
                      <form method="POST" action="">
                        <input type="hidden" name="delete" value="<?php echo $row['category_id']; ?>">
                        <button type="submit" name="id" value="Delete"
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
          <span class="text-gray-700 dark:text-gray-400">Name</span>
          <input type="text" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            name="name" placeholder="Name" />

          <span class="text-gray-700 dark:text-gray-400">Image</span>
          <input type="file" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            name="image" placeholder="Choose file" />
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

      </form>
    </div>
  </div>
  <!-- End of modal backdrop -->

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
</body>

</html>