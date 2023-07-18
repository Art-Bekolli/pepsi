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

<form action="<?php echo get_stylesheet_directory_uri() ?>/views/imageupload.php" method="post" enctype="multipart/form-data">
	Your Photo: <input type="file" name="profile_picture" />
	<input type="submit" name="submit" value="Submit" />
</form>