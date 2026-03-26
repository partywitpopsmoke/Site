<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="carousel.css" rel="stylesheet"/>
    <style>
        body {
            padding: 0;
            color: black;
            font-family:arial, sans-serif;
        }

        /* Product Grid */
        .product-grid {
            display: flex;
            grid-template-columns: repeat(auto-fit, minmax(250px,1fr));
            gap: 20px;
            width: 90%;
            margin: auto;
            padding: 20px 10px;
        }
        .product-card {
            padding: 20px;
            background: white;
            transition: transform 0.3s ease;
            border-radius: 25px;
            border: 2px solid black;
            text-align: center ;
        }
        .product-card:hover { transform: translateY(-10px); }
        .product-image-holder img {
            width: 100%;
            height: 200px;
            object-fit: contain;
            border-radius: 15px;
            margin-bottom: 15px;
        }
        .label-box { margin-bottom: 8px; font-size: 0.9rem; }
        .label-box strong { color: black; }

        /* Buttons */
         .buy-now {
            justify-content: center;
            flex: 1;
            border-radius: 8px;
            padding: 20px;
            font-size: 0.85rem;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
        .buy-now { background: skyblue; color: black; border: 1px solid black; }
        
        /* Modal Overhaul */
        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            width: 30%;
            height: auto;      
            max-height: 90vh;    
            background: transparent; 
            text-align: center;
        }
        .modal.active { display: flex; }
        .modal-box {
            background: white;
            height: 100%;
            width: 100%;
            color: black;
            max-width: 450px;
            max-height: 90vh;
            overflow-y: auto;
            padding: 25px;
            border-radius: 20px;
            border: 5px solid black;
            position: relative;
            box-sizing: border-box; 
            -ms-overflow-style: none;  
            scrollbar-width: none;
        }

        .modal-box::-webkit-scrollbar {
            display: none;
        }
        .modal-box input, .modal-box select {
            width: 100%;
            padding: 8px;
            margin: 5px 0 15px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

    </style>
</head>
<body>



<section>
    <?php
    include 'pogii.php';
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
    ?>

    <div class="product-grid">
    <?php
    if ($result->num_rows > 0) {
        while($product = $result->fetch_assoc()) { 
    ?>           
        <div class="product-card">
             <div class="product-image-holder">
                <img src="shop.php?id=<?php echo $product['product_id']; ?>" alt="Product Image">
             </div>
              <div class="label-box"><strong>Product:</strong> <?php echo $product['product_name'];?></div>
               <div class="label-box"><strong>Price:</strong> ₱<?php echo number_format($product['price'], 2) ?></div>
                <div class="label-box"><strong>Stocks:</strong> <?php echo $product['stocks'];?></div>

                 <div class="btn-group">
                   
                    <button class="buy-now" onclick="openModal('<?php echo $product['product_id'] ?>', '<?php echo $product['product_name']?>', '<?php echo $product['price']?>')">Buy Now</button>
                 </div>
        </div>
    <?php 
        }
    } else {
        echo "<p>No products available.</p>";
    }
    $conn->close();
    ?>
    </div>
    <div class="modal" id="modal">
        <div class="modal-box">
            <h4 style="text-align:center;"><strong>Confirm Order</strong></h4>
            <form action="laler.php" method="POST">
                <input type="hidden" name="product_id" id="product_id">
                
                <div style="text-align:center;">
                    <img src="" id="img_id" alt="Product Preview" style="max-height: 120px; margin-bottom: 10px;">
                </div>

                <label><b>Product Name:</b></label>
                <input type="text" name="product_name" id="product_name" readonly>

                <label><b>Price (PHP):</b></label>
                <input type="number" name="price" id="price" readonly>
                <label><b>Quantity:</b></label>
                <input type="number" name="total_order" id="total_order" oninput="computeTotal()" required min="1">

                <label><b>Total Price:</b></label>
                <input type="number" name="total_price" id="total_price" readonly>

                <div style="display:flex; gap: 10px;">
                    <button type="submit" class="buy-now" style="flex:2;">Place Order</button>
                    <button type="button" class="buy-now" onclick="closeModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</section>


<script>
  function openModal(id, name, price) {
    document.getElementById("modal").classList.add("active");
    document.getElementById("product_id").value = id;
    document.getElementById("product_name").value = name;
    document.getElementById("price").value = price;
    document.getElementById("total_order").value = "";
    document.getElementById("total_price").value = "";
    document.getElementById("img_id").src = "shop.php?id=" + id;
  }

  function closeModal(){
    document.getElementById("modal").classList.remove("active");
  }

  function computeTotal() {
    let price = document.getElementById("price").value;
    let qty = document.getElementById("total_order").value;
    document.getElementById("total_price").value = price * qty;
  }
</script>

<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

<footer style="
    border-top: 2px solid black;
    text-align: center;
    padding: 20px;
    font-family: arial, sans-serif;
    color: black;
    margin-top: 30px;
">
    <p style="margin: 0; font-size: 0.9rem;">
        &copy; 2025 <strong>ASSESMENT IM HEREEEE</strong> — All Rights Reserved
    </p>
    
</footer>

</body>
</html>