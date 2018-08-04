<?php 

/*
* Template Name: Frontend Posts
*/

get_header(); ?>

<div id="icos"> 

  <div class="container-fluid px-5 py-3">
      <div class="row ">

        <div class="col">
            <h2 class="p-0 m-0"><?php the_title(); ?></h2>
        </div>

        <div class="col-3 align-middle vertical-align">
            <input type="search" class="search form-control" placeholder="Search" />
        </div>

      </div>
   
  </div>

  <div class="container-fluid px-5 py-1 " >

    <ul class="list">

    <?php 
      $args = array(
        'posts_per_page' => -1,
        'post_type'   => 'post',
        'post_status' => 'publish',
        'cat' => 2,
      );
      $the_query = new WP_Query( $args );
    ?>
    <?php if($the_query->have_posts()): ?>
    <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>

      <li>

        <div class="row parentRow my-1 rounded parent<?php echo get_the_ID(); ?> " >

          <div class="col">

            <div class="row icoHeadline bg-grey py-2 rounded ">

              <div class="col-3 vertical-align">
                   
                <?php if(get_field('ico_avatar')): ?>
                  <img class="avatar shadow-sm rounded" src="<?php echo the_field('ico_avatar'); ?>" alt="" > 
                <?php endif; ?>
                   
                <h5 class="p-0 m-0 name" ><a href="<?php echo get_permalink(); ?>" target="_blank"><?php the_title(); ?></a></h5>

              </div>

              <div class="col-2 vertical-align green">

                  <?php 
                    if(get_field('final-score')) {
                      the_field('final-score');
                    } else {
                      echo '0%';
                    } 
                  ?>

              </div>
   
              <div class="col align-middle text-right">

                  <?php 
                    $nonce = wp_create_nonce('save_fields_' . get_the_ID());
                    echo '<button class="btnSave btnSave'.get_the_ID().' btn btn-success d-none" data-nonce="'.$nonce.'" data-post_id="'.get_the_ID().'"><i class="fas fa-save"></i></button>';
                  ?>

                  <?php 
                    $nonce = wp_create_nonce('load_fields_' . get_the_ID());
                    echo '<button class="btnEdit btn btn-secondary" id="parent'.get_the_ID().'" data-nonce="'.$nonce.'" data-post_id="'.get_the_ID().'"><i class="fas fa-pencil-alt"></i></button>';
                  ?>

              </div>

            </div>

            <div class="row icoDetails icoDetails<?php echo get_the_ID(); ?> load_output<?php echo get_the_ID(); ?>">
            </div>

          </div>

        </div>

      </li>

    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
    <?php endif; ?> 

    </ul>

  </div>

</div>

<br>

<?php get_footer(); ?>
