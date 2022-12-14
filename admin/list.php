<?php
require_once "connect.php";
require_once 'libs/Helper.class.php';

session_start();
if (isset($_SESSION)) {
    if ($_SESSION['timeout'] + 30 > time()) {
        $searchValue = isset($_GET['search']) ? trim($_GET['search']) : '';
        $query = "SELECT * FROM `rss`";

        if ($searchValue != "") $query .= "WHERE `link` LIKE '%$searchValue%'";
        $queryResult = $database->query($query);
        $items = $database->getListRecord($queryResult);
        $trHtml = '';
        foreach ($items as $item) {
            $link = Helper::highlight($searchValue, $item['link']);
            $status = Helper::showItemStatus($item['id'], $item['status']);
            $trHtml .= sprintf('<tr>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>
                                <a href="edit.php?id=%s&link=%s&status=%s&ordering=%s" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete.php?id=%s" class="btn btn-sm btn-danger btn-delete">Delete</a>
                            </td>
                        </tr>', $item['id'], $link, $status, $item['ordering'], $item['id'], $item['link'], $item['status'], $item['ordering'], $item['id']);
        }
    } else {
        header("location: ../login.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'html/head.php'; ?>
</head>

<body style="background-color: #eee;">
    <div class="container pt-5">
        <div class="card mb-4">
            <div class="card-body d-flex justify-content-between">
                <a href="../index.php" class="btn btn-primary m-0">Back to website</a>
                <a href="logout.php" class="btn btn-info m-0">Logout</a>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <form action="" method="get">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="search" placeholder="Enter search keyword...."
                            value="<?php echo $searchValue ?>">
                        <div class="input-group-append">
                            <button type="submit"
                                class="btn btn-md btn-outline-primary m-0 px-3 py-2 z-depth-0 waves-effect"
                                type="button">Search</button>
                            <a href="list.php"
                                class="btn btn-md btn-outline-danger m-0 px-3 py-2 z-depth-0 waves-effect"
                                type="button">Clear</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="m-0">RSS List</h4>
                <span class="alert alert-warning">Hiện tại trang chỉ hỗ trợ RSS từ VNEXPRESS.NET</span>
                <a href="add.php" class="btn btn-success m-0">Add</a>
            </div>
            <div class="card-body">
                <table class="table table-striped btn-table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Link</th>
                            <th scope="col">Status</th>
                            <th scope="col">Ordering</th>
                            <th scope="col">Action</th>
                        </tr>
                        <?php echo $trHtml ?>
                    </thead>
                    <tbody>




                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php require_once 'html/script.php'; ?>
    <script>
    $(document).ready(function() {
        $('.btn-delete').click(function(e) {
            e.preventDefault(); //ngan chuyen trang truoc khi confirm
            let result = confirm('Are you sure?');
            if (result) {
                let href = $(this).attr('href');
                window.location.href = href;
            }
        })
    })
    </script>
</body>

</html>