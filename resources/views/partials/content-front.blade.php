<section class="section section_hero">

    <div class="container">
    
    <div class="left">@field('hero_text')</div>
    <div class="right"><img src="@field('hero_img')" alt=""></div>
    
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
                    <div class="hap">@field('hapi_1')</div>
                </div>
                <div class="hapi hapi2">
                    <div class="count"></div>
                    <div class="hap">@field('hapi_2')</div>
                </div>
                <div class="hapi hapi3">
                    <div class="count"></div>
                    <div class="hap">@field('hapi_3')</div>
                </div>
    
        </div>
    </section>
    <section class="section section_form">
    
    <div class="container">
    
        <?php if (function_exists('user_submitted_posts')) user_submitted_posts(); ?>
        <label style="display: none;" for="user-submitted-image[]">Click me to upload image</label>
    
    </div>
        
</section>