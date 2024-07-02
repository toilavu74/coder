<?php 
// AJAX CAT PRODUCT 
add_shortcode('filter_ajax', 'filter_ajax');
function filter_ajax()
{
	ob_start();
    $content = ob_get_clean();
	$content .='<div class="list-filter filter-gewicht">';
    $parent_cat_arg = array('hide_empty' => false,'orderby' => 'ASC', 'parent' => 0 );
    $parent_cat = get_terms('product_cat',$parent_cat_arg);
    foreach ($parent_cat as $catVal) {
        $content .= '<a class="cat-click" data-id="'.$catVal->term_id.'" href="#">'.$catVal->name.'</a>';
    }
	$content .='</div>';
	return $content;
}

function list_product_archive(){
    ob_start();
    $content = ob_get_clean();
    $category = get_queried_object();
        $category_id = $category->term_id;
    
    $content .='<div class="products-listall list-cate">';

    $content .='<ul class="products">';
        
        $args1 = array(
            'post_type' => 'product', 
            'post_status' => 'publish',
            'orderby' => 'menu_order',
            'order' => 'ASC',  
            'post_per_page' => -1,
//          'meta_key'          => '_regular_price',
//          'orderby'           => 'meta_value',
//          'order'             => 'DESC'
        );
        if(isset($_GET['order'])){
            if($_GET['order'] == 'DESC'){
                $args1['order'] = $_GET['order'];
            }
            if($_GET['order'] == 'YASC'){
                $args1['meta_key'] = 'bouwjaar';
                $args1['orderby'] = 'meta_value';
                $args1['order'] = 'ASC';
            }
            if($_GET['order'] == 'YDESC'){
                $args1['meta_key'] = 'bouwjaar';
                $args1['orderby'] = 'meta_value';
                $args1['order'] = 'DESC';
            }
            if($_GET['order'] == 'MASC'){
                $args1['meta_key'] = 'bouwjaar';
                $args1['orderby'] = 'meta_value';
                $args1['order'] = 'ASC';
            }
            if($_GET['order'] == 'MDESC'){
                $args1['meta_key'] = 'bouwjaar';
                $args1['orderby'] = 'meta_value';
                $args1['order'] = 'DESC';
            }
            if($_GET['order'] == 'PASC'){
                $args1['meta_key'] = '_regular_price';
                $args1['orderby'] = 'meta_value_num';
                $args1['order'] = 'ASC';
            }
            if($_GET['order'] == 'PDESC'){
                $args1['meta_key'] = '_regular_price';
                $args1['orderby'] = 'meta_value_num';
                $args1['order'] = 'DESC';
            }
            
            if($_GET['order'] == 'HASC'){
                $args1['meta_key'] = 'draaiuren';
                $args1['orderby'] = 'meta_value_num';
                $args1['order'] = 'ASC';
            }
            if($_GET['order'] == 'HDESC'){
                $args1['meta_key'] = 'draaiuren';
                $args1['orderby'] = 'meta_value_num';
                $args1['order'] = 'DESC';
            }
        }
        if($category_id != ''){
            $args1['tax_query'] = array(
               array(
                 'taxonomy' => 'product_cat',
                 'field'    => 'term_id',
                 'terms'     => $category_id
                 //'operator'  => 'IN'
                 )
               );
        }
        $loop1 = new \WP_Query( $args1 );

        while ( $loop1->have_posts() ) : $loop1->the_post(); 
            $post_id = get_the_ID();
            $product = wc_get_product( $post_id );
        //var_dump($product);
        if (is_product_category('drierolwalsen')) {
            $price = "<a href='/offerte-aanvragen/'>Offerte aanvragen</a>";
        } else {
            $price = $product->get_price_html();
        }
    
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' );
            $totaalgewicht =get_field('totaalgewicht');
            $gewicht = explode(" ", $totaalgewicht);
            if(isset($_GET['gewicht'])){
                if($gewicht[0] > $_GET['min'] && $gewicht[0] < $_GET['max']){
            $content .='<li>'; 
                $content .='<a href="'.get_permalink( $loop1->post->ID ).'">';
                $content .='<img src="'.$image[0].'"/>';
                 $content .='<div class="box-title-price">';    
                $content .='<p class="title">'.get_the_title().'</p>';
                    $content .='<p class="price ssaas">'.$price.'</p>';
                       $content .='</div>'; 
                $content .='<ul class="list-info">';
                    if( get_field('bouwjaar') ):
                        $content .='<li>';
                            $content .='<div class="box-left">Bouwjaar:</div>'; 
                            $content .='<div class="box-right">'.get_field('bouwjaar').'</div>';   
                        $content .= '</li>';
                    endif;
                    if( get_field('draaiuren') ):
                        $content .='<li>';
                            $content .='<div class="box-left">Draaiuren:</div>'; 
                            $content .='<div class="box-right">'.get_field('draaiuren').'</div>';   
                        $content .= '</li>';
                    endif;
                      if( get_field('voorraad_nummer') ):
                        $content .='<li>';
                            $content .='<div class="box-left">Voorraad Nummer: ';   
                            $content .='</div>';    
                            $content .='<div class="box-right">'.get_field('voorraad_nummer');   
                            $content .='</div>';
                        $content .= '</li>';
                        endif;
                $content .= '</ul>';
                
                $content .='<p class="link">BEKIJK<i aria-hidden="true" class="fas fa-caret-right"></i></p>';
            $content .='</a>';
            $content .='</li>';
                }
            }else{
                   $content .='<li>';
                $content .='<a href="'.get_permalink( $loop1->post->ID ).'">';
                $content .='<img src="'.$image[0].'"/>';
                 $content .='<div class="box-title-price">';    
                $content .='<p class="title">'.get_the_title().'</p>';
                    $content .='<p class="price ssaas">'.$price.'</p>';
                       $content .='</div>'; 
                $content .='<ul class="list-info">';
                    if( get_field('bouwjaar') ):
                        $content .='<li>';
                            $content .='<div class="box-left">Bouwjaar:</div>'; 
                            $content .='<div class="box-right">'.get_field('bouwjaar').'</div>';   
                        $content .= '</li>';
                    endif;
                    if( get_field('draaiuren') ):
                        $content .='<li>';
                            $content .='<div class="box-left">Draaiuren:</div>'; 
                            $content .='<div class="box-right">'.get_field('draaiuren').'</div>';   
                        $content .= '</li>';
                    endif;
                      if( get_field('voorraad_nummer') ):
                        $content .='<li>';
                            $content .='<div class="box-left">Voorraad Nummer: ';   
                            $content .='</div>';    
                            $content .='<div class="box-right">'.get_field('voorraad_nummer');   
                            $content .='</div>';
                        $content .= '</li>';
                        endif;
                $content .= '</ul>';
                
                $content .='<p class="link">BEKIJK<i aria-hidden="true" class="fas fa-caret-right"></i></p>';
            $content .='</a>';
            $content .='</li>';
            }
        endwhile; \wp_reset_query();wp_reset_postdata();
    $content .='</ul>';
    $content .='</div>';
    return $content;
}

