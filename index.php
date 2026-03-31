<?php
session_start();
error_reporting(0);

include 'config.php';
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Ecom</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:"Segoe UI",sans-serif;
}

body{
    background:#f4f6fb;
}

/* ===== NAVBAR ===== */
nav{
    background:linear-gradient(to right,#2f3375,#4b50d6);
    padding:28px 70px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
}
nav h2{
    color:#fff;
    font-size:28px;
}
nav ul{
    list-style:none;
    display:flex;
    gap:32px;
}
nav ul li a{
    color:#fff;
    text-decoration:none;
    font-size:16px;
    font-weight:500;
}
nav ul li a:hover{
    opacity:0.8;
}

/* ===== HERO (PROFESSIONAL) ===== */
.hero{
        background:linear-gradient(135deg,#6a5acd,#8b7bff);

    padding:130px 20px;
    text-align:center;
    color:white;
}
.hero h1{
    font-size:62px;
    letter-spacing:1px;
}
.hero p{
    margin:18px auto;
    font-size:20px;
    max-width:650px;
    opacity:0.95;
}
.hero-buttons{
    margin-top:35px;
}
.hero-buttons button{
    padding:15px 38px;
    font-size:16px;
    border-radius:30px;
    border:none;
    cursor:pointer;
    margin:0 10px;
}
.hero-buttons .primary{
    background:white;
    color:#3b3f8c;
    font-weight:600;
}
.hero-buttons .secondary{
    background:transparent;
    color:white;
    border:2px solid white;
}
.hero-buttons button:hover{
    transform:translateY(-2px);
}

/* ===== PRODUCTS ===== */
.products{
    padding:80px 70px;
}
.products h2{
    text-align:center;
    margin-bottom:55px;
    font-size:34px;
}
.product-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:35px;
}
.card{
    background:#fff;
    border-radius:16px;
    padding:22px;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
    transition:0.3s;
}
.card:hover{
    transform:translateY(-10px);
}
.card img{
    width:100%;
    height:220px;
    object-fit:contain;
    background:#f4f6fb;
    border-radius:12px;
}
.card h3{
    margin:18px 0 10px;
    font-size:20px;
}
.card p{
    font-size:14px;
    color:#666;
}
.price{
    margin:15px 0;
    font-size:18px;
    font-weight:bold;
    color:#3b3f8c;
}
.card button{
    padding:12px 28px;
    background:#3b3f8c;
    color:white;
    border:none;
    border-radius:25px;
    cursor:pointer;
}
.card button:hover{
    background:#2f3375;
}

/* ===== FOOTER ===== */
footer{
    background:#0f0f1a;
    color:#ccc;
    padding:80px 70px;
}
.footer-grid{
    max-width:1200px;
    margin:auto;
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:45px;
}
footer h4{
    color:white;
    margin-bottom:20px;
}
footer ul{
    list-style:none;
}
footer ul li{
    margin-bottom:12px;
    font-size:14px;
}
.copy{
    text-align:center;
    margin-top:55px;
    font-size:14px;
    color:#aaa;
}

/* ===== RESPONSIVE ===== */
@media(max-width:992px){
    .product-grid{
        grid-template-columns:repeat(2,1fr);
    }
}
@media(max-width:600px){
    nav{
        justify-content:center;
        gap:20px;
    }
    nav ul{
        flex-wrap:wrap;
        justify-content:center;
    }
    .product-grid{
        grid-template-columns:1fr;
    }
    .hero h1{
        font-size:42px;
    }
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav>
    <h2>My Ecom</h2>
    <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Products</a></li>
        <li><a href="#">Contact</a></li>
        <?php
        if($_SESSION['user_email'] == true){
            echo '<li style="color: white; font-weight: bold; font-size: 16px;">Welcome, ' . $_SESSION['user_name'] . '</li>';
            echo   '<li><a href="admin/dashboard.php">Dashboard</a></li>';

            echo'<a href="" style="color:white;font-weight:bold;font-size:22px;">
            <li class="fa-solid fa-cart-shopping"></li>
            
            </a>';




            echo '<li><a href="logout.php">Logout</a></li>';
        }else{
            echo '<li><a href="register.php">Register</a></li>';
            echo '<li><a href="login.php">Login</a></li>';
        }
        ?>
    </ul>
</nav>

<!-- HERO -->
<section class="hero">
    <h1>Online Shopping Made Easy</h1>
    <p>Discover premium products, trusted quality and unbeatable prices — all in one place.</p>
    <div class="hero-buttons">
        <button class="primary">Shop Now</button>
        <button class="secondary">Explore</button>
    </div>
</section>

<!-- PRODUCTS -->
<section class="products">
    <h2>Our Products</h2>

    <div class="product-grid">
    <?php
    while($row = mysqli_fetch_assoc($result)){

    
    ?>

        <div class="card">
            <img src="image/<?php echo $row['image'] ?>">
            <h3><?php echo $row['name'] ?></h3>
            <p><?php echo $row['description'] ?> </p>
            <div class="price"><?php echo $row['price'] ?></div>
           <a href="product_detail.php? product_id=<?php echo $row['id'] ?>"> <button>Buy Now</button></a>
        </div>
<?php } ?>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="footer-grid">
        <div>
            <h4>Services</h4>
            <ul>
                <li>Web Development</li>
                <li>App Development</li>
                <li>Digital Marketing</li>
            </ul>
        </div>
        <div>
            <h4>Social</h4>
            <ul>
                <li>Facebook</li>
                <li>Instagram</li>
                <li>Twitter</li>
            </ul>
        </div>
        <div>
            <h4>Quick Links</h4>
            <ul>
                <li>Home</li>
                <li>Products</li>
                <li>Contact</li>
            </ul>
        </div>
        <div>
            <h4>Contact</h4>
            <ul>
                <li>Kathmandu, Nepal</li>
                <li>info@gmail.com</li>
                <li>98XXXXXXXX</li>
            </ul>
        </div>
    </div>

    <div class="copy">
        © 2026 My Ecom. All Rights Reserved.
    </div>
</footer>

</body>
</html>