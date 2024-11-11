<?php

include('Connection.php');

if (isset($_POST["delete"])) {

  $feedback_id = $_POST['delete'];
  $sql = "DELETE FROM feedback WHERE feedback_id='$feedback_id'";
  if (mysqli_query($conn, $sql)) {
    $_SESSION['status'] = "Feedback deleted successfully!";
  } else {
    $_SESSION['status'] = "Feedback deletion failed!";
  }
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Feedbacks</title>
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
        Table: Feedback
      </h2>



      <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr
                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                <th class="px-4 py-3">No.</th>
                <th class="px-4 py-3">Cutomer Id</th>
                <th class="px-4 py-3">Date</th>
                <th class="px-4 py-3">Comment</th>
                <th class="px-4 py-3">Action</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
              <?php
              $sql = "SELECT * FROM feedback";
              $count = 0;
              $result = mysqli_query($conn, $sql);
              while ($row = mysqli_fetch_array($result)) {
                $count += 1;
              ?>
                <tr class="text-gray-700 dark:text-gray-400">
                  <td><?php echo $count; ?></td>
                  <td><?php echo $row['customer_id']; ?> </td>
                  <td><?php echo $row['date']; ?> </td>
                  <td><?php echo $row['comment']; ?> </td>
                  <td class="px-4 py-3">
                    <div class="flex items-center space-x-4 text-sm">
                      <form method="POST" action="">
                        <input type="hidden" name="delete" value="<?php echo $row['feedback_id']; ?>">
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
    </div>
  </main>


  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
</body>

</html>