add_shortcode('list_product_archive', 'list_product_archive');

function filter_oderby(){
    ob_start();
    $content = ob_get_clean();
        $category = get_queried_object();
        $category_id = $category->term_id;
        $content .='<div class="products-sort">';
    
        $content .='<div class="dropdown-sort-container">';
        $content .='<div class="title">FILTER</div>';
            $content .='<div class="dropdown dropdown-sort" style="right:0 !important;">';
                if(!isset($_GET['order'])){
                    $content .='<a href="'.get_category_link($category_id).'" class="current">Nieuwste machines eerst</a>';
                }else{
                    $content .='<a href="'.get_category_link($category_id).'">Nieuwste machines eerst</a>';
                }
                if(isset($_GET['order']) && $_GET['order'] == 'DESC'){
                $content .='<a href="'.get_category_link($category_id) .'?order=ASC" class="current">Oudste eerst</a>';
                    }else{
                        $content .='<a href="'.get_category_link($category_id) .'?order=ASC" >Oudste eerst</a>';
                    }
                if(isset($_GET['order']) && $_GET['order'] == 'YDESC'){
                $content .='<a href="'.get_category_link($category_id) .'?order=YDESC" class="current">Jaar (hoog - laag)</a>';
                    }else{
                        $content .='<a href="'.get_category_link($category_id) .'?order=YDESC" >Jaar (hoog - laag)</a>';
                    }
        if(isset($_GET['order']) && $_GET['order'] == 'YASC'){
                $content .='<a href="'.get_category_link($category_id) .'?order=YASC" class="current">Jaar (laag - hoog)</a>';
                    }else{
                        $content .='<a href="'.get_category_link($category_id) .'?order=YASC" >Jaar (laag - hoog)</a>';
                    }
//  if(isset($_GET['order']) && $_GET['order'] == 'MDESC'){
//              $content .='<a href="'.get_category_link($category_id) .'?order=MDESC" class="current">Kilometerstand (hoog - laag)</a>';
//                  }else{
//                      $content .='<a href="'.get_category_link($category_id) .'?order=MDESC" >Kilometerstand (hoog - laag)</a>';
//                  }
//      if(isset($_GET['order']) && $_GET['order'] == 'MASC'){
//              $content .='<a href="'.get_category_link($category_id) .'?order=MASC" class="current">Kilometerstand (laag - hoog)</a>';
//                  }else{
//                      $content .='<a href="'.get_category_link($category_id) .'?order=MASC" >Kilometerstand (laag - hoog)</a>';
//                  }
    if(isset($_GET['order']) && $_GET['order'] == 'HDESC'){
                $content .='<a href="'.get_category_link($category_id) .'?order=HDESC" class="current">Uur (hoog - laag)</a>';
                    }else{
                        $content .='<a href="'.get_category_link($category_id) .'?order=HDESC" >Uur (hoog - laag)</a>';
                    }
        if(isset($_GET['order']) && $_GET['order'] == 'HASC'){
                $content .='<a href="'.get_category_link($category_id) .'?order=HASC" class="current">Uur (laag - hoog)</a>';
                    }else{
                        $content .='<a href="'.get_category_link($category_id) .'?order=HASC" >Uur (laag - hoog)</a>';
                    }
    if(isset($_GET['order']) && $_GET['order'] == 'PASC'){
                $content .='<a href="'.get_category_link($category_id) .'?order=PASC" class="current">Prijs (laag - hoog)</a>';
                    }else{
                        $content .='<a href="'.get_category_link($category_id) .'?order=PASC" >Prijs (laag - hoog)</a>';
                    }
    if(isset($_GET['order']) && $_GET['order'] == 'PDESC'){
                $content .='<a href="'.get_category_link($category_id) .'?order=PDESC" class="current">Prijs (hoog - laag)</a>';
                    }else{
                        $content .='<a href="'.get_category_link($category_id) .'?order=PDESC">Prijs (hoog - laag)</a>';
                    }
            $content .='</div>';
        $content .='</div>';
    $content .='</div>';
    return $content;
}

