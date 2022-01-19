<?php
$results_per_page = 5;
if (isset($_GET['pageno'])) {
    $pageno = (int)$_GET['pageno'];
    $page_first_result = ($pageno - 1) * $results_per_page;
} else {
    $pageno = 1;
    $page_first_result = 0;
}

include_once("../php/dbconnect.php");
$sqlitems = "SELECT * FROM table_item ORDER BY itemcode ASC";
$stmt = $conn->prepare($sqlitems);
$stmt->execute();
$number_of_result = $stmt->rowCount();
$number_of_page = ceil($number_of_result / $results_per_page);
$sqlitems = $sqlitems . " LIMIT $page_first_result , $results_per_page";
$stmt = $conn->prepare($sqlitems);
$stmt-> execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" type="text/css" href="../php/style.css">
    <script src="https://kit.fontawesome.com/9ed75330c4.js" crossorigin="anonymous" rel="stylesheet"></script>
    <title>LAB 3</title>
</head>

<body>
    <div class="w3-header w3-display-container w3-teal w3-padding-32 w3-center">
        <h1 style="font-size:calc(8px + 4vw);">F&L Florist</h1>
        <p style="font-size:calc(4px + 2vw);">Welcome to the F&L FLorist</p>
    </div>

    <div class = "w3-grid-template">
        <?php
        foreach ($rows as $items) {
            $itemcode = $items["itemcode"];
            $itemname = $items["itemname"];
            $colour = $items["colour"];
            $price = $items["price"];
            $stock = $items["stock"];
            echo "<div class='w3-center w3-padding'>";
            echo "<div class='w3-card-4 w3-dark-grey'>";
            echo "<header class='w3-container w3-teal'>";
            echo "<h5>$itemname</h5>";
            echo "</header>";
            echo "<img class='w3-image' src=../image/FLOWER.png" .
            " onerror=this.onerror=null;this.src=../image/$itemcode.jpg'" .
            "style='width:100%;height:250px'>";
            echo "<div class='w3-container w3-left-align'><hr>";
            echo "<p><i class='fas fa-brush' style='font-size:16px'></i>&nbsp&nbsp&nbsp&nbsp<p1>Item Code:</p1>$itemcode<br>
                    <i class='fas fa-tint' style='font-size:16px'></i>&nbsp&nbsp&nbsp&nbsp<p1>Colour:</p1>$colour<br>
                    <i class='fas fa-money-bill-wave' style='font-size:16px'></i>&nbsp&nbsp<p1>RM</p1>$price<br>
                    <i class='fas fa-warehouse' style='font-size:16px'></i>&nbsp&nbsp<p1>Stock:</p1>$stock<br></p><hr>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        
        }
        ?>
    </div>

<?php
    $num = 1;
    if ($pageno == 1) {
        $num = 1;
    } else if ($pageno == 2) {
        $num = ($num) + 10;
    } else {
        $num = $pageno * 10 - 9;
    }
    echo "<div class='w3-container w3-row'>";
    echo "<center>";
    for ($page = 1; $page <= $number_of_page; $page++) {
        echo'<a href = "LAB3.php?pageno=' . $page . '" style= "text-decoration: none">&nbsp&nbsp'
        . $page . ' </a>';
    }
    echo " [ " . $pageno . " ] ";
    echo "</center>";
    echo "</div>";
?>
</body>

<footer class="w3-container w3-dark-grey w3-center">
    <p> © Copyright:Florist</p>
    <p>TERMS AND CONDITIONS <br> PRIVACY POLICY</p>
    <p><a href="mailto:Florist@example.com">F&Lflorist@gmail.com</a></p>
</footer>

</html>