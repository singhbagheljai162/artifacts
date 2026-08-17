                <?php
                require_once "includes/config.php";

                // Pagination
                $limit = 8;
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                if($page < 1){
                    $page = 1;
                }
                $offset = ($page-1)*$limit;

                // Category Filter
                $where = "";
                $current_category = "";
                if(isset($_GET['category']) && !empty($_GET['category']))
                {
                    $cat = intval($_GET['category']);
                    $where = " WHERE products.category_id='$cat' ";
                    $current_category = $cat;
                }

                // Sorting
                $order = "products.id DESC";
                if(isset($_GET['sort']))
                {

                    if($_GET['sort']=="low")
                    {
                        $order="products.price ASC";
                    }

                    elseif($_GET['sort']=="high")
                    {
                        $order="products.price DESC";
                    }

                    elseif($_GET['sort']=="name")
                    {
                        $order="products.product_name ASC";
                    }

                }

                // Product Query
                $sql="SELECT products.*,categories.category_name FROM products INNER JOIN categories
                ON products.category_id=categories.id $where ORDER BY $order LIMIT $offset,$limit";
                $result=mysqli_query($conn,$sql);
                ?>

                <!DOCTYPE html>
                <html>
                <?php include 'inc/head.php'; ?>
                <body>
                <?php include 'inc/header.php'; ?>

                <section class="category-banner">
                <h1>Historical Collection</h1>
                <p>Explore ancient coins, royal weapons, paintings and heritage artifacts.</p>
                </section>
                <div class="categories-container">

                <!-- ================= SIDEBAR ================= -->

                <aside class="sidebar">
                <h3><i class="fa fa-list"></i> Categories</h3>
                <ul><?php
                $categories=mysqli_query($conn,
                "SELECT * FROM categories WHERE status='Active'");
                while($c=mysqli_fetch_assoc($categories))
                {
                $active="";
                if($current_category==$c['id'])
                {
                    $active="active";
                }
                ?>
                <li class="<?php echo $active; ?>"><a href="shop.php?category=<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['category_name']); ?></a></li>
                <?php } ?></ul>
                <div class="filter-box">
                <h3>
                Price Filter
                </h3>
                <label>
                <input type="checkbox">
                ₹1000 - ₹5000
                </label>

                <label>
                <input type="checkbox">
                ₹5000 - ₹10000
                </label>

                <label>
                <input type="checkbox">
                Above ₹10000
                </label>
                </div>
                <div class="filter-box">

                <h3>
                Era
                </h3>

                <label>
                <input type="checkbox">
                Ancient Era
                </label>

                <label>
                <input type="checkbox">
                Mughal Era
                </label>

                <label>
                <input type="checkbox">
                Rajput Era
                </label>

                </div>
                </aside>
                <!-- ================= PRODUCTS ================= -->
                <section class="products-section">
                <div class="shop-header">

                <h2>
                Artifacts
                </h2>

                <select onchange="location=this.value;">
                <option>
                Sort By
                </option>
                <option 
                value="shop.php?sort=low<?php echo $current_category?'&category='.$current_category:''; ?>">
                Price Low To High
                </option>
                <option 
                value="shop.php?sort=high<?php echo $current_category?'&category='.$current_category:''; ?>">
                Price High To Low
                </option>
                <option 
                value="shop.php?sort=name<?php echo $current_category?'&category='.$current_category:''; ?>">
                Name A-Z
                </option>
                </select>
                </div>
                <div class="product-grid">
                <?php
                if(mysqli_num_rows($result)>0)

                {
                while($row=mysqli_fetch_assoc($result))
                {
                ?>
                <div class="product-card">
                <div class="product-image">
                <img src="<?php echo SITE_URL.'images/'.$row['main_image']; ?>">
                <?php if(!empty($row['tag'])){ ?>
                <span class="tag">
                <?php echo $row['tag']; ?>
                </span>
                <?php } ?>
                </div>
                <div class="product-info">
                <span class="category-name">
                <?php echo $row['category_name']; ?>
                </span>
                <h4>
                <?php echo htmlspecialchars($row['product_name']); ?>
                </h4>
                <p class="era">
                <?php echo $row['era']; ?>
                </p>
                <h3> ₹ <?php echo number_format($row['price']); ?></h3>
                <button>
                Add To Cart
                </button>
                </div>
                </div>
                <?php
                }
                }

                else

                {

                echo "

                <div class='no-product'>
                No Products Found
                </div>

                ";

                }


                ?>



                </div>





                <!-- ================= PAGINATION ================= -->


                <div class="pagination">



                <?php


                $count=mysqli_query($conn,

                "SELECT COUNT(*) total FROM products $where");


                $total=mysqli_fetch_assoc($count)['total'];


                $total_pages=ceil($total/$limit);





                if($page>1)

                {

                ?>

                <a href="?page=<?php echo $page-1; ?>">

                Prev

                </a>

                <?php } ?>




                <?php

                for($i=1;$i<=$total_pages;$i++)

                {


                ?>

                <a class="<?php echo ($page==$i)?'active':''; ?>"
                href="?page=<?php echo $i; ?><?php echo $current_category?'&category='.$current_category:''; ?>">

                <?php echo $i; ?>

                </a>


                <?php } ?>




                <?php

                if($page<$total_pages)

                {

                ?>

                <a href="?page=<?php echo $page+1; ?>">

                Next

                </a>


                <?php } ?>



                </div>




                </section>


                </div>



                <?php include 'inc/footer.php'; ?>


                </body>

                </html>