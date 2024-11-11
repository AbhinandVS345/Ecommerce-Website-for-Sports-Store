<?php
include('connection.php');
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stock Update</title>
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
      <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Product Stock
      </h2>

      <!-- Table -->


      <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr
                class="text-xs font-semibold tracking-wide text-left text-gray-1000 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                <th class="px-4 py-3">No.</th>
                <th class="px-4 py-3">Product Name</th>
                <th class="px-4 py-3">Image</th>
                <th class="px-4 py-3">Category</th>
                <th class="px-4 py-3">Sports</th>
                <th class="px-4 py-3">Total Stock</th>
                <th class="px-4 py-3">Action</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
              <?php
              $sql = "SELECT p.*, c.name AS category_name, s.name AS sports_name
                      FROM product p
                      INNER JOIN category c ON p.category_id = c.category_id
                      INNER JOIN sports s ON p.sports_id = s.sports_id";
              $result = mysqli_query($conn, $sql);
              $count = 0;

              while ($row = mysqli_fetch_array($result)) {
                $count++;
                $product_id = $row['product_id'];
                $sql2 = "SELECT SUM(stock) FROM single_product WHERE product_id=$product_id";
                $result2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_row($result2);
                $totalstock = $row2[0] ?? 0; // Assign 0 if NULL                                      
              ?>
                <tr class="text-gray-700 dark:text-gray-400">
                  <td><?php echo $count; ?></td>
                  <td><?php echo $row['name']; ?> </td>
                  <td><img style="width:150px;height:150px;" class="img-responsive" src="./uploads/<?php echo $row['image']; ?>" /> </td>
                  <td><?php echo $row['category_name']; ?> </td>
                  <td><?php echo $row['sports_name']; ?> </td>
                  <td><?php echo $totalstock; ?> </td>

                  <div class="flex items-center space-x-4 text-sm">
                    <td class="px-4 py-3">
                      <button onclick="window.location.href='admin_home.php?page=single&product_id=<?php echo $row['product_id']; ?>';"
                        class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Update
                      </button>
                    </td>
                  </div>

                <?php } ?>

                </tr>

            </tbody>
          </table>
        </div>
      </div>
    </div>
    </div>
  </main>


  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
</body>

</html>