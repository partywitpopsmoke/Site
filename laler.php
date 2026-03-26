<?php 
include 'pogii.php';
if ($_SERVER["REQUEST_METHOD"]=== "POST") {
    $product_id = $_POST["product_id"];
    $product_name = $_POST["product_name"];
    $price = $_POST["price"];
    $total_order = $_POST ["total_order"];
    $total_price = $_POST ["total_price"];

    $sql_stock ="SELECT stocks FROM products WHERE product_id = '$product_id'";
    $result_stock = mysqli_query(mysql: $conn, query: $sql_stock);
    $row_stock = mysqli_fetch_assoc(result: $result_stock);
    $current_stock = $row_stock["stocks"];

    if ($total_order > $current_stock) {
        $message = "Order exceeds available stock! Only ($current_stock) left.";
    }
    else {
        $sql_insert = "INSERT INTO data1 (product_id, product_name, price, total_order, total_price)
                VALUES ('$product_id', '$product_name', '$price', '$total_order', '$total_price')";

        if (mysqli_query(mysql:$conn, query: $sql_insert)){
            $new_stock = $current_stock - $total_order;
            $sql_update = "UPDATE products SET stocks ='$new_stock' WHERE product_id ='$product_id'";
            mysqli_query(mysql: $conn, query: $sql_update);

            $message = "Order Placed Successfully!";
        } else {
            $message = "Error:";
        }
    }
}

?>
<?php if (isset($message));?>
<script>
    alert("<?php echo $message;?>");
    window.location.href = "p2.php";
</script>
<?php ; ?>