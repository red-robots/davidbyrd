<?php $active = get_field("banner_active","option");
if(strcmp($active,"yes")===0):?>
    <aside class="banner">
        <?php $banner_title = get_field("banner_title","option");
        $banner_copy = get_field("banner_copy","option");
        $shop_text = get_field("shop_text","option");
        $shop_link = get_field("shop_link","option");?>
        <div class="col-1">
            <?php if($banner_title):?>
                <header><h2><?php echo $banner_title;?></h2></header>
            <?php endif;
            if($banner_copy):?>
                <div class="copy">
                    <?php echo $banner_copy;?>
                </div><!--.copy-->
            <?php endif;?>
        </div><!--.col-1-->
        <?php if($shop_link&&$shop_text):?>
            <div class="col-2">
                <a href="<?php echo $shop_link;?>">
                    <?php echo $shop_text;?>
                </a>
            </div><!--.col-2-->
        <?php endif;?>
    </aside><!--.banner-->
<?php endif;?>