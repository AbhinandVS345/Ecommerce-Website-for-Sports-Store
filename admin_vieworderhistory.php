<?php
include('Connection.php');
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
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Order History
            </h2>
            <!-- Date Selection Form -->
            <form method="post" style="margin-bottom: 30px;">
                <label for="start_date" class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Start Date:</label>
                <input type="date"
                    class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                    id="start_date" name="start_date"
                    value="<?php echo isset($_POST['start_date']) ? htmlspecialchars($_POST['start_date']) : ''; ?>"
                    style="margin-right: 10px;" required>

                <label for="end_date" class="mb-4 font-semibold text-gray-800 dark:text-gray-300">End Date:</label>
                <input type="date"
                    class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                    id="end_date" name="end_date"
                    value="<?php echo isset($_POST['end_date']) ? htmlspecialchars($_POST['end_date']) : ''; ?>"
                    style="margin-right: 10px;" required>

                <button type="submit" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Show Orders
                </button>
            </form>

            <!-- At specific date -->
            <form method="post" style="margin-bottom: 30px;">
                <label for="select_date" class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Select Date:</label>
                <input type="date"
                    class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                    id="select_date" name="select_date"
                    value="<?php echo isset($_POST['select_date']) ? htmlspecialchars($_POST['select_date']) : ''; ?>"
                    style="margin-right: 10px;" required>

                <button type="submit" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Show Orders
                </button>
            </form>

            <div class="w-full overflow-hidden rounded-lg shadow-xs">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr
                                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">Sl.No</th>
                                <th class="px-4 py-3">Order_ID</th>
                                <th class="px-4 py-3">Client</th>
                                <th class="px-4 py-3">Order Date</th>
                                <th class="px-4 py-3">Amount</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody
                            class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            <?php
                            $sql = "SELECT *, c.name as name FROM ordermaster om 
                            JOIN customer c ON om.customer_id=c.customer_id WHERE status = 'Delivered'";

                            // Check if dates are selected and modify SQL query accordingly
                            if (!empty($_POST['start_date']) && !empty($_POST['end_date'])) {
                                $start_date = $_POST['start_date'];
                                $end_date = $_POST['end_date'];
                                $sql .= " AND order_date BETWEEN '$start_date' AND '$end_date' ORDER BY ordermaster_id DESC";
                            }

                            // Check if single date is selected and modify SQL query accordingly
                            if (!empty($_POST['select_date'])) {
                                $select_date = $_POST['select_date'];
                                $sql .= " AND order_date = '$select_date' ORDER BY ordermaster_id DESC";
                            }

                            $result = mysqli_query($conn, $sql);
                            $count = 0;
                            while ($row = mysqli_fetch_array($result)) {
                                $count++;
                            ?>
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3">
                                        <?php echo $count; ?>
                                    </td>
                                    <td class="px-4 py-3">
                                        <?php echo $row['ordermaster_id']; ?>
                                    </td>
                                    <td class="px-4 py-3">
                                        <?php echo $row['name']; ?>
                                    </td>
                                    <td class="px-4 py-3">
                                        <?php echo $row['order_date']; ?>
                                    </td>
                                    <td class="px-4 py-3">
                                        <?php echo $row['totalamount']; ?>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center space-x-4 text-sm">
                                            <button onclick="window.location.href='admin_home.php?page=details&ordermaster_id=<?php echo $row['ordermaster_id']; ?>';" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                                View more
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
</body>

</html>