add_shortcode('filter_oderby', 'filter_oderby');

add_action('wp_ajax_get_px_by_ajax1','get_px_by_ajax_callback1');
add_action('wp_ajax_nopriv_get_px_by_ajax1','get_px_by_ajax_callback1');
function get_px_by_ajax_callback1() {
    if(isset($_REQUEST['catid'])){
        $catid = $_REQUEST['catid'];
    }
    if($catid != ""){
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'post_type' => 'product',
                'field' => 'id',
                'terms' => array($catid),
            )
        );
    }
    $query =  new \WP_Query( $args );
        if ($query->have_posts()) : while ($query->have_posts()):$query->the_post();
      $post_id = get_the_ID();
$product = wc_get_product( $post_id );
//var_dump($product);
if (is_product_category('drierolwalsen')) {
    $price = "<a href='/offerte-aanvragen/'>Offerte aanvragen</a>";
} else {
    $price = $product->get_price_html();
}

$image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' );
$totaalgewicht =get_field('totaalgewicht');
$gewicht = explode(" ", $totaalgewicht);

echo '<li>';
echo '<a href="'.get_permalink( $loop1->post->ID ).'">';
echo '<img src="'.$image[0].'"/>';
echo '<div class="box-title-price">';
echo '<p class="title">'.get_the_title().'</p>';
echo '<p class="price ssaas">'.$price.'</p>';
echo '</div>';
echo '<ul class="list-info">';
if( get_field('bouwjaar') ):
    echo '<li>';
    echo '<div class="box-left">Bouwjaar:</div>';
    echo '<div class="box-right">'.get_field('bouwjaar').'</div>';
    echo  '</li>';
endif;
if( get_field('draaiuren') ):
    echo '<li>';
    echo '<div class="box-left">Draaiuren:</div>';
    echo '<div class="box-right">'.get_field('draaiuren').'</div>';
    echo  '</li>';
endif;
if( get_field('voorraad_nummer') ):
    echo '<li>';
    echo '<div class="box-left">Voorraad Nummer: ';
    echo '</div>';
    echo '<div class="box-right">'.get_field('voorraad_nummer');
    echo '</div>';
    echo  '</li>';
endif;
echo  '</ul>';

echo '<p class="link">BEKIJK<i aria-hidden="true" class="fas fa-caret-right"></i></p>';
echo '</a>';
echo '</li>';
        endwhile;
        wp_reset_postdata();
    else :
        echo 'Geen resultaten gevonden';
    endif;
    die();
}
?>

