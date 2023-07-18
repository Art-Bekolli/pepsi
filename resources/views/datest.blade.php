{{--
  Template Name: datesttemlpate
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.page-header')
    @include('partials.content-page')
  @endwhile
@endsection

@php 
    echo 'brothaaa';
    $post     = get_post($post_id);
        //$post_url = get_permalink( $post_id );
        $post_title = get_the_title( $post_id ); 
        $author   = get_userdata($post->post_author);
        $subject  = 'Urime, keni hyr ne loje shperblyese!';
        $message  = "Kuponi juaj: ".$post_title." eshte hyrur ne loje.";


        //wp_mail('robertbpira@gmail.com', $subject, $message );  
@endphp
<?php

var_dump(get_post_meta(89, "name_custom_field"));
    if(isset($_POST['upload']))
    {
      echo 'isset';
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
        echo 'isntempty';
        $my_post = array(
          'ID' => $postId,
        'post_title'    => $_POST['qyteti'],
        'post_content'  => 'post content',
        'post_status'   => 'pending'
      );
      echo 'this is file: ';
          var_dump($file);
          echo ', this is file2: ';
          var_dump($file2);
          echo '<br>';
          wp_update_post($my_post);
          $attachment_id = upload_user_file( $file2 );
          var_dump($attachment_id);
          var_dump($my_post);
        
        echo 'created';
        set_post_thumbnail($postId, $attachment_id);
        echo 'ID: IS: '.$postId;
        add_post_meta($postId, "email_custom_field", $_POST['email'],true);
        add_post_meta($postId, "num_custom_field", $_POST['numriitelefonit'],true);
        add_post_meta($postId, "user_submit_name", $_POST['qyteti'],true);
        
        var_dump(get_post_meta($postId, "num_custom_field"));
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

<form action="" method="post" enctype="multipart/form-data">
  <input type="text" name="emridhembiemri">
  <input type="text" name="qyteti">
  <input type="text" name="email">
  <input type="text" name="numriitelefonit">
    <input type="file" name="file">
    <input type="submit" name="upload">
</form>