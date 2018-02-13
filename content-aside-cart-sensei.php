<?php global $search_link_id;?>
<aside class="cart-bar row-1">
    <div class="wrapper">
        <div class="col-1">
            <form class="bella-search" action="<?php echo get_the_permalink($search_link_id);?>" method="POST">
                <input type="text" name="search" placeholder="" <?php if(isset($_POST['search'])) echo 'value="'.$_POST['search'].'"';?>>
            </form>
            <i class="search fa fa-search"></i>
        </div><!--.col-1-->
        <div class="break"></div><!--.break-->
        <div class="col-2">
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
        </div><!--.col-2-->
    </div><!--.wrapper-->
</aside>