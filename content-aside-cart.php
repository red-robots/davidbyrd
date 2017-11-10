<aside class="cart-bar row-1">
    <div class="wrapper">
        <form class="bella-search" action="<?php the_permalink(551);?>" method="POST">
            <input type="text" name="search" placeholder="" <?php if(isset($_POST['search'])) echo 'value="'.$_POST['search'].'"';?>>
        </form>
        <i class="search fa fa-search"></i>
        <a href="<?php echo wc_get_cart_url();?>">
            <i class="fa fa-shopping-cart"></i>
        </a>
        <div class="wrapper">
            <div class="price-box">
            </div><!--.price-box-->
            <div class="quantity-box">
            </div><!--quantity-box-->
            <div class="popup-cart">
            </diV><!--#popup-cart-->
        </div><!--.wrapper-->
    </div><!--.wrapper-->
</aside>