<script type="text/javascript">
    jQuery(document).on('click', '.cat-click', function (e) {
        //alert(1);
        e.preventDefault();
        var ajaxurl = '<?php echo admin_url("admin-ajax.php");?>';
        var id_cat = jQuery(this).data('id');
          jQuery.ajax({
            url: ajaxurl,
            type: 'post',
            data: {
                'action': 'get_px_by_ajax1',
                'catid': id_cat,
                //'check': jQuery(this).prop('checked')
            },
            beforeSend: function(){
                jQuery(".products-listall .products").addClass("loadding");
             },
            success: function(data) {
                // this outputs the results of ajax request
                console.log(data);
                jQuery(".products-listall .products").html(data);
                jQuery(".products-listall .products").removeClass("loadding");
                //alert(keyword);
            },
            error: function(errorThrown) {
                console.log(errorThrown);
            }
        });
    });
</script>

/* GALLERY */
<?php 
function gallery_sfeer(){
    ob_start();
    $content = ob_get_clean();
    $content .='<div class="gallery-sfeer">';
    $content .='<div class="gallery-sfeer-content" id="animated-thumbnails-gallery">';
    $images = get_field('gallery','option');
    foreach ($images as $image):;
    $width = $image['width'];
    $height = $image['height'];
    $img = $image['url'];
    $content .='<div class="gallery-item grid-item" data-lg-size="'.$width.'-'.$height.'" data-src="'.$img.'">';
    $content .='<img src="'.$img.'" alt="">';
    $content .='</div>';
    endforeach;
    $content .= '</div>';
    //$content .= '<div class="button-more"><a href="#">Bekijk meer</a></div>';
    $content .= '</div>';
    return $content;
}
add_shortcode('gallery_sfeer', 'gallery_sfeer');
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/css/lightgallery.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/css/lg-zoom.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/css/lg-thumbnail.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/4.1.4/imagesloaded.min.js" id="imagesloaded-js"></script>
<script src="https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/lightgallery.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/plugins/zoom/lg-zoom.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/plugins/thumbnail/lg-thumbnail.umd.js"></script>

<?php
//AJAX SEARCH

function custom_Formsearch(){
    ob_start();
    $content = ob_get_clean();
    $gif = '/wp-content/uploads/2024/06/Spinner.gif';
    $content .='<div class="custom-form">';
    $content .='<form action="/" method="GET">';
    $content .='<input type="text" placeholder="Search..." value="' . get_search_query() . '" name="s" id="s" />';
    $content .='<button type="submit" id="searchsubmit"><i class="fa fa-search"></i></button>';
    $content .='</form>';
    $content .='<div id="search-container">';
    $content .='<ul id="search-results"></ul>';
    $content .='</div>';
    $content .='</div>';
    return $content;
}
add_shortcode('custom_Formsearch', 'custom_Formsearch');

function ajax_search() {
    $search_query = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
    $args = array(
        'post_type' => 'product',
        's' => $search_query
    );
    
    $query = new WP_Query( $args );
    
    add_filter('posts_where', 'title_filter1', 10, 2);
    function title_filter1( $where, &$wp_query ) {
        global $wpdb;
        if ( $search_term = $wp_query->get( 'title' ) ) {
            $where .= ' AND ' . $wpdb->posts . '.post_title = "' . esc_sql( like_escape( $search_term ) ) . '"';
        }
        return $where;
    }
    
    if( $query->have_posts() ) {
        while( $query->have_posts() ) {
            $query->the_post();
            echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
        }
    } else {
        echo '<li>No results found</li>';
    }
    wp_die();
}

add_action( 'wp_ajax_nopriv_ajax_search', 'ajax_search' );
add_action( 'wp_ajax_ajax_search', 'ajax_search' );

function enqueue_custom_search_script() {
    wp_localize_script( 'ajax-search', 'ajaxsearch', array(
        'ajax_url' => admin_url( 'admin-ajax.php' )
    ));
}

add_action( 'wp_enqueue_scripts', 'enqueue_custom_search_script' );

function hook_Footer(){
    ?>
    <script>
        jQuery(document).ready(function($){
            jQuery('#s').on('input', function() {
                var searchField = jQuery(this).val();
                var ajaxurl = '<?php echo admin_url("admin-ajax.php");?>';
                if (searchField.length >= 1) {
                    jQuery.ajax({
                        type: 'GET',
                        url: ajaxurl,
                        data: {
                            action: 'ajax_search',
                            s: searchField
                        },
                        beforeSend: function(){
                            jQuery("form").addClass("loading");
                        },
                        success: function(data) {
                            jQuery('#search-results').html(data);
                            jQuery('#search-results').addClass('show');
                            jQuery("form").removeClass("loading");
                        }
                    });
                } else {
                    jQuery('#search-results').html('');
                    jQuery('#search-results').removeClass('show');
                }
            });
        });
        jQuery(function($) {
            // Lắng nghe sự kiện 'added_to_cart'
            jQuery(document.body).on('added_to_cart', function() {
                // Chuyển hướng tới trang giỏ hàng
                window.location.href = '<?php echo esc_url( wc_get_cart_url() ); ?>';
            });
        });
    </script>
    <?php
}
add_action( 'wp_footer', 'hook_Footer' );

