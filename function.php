<?php
function theme_enqueue_styles() {
    wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/custom.css', [] );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', 20 );

//  add script and html on footer 
function member_modle_popup(){ ?>
  <script>
      jQuery(document).ready(function(){          
            jQuery(".link-members a").click(function(e){
            e.preventDefault();
            let post_url=jQuery(this).attr("href");       
            document.cookie = "post_id="+jQuery(this).attr("href");
            jQuery.ajax({
              type: "post",
              dataType: "html",
              url: "<?php echo admin_url('admin-ajax.php'); ?>",
              data : { action: "get_data",post_url: post_url },
              success: function(msg){
                  jQuery('#popup_content').html(msg);
                  jQuery('.modal').toggleClass('is-visible');
              }
          });

            
          });
            jQuery('.modal-overlay ,.modal-close').click(function(){
               jQuery('.modal').removeClass('is-visible');
            })
        
      })

  </script>

<div class="modal">
   <div class="modal-overlay "></div>
   <div class="modal-wrapper modal-transition">
         <a href="javascript:void(0)" class="modal-close "><span class="bar1"></span><span class="bar2"></span></a>
      <div class="modal-body" id="popup_content"></div></div></div>

<?php
};
add_action('wp_footer', 'member_modle_popup');
// wordpress ajax to get data by post url
function get_data_by_url() {
        
        if(isset($_POST['post_url']) && !empty($_POST['post_url'])){

             $url=explode("#",$_POST['post_url']);
             $postid = url_to_postid( $url[1] );
             $featured_img_url = get_the_post_thumbnail_url($postid,'full'); 
             $post= get_post($postid);
             $content = $post->post_content;


             $content='<div class="member_item"><div class="member_left"><figure><img src="'.$featured_img_url.'"></figure><h3>'.get_the_title($postid).'</h3>
               <h4>President</h4></div><div class="member_right"><p>'.$content.'</p></div><div class="member_bottom"><ul><li class="popup_phone">
                  <figure><img src="'.site_url().'/wp-content/uploads/2022/11/popup-call-icon.svg" alt=""></figure><figcaption><span>Phone</span><a href="tel:0000000000">(000) 000 0000</a></figcaption></li><li class="popup_mail"><figure> <img src="'.site_url().'/wp-content/uploads/2022/11/popup_mail_icon.svg" alt="">  </figure><figcaption>  <span>Email</span><a href="mailto:info@dummyemail.com">info@dummyemail.com</a></figcaption></li><li class="popup_address"><figure>  <img src="'.site_url().'/wp-content/uploads/2022/11/popup_fb_link_icon.svg" alt=""></figure><figcaption>  <span>Facebook</span><a href="www.facebook.com/Jack Williamson">www.facebook.com/Jack Williamson</a></figcaption></li></ul></div></div>';
              echo $content;die;

        }
       
    }

add_action( 'wp_ajax_nopriv_get_data', 'get_data_by_url' );
add_action( 'wp_ajax_get_data', 'get_data_by_url' );