<?php
require_once "connect.php";
require_once "libs/Validate.class.php";
require_once 'libs/Form.class.php';
$errors = '';
$listFiew = ['link' => '', 'ordering' => '', 'status' => ''];
if (!empty($_POST)) {
    $validate = new Validate($_POST);
    $validate->addRule('link', 'url', 2, 500)
        ->addRule('status', 'string')
        ->addRule('ordering', 'int', 1, 100);
    $validate->run();
    $results = $validate->getResult();
    foreach ($results as $key => $value) {
        $listFiew[$key] = $value;
    }
    if ($validate->isValid()) {
        $items = $validate->getResult();
        $database->insert($items);
    } else {
        $errors = $validate->showErrors();
    }
}
$labelLink = Form::label('Link');
$inputLink = Form::input('text', 'link', $listFiew['link']);

$labelStatus = Form::label('Status');
$statusValue = ['0' => 'Select status', 'active' => 'Active', 'inactive' => 'Inactive'];
$statusSelect = Form::selectBox($statusValue, 'status', $listFiew['status']);

$labelOrdering = Form::label('Ordering');
$inputOrdering = Form::input('text', 'ordering', $listFiew['ordering']);

$rowLink = Form::formRow($labelLink, $inputLink);
$rowStatus = Form::formRow($labelStatus, $statusSelect);
$rowOrdering = Form::formRow($labelOrdering, $inputOrdering);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "html/head.php" ?>
</head>

<body style="background-color: #eee;">
    <div class="container pt-5">
        <form action="" method="post">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="m-0">ADD RSS</h4>
                </div>
                <div class="card-body">
                    <?php echo $errors ?>
                    <?php echo $rowLink . $rowStatus . $rowOrdering ?>
                </div>
                <div class="card-footer">
                    <input class="form-control" type="hidden" name="token" value="1611025715"> <button type="submit"
                        class="btn btn-success">Save</button>
                    <a href="list.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>
        </form>
    </div>
    <?php require_once "html/script.php" ?>
</body>

</html>