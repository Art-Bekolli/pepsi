
<?php

    if(isset($_POST['upload']))
    {

       if( ! empty( $_FILES ) ) 
       {
        $new_post = array(
          'post_title' => 'Draft title', 
          'post_status'   => 'draft'
      );
      $postId = wp_insert_post($new_post);

     $file=$_POST['file'];
        $file2=$_FILES['file'];
        $qyteti = $_POST['qyteti'];
        $emri = $_POST['emridhembiemri'];

        $my_post = array(
          'ID' => $postId,
        'post_title'    => $_POST['qyteti'],
        'post_content'  => 'post content',
        'post_status'   => 'pending'
      );

          wp_update_post($my_post);
          $attachment_id = upload_user_file( $file2 );
 
        

        set_post_thumbnail($postId, $attachment_id);

        add_post_meta($postId, "email_custom_field", $_POST['email'],true);
        add_post_meta($postId, "num_custom_field", $_POST['numriitelefonit'],true);
        add_post_meta($postId, "user_submit_name", $_POST['qyteti'],true);
        
        echo "Sukses! Informatat jane derguar dhe do te kontrollohen nga ne.";
       }
    }










    function upload_user_file( $file = array() ) {

require_once( ABSPATH . 'wp-admin/includes/admin.php' );

  $file_return = wp_handle_upload( $file, array('test_form' => false ) );

  if( isset( $file_return['error'] ) || isset( $file_return['upload_error_handler'] ) ) {
    return false;
  } else {

    $filename = $file_return['file'];

    $attachment = array(
      'post_mime_type' => $file_return['type'],
      'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
      'post_content' => '',
      'post_status' => 'inherit',
      'guid' => $file_return['url']
    );

    $attachment_id = wp_insert_attachment( $attachment, $file_return['url'] );

    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
    wp_update_attachment_metadata( $attachment_id, $attachment_data );

    if( 0 < intval( $attachment_id ) ) {
    return $attachment_id;
    }
  }

  return false;
}
    ?>

<!-- <section class="section section_hero">

    <div class="container">
    <img class="desktop_img" src="@field('banner_img')">
    <img class="mobile_img" src="@field('banner_img_mobile')">
    <div class="left">@field('hero_text')</div>
 <div class="right"><img src="@field('banner_img')" alt=""></div>
    
    </div>
    
    </section>
    <section class="section section_date">
    
        <div class="container">
            @field('date_text')
        </div>
    
    </section>
    <section class="section section_hapat">
        <div class="container">
    
                <div class="hapi hapi1">
                    <div class="count"></div>
                    <div class="hap">@field('hapi1')</div>
                </div>
                <div class="hapi hapi2">
                    <div class="count"></div>
                    <div class="hap">@field('hapi2')</div>
                </div>
                <div class="hapi hapi3">
                    <div class="count"></div>
                    <div class="hap">@field('hapi3')</div>
                </div>
    
        </div>
    </section>
-->
    <section class="section section_form">
        <img class="desktop_img" src="@field('hero_img')">
        <img class="mobile_img" src="@field('hero_img_mobile')">
    <div class="container">
        
        <form action="" method="post" enctype="multipart/form-data">
            <fieldset>
                <input type="text" name="emridhembiemri" placeholder="Emri dhe Mbiemri">
            </fieldset>
            <fieldset>
                <input type="text" name="qyteti" placeholder="Qyteti">
            </fieldset>
            <fieldset>
                <input type="text" name="email" placeholder="Email">
            </fieldset>
            <fieldset>
                <input type="text" name="numriitelefonit" placeholder="Numri i Telefonit">
            </fieldset>
            <fieldset class="usp-images">
                <div id="user-submitted-image">
              <input type="file" name="file" id="file">
              <label for="file">Ngarko</label>
            </div>
            <div id="usp-upload-message">Foto e kuponit fiskal</div>
            </fieldset>
              <input type="submit" name="upload" class="field-submit" value="Bëhu pjesë e lojës">
          </form>
        <label style="display: none;" for="user-submitted-image[]">Click me to upload image</label>
    
    </div>
        
</section>