// jquery tính tour

<script>
    jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div>').insertAfter('.quantity input');
    jQuery('.quantity').each(function() {
        var spinner = jQuery(this),
            input = spinner.find('input[type="number"]'),
            btnUp = spinner.find('.quantity-up'),
            btnDown = spinner.find('.quantity-down'),
            min = input.attr('min'),
            max = input.attr('max');

        btnUp.click(function() {
            var oldValue = parseFloat(input.val());
            if (oldValue >= max) {
                var newVal = oldValue;
            } else {
                var newVal = oldValue + 1;
            }
            spinner.find("input").val(newVal);
            spinner.find("input").trigger("change");
        });

        btnDown.click(function() {
            var oldValue = parseFloat(input.val());
            if (oldValue <= min) {
                var newVal = oldValue;
            } else {
                var newVal = oldValue - 1;
            }
            spinner.find("input").val(newVal);
            spinner.find("input").trigger("change");
        });

    });
    (function ($) {
        jQuery(document).ready(function ($) {
			
			$('.sidebar').on('click', '.box-title-mobi', function () {
				if($('.single-tours .sidebar').hasClass('active')){
					$('.single-tours .sidebar').removeClass('active');
				}else{
					$('.single-tours .sidebar').addClass('active');
				}
			});
	
            number_format = function (number, decimals, dec_point, thousands_sep) {
                number = number.toFixed(decimals);

                var nstr = number.toString();
                nstr += '';
                x = nstr.split('.');
                x1 = x[0];
                x2 = x.length > 1 ? dec_point + x[1] : '';
                var rgx = /(\d+)(\d{3})/;

                while (rgx.test(x1))
                    x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

                return x1 + x2;
            }
            var currency = '$';
            var priceold = 399;
            var off_sale_adult = 5;
            var off_sale_children = 40;
            $('.quantity.adult').on('click', '.quantity-nav .quantity-button', function () {
                var adult = $('.number-people .quantity.adult input').val();
                var pricecorner = priceold * adult;
                var price = priceold * adult;
                if(adult > 2){
                    for(i=3;i <= adult;i++){
                        price = price - off_sale_adult;
                    }
                    var saleoff = pricecorner - price;
                    saleoff = '('+saleoff+''+currency+' OFF)';
                    $('.box-total .box.box-adult label i').css('display','inline-block');
                    $('.box-total .box.box-adult label i').html(saleoff);
                }else{
                    price = priceold * adult;
                    $('.box-total .box.box-adult label i').css('display','none');
                }
                var priceformat = number_format(price, 0, '.', '.');
                var prices = currency+''+priceformat;
                $('.box-total .box.box-adult .price').html(prices);
                $('#totaladult').html(price);
                var totaladult = parseInt($('#totaladult').text());
                var totalchildren = parseInt($('#totalchildren').text());
               // alert(totaladult);
                var total = totaladult + totalchildren;
              //  $('input#total').val(total);
                var totalformat = number_format(total, 0, '.', '.');
                var totals = currency+''+totalformat;
                $('.box-total .box.box-total-submit .price').html(totals);
            });
            $('.quantity.children').on('click', '.quantity-nav .quantity-button', function () {
                var adult = $('.number-people .quantity.children input').val();
                if(adult > 0){
                    var price = priceold - priceold*off_sale_children/100;
                     price = price * adult;
                    $('.box-total .box.box-children').css('display','flex');
                }else{
                    var price = priceold * adult;
                    $('.box-total .box.box-children').css('display','none');
                }
                var priceformat = number_format(price, 0, '.', '.');
                var prices = currency+''+priceformat;
                $('.box-total .box.box-children .price').html(prices);
                $('#totalchildren').html(price);
                var totaladult = parseInt($('#totaladult').text());
                var totalchildren = parseInt($('#totalchildren').text());
                var total = totaladult + totalchildren;
                //$('input#total').val(total);
                var totalformat = number_format(total, 0, '.', '.');
                var totals = currency+''+totalformat;
                $('.box-total .box.box-total-submit .price').html(totals);
            });
        })
    })(jQuery)
</script>

