<?php

// 728x90 Advertisement Widget
class envince_728x90_advertisement_widget extends WP_Widget {

	function __construct() {
		$widget_ops  = array(
			'classname'   => 'widget_728x90_advertisement',
			'description' => __( 'Add your Advertisement here', 'envince' )
		);

		$control_ops = array(
			'width'  => 200,
			'height' => 250
		);

		parent::__construct( false, $name = __( 'TG: Advertisement', 'envince' ), $widget_ops);
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance,
			array(
				'title'             => '',
				'728x90_image_url'  => '',
				'728x90_image_link' => ''
			)
		);

		$title      = esc_attr( $instance[ 'title' ] );
		$image_link = '728x90_image_link';
		$image_url  = '728x90_image_url';

		$instance[ $image_link ] = esc_url( $instance[ $image_link ] );
		$instance[ $image_url ]  = esc_url( $instance[ $image_url ] );

		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'envince' ); ?></label>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<label><?php _e( 'Add your Advertisement 728x90 Images Here', 'envince' ); ?></label>
		<p>
			<label for="<?php echo $this->get_field_id( $image_link ); ?>"> <?php _e( 'Advertisement Image Link ', 'envince' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( $image_link ); ?>" name="<?php echo $this->get_field_name( $image_link ); ?>" value="<?php echo $instance[$image_link]; ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( $image_url ); ?>"> <?php _e( 'Advertisement Image ', 'envince' ); ?></label>

			 <div class="media-uploader" id="<?php echo $this->get_field_id( $image_url ); ?>">
				<div class="custom_media_preview">
				   <?php if ( $instance[ $image_url ] != '' ) : ?>
					  <img class="custom_media_preview_default" src="<?php echo esc_url( $instance[ $image_url ] ); ?>" style="max-width:100%;" />
				   <?php endif; ?>
				</div>
				<input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( $image_url ); ?>" name="<?php echo $this->get_field_name( $image_url ); ?>" value="<?php echo esc_url( $instance[$image_url] ); ?>" style="margin-top:5px;" />
				<button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( $image_url ); ?>" data-choose="<?php esc_attr_e( 'Choose an image', 'envince' ); ?>" data-update="<?php esc_attr_e( 'Use image', 'envince' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php esc_html_e( 'Select an Image', 'envince' ); ?></button>
			 </div>
		</p>

	<?php }
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
		$image_link          = '728x90_image_link';
		$image_url           = '728x90_image_url';

		$instance[ $image_link ] = esc_url_raw( $new_instance[ $image_link ] );
		$instance[ $image_url ]  = esc_url_raw( $new_instance[ $image_url ] );

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		$title = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';

		$image_link = '728x90_image_link';
		$image_url  = '728x90_image_url';

		$image_link = isset( $instance[ $image_link ] ) ? $instance[ $image_link ] : '';
		$image_url  = isset( $instance[ $image_url ] ) ? $instance[ $image_url ] : '';

		echo $before_widget; ?>

		<div class="advertisement_728x90">
		<?php if ( !empty( $title ) ) { ?>
			<div class="advertisement-title">
				<?php echo $before_title. esc_html( $title ) . $after_title; ?>
			</div>
		<?php }
		$output = '';
		if ( !empty( $image_url ) ) {
			$output .= '<div class="advertisement-content">';
			if ( !empty( $image_link ) ) {
				$output .= '<a href="'.$image_link.'" class="single_ad_728x90" target="_blank">
								<img src="'.$image_url.'" />
							</a>';
			} else {
				$output .= '<img src="'.$image_url.'" />';
			}
			$output .= '</div>';
			echo $output;
		}
		?>
		</div>
		<?php
		echo $after_widget;
	}
}

class envince_featured_posts_slider_widget extends WP_Widget {

	function __construct() {
		$widget_ops  = array(
			'classname'   => 'widget_featured_post_slider',
			'description' => __( 'Display latest posts or posts of specific category, which will be used as the slider.', 'envince' )
		);
		$control_ops = array(
			'width'  => 200,
			'height' => 250
		);
		parent::__construct( false,$name= __( 'TG: Featured Post Slider', 'envince' ),$widget_ops);
   }

	function form( $instance ) {
		$envince_defaults['number']     = 5;
		$envince_defaults['type']       = 'latest';
		$envince_defaults['category']   = '';
		$envince_defaults['child_category'] = '0';
		$instance                       = wp_parse_args( (array) $instance, $envince_defaults );
		$number                         = $instance['number'];
		$type                           = $instance['type'];
		$category                       = $instance['category'];
		$child_category 				= $instance[ 'child_category' ] ? 'checked="checked"' : '';
	?>
	<p>
		<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e( 'Number of posts to display:', 'envince' ); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
	</p>

	<p>
		<input type="radio" <?php checked($type, 'latest') ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="latest"/><?php _e( 'Show latest Posts', 'envince' );?><br />
		<input type="radio" <?php checked($type,'category') ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="category"/><?php _e( 'Show posts from a category', 'envince' );?><br />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Select category', 'envince' ); ?>:</label>
		<?php wp_dropdown_categories( array(
										'show_option_none' =>' ',
										'name' => $this->get_field_name( 'category' ),
										'selected' => $category
									)
			);
		?>
	</p>

	<p>
		<input class="checkbox" <?php echo $child_category; ?> id="<?php echo $this->get_field_id( 'child_category' ); ?>" name="<?php echo $this->get_field_name( 'child_category' ); ?>" type="checkbox" />
		<label for="<?php echo $this->get_field_id('child_category'); ?>"><?php esc_html_e( 'Check to display the posts from child category of the chosen category.', 'envince' ); ?></label>
	</p>
	<?php

	}

	function update( $new_instance, $old_instance ) {
		$instance               = $old_instance;
		$instance[ 'number' ]   = absint( $new_instance[ 'number' ] );
		$instance[ 'type' ]     = $new_instance[ 'type' ];
		$instance[ 'category' ] = $new_instance[ 'category' ];
		$instance[ 'child_category' ] = isset( $new_instance[ 'child_category' ] ) ? 1 : 0;

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$number   = empty( $instance[ 'number' ] ) ? 4 : $instance[ 'number' ];
		$type     = isset( $instance[ 'type' ] ) ? $instance[ 'type' ] : 'latest' ;
		$category = isset( $instance[ 'category' ] ) ? $instance[ 'category' ] : '';
		$child_category = !empty( $instance[ 'child_category' ] ) ? 'true' : 'false';

		if( $type == 'latest' ) {
			$get_featured_posts = new WP_Query(
				array(
					'posts_per_page'        => $number,
					'post_type'             => 'post',
					'ignore_sticky_posts'   => true,
					'no_found_rows'         => true
				)
			);
		} else {
			if ( $child_category == 'true' ) {
				$get_featured_posts = new WP_Query( array(
					'posts_per_page'        => $number,
		            'post_type'             => 'post',
		            'cat'          			=> $category,
		            'no_found_rows'         => true
				) );
			} else {
				$get_featured_posts = new WP_Query( array(
					'posts_per_page'        => $number,
		            'post_type'             => 'post',
		            'category__in'          => $category,
		            'no_found_rows'         => true
				) );
			}
		}
		echo $before_widget;
		?>
		<div class="envince-featured-post-slider clearfix">
			<div class="envince-slider-inner-wrapper">
				<?php
				$slide_counter = 0;
				while( $get_featured_posts->have_posts() ):$get_featured_posts->the_post();
				$slide_counter++;
				if( $slide_counter%5 == 1 ){
				?>
				<div class="single-section">
					<div class="big-grid-post col-md-6 col-xs-12">
						<article <?php hybrid_attr( 'post' ); ?>>
							<header class="post-header">
							<?php
								if( has_post_thumbnail() ) {
									$image            = '';
									$title_attribute  = get_the_title( $post->ID );
									$image           .= '<figure class="slider-featured-image">';
									$image           .= '<a href="' . esc_url( get_permalink() ) . '" title="'.the_title( '', '', false ).'">';
									$image           .= get_the_post_thumbnail( $post->ID, 'envince-big-grid', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ) ) ).'</a>';
									$image           .= '</figure>';
									echo $image;
									} else { ?>
										<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
											<img src="<?php echo get_template_directory_uri(); ?>/images/slider-featured-image.png">
										</a>
									<?php }
							?>
							<?php envince_colored_category(); ?>
							<?php the_title( '<h2 ' . hybrid_get_attr( 'entry-title' ) . '><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
							</header>
						</article>
					</div>
					<?php }
					else {
						if( $slide_counter%5 == 2 ) {
							echo '<div class="small-grid-wrapper col-md-6 col-xs-12">';
						}
					?>
					<div class="small-grid-post col-md-6 col-xs-6">
						<article <?php hybrid_attr( 'post' ); ?>>
							<header class="post-header">
								<?php
									if( has_post_thumbnail() ) {
										$image            = '';
										$title_attribute  = get_the_title( $post->ID );
										$image           .= '<figure class="slider-featured-image">';
										$image           .= '<a href="' . esc_url( get_permalink() ) . '" title="'.the_title( '', '', false ).'">';
										$image           .= get_the_post_thumbnail( $post->ID, 'envince-small-grid', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ) ) ).'</a>';
										$image           .= '</figure>';
											echo $image;
										} else { ?>
											<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
												<img src="<?php echo get_template_directory_uri(); ?>/images/slider-featured-image.png">
											</a>
										<?php }
								?>
								<?php envince_colored_category(); ?>
								<?php the_title( '<h2 ' . hybrid_get_attr( 'entry-title' ) . '><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
							</header>
						</article>
					</div>
					<?php
						if ( $slide_counter%5 == 0 ) {
							echo "</div>";
						} // wrapper for small grid
					}
					if( $slide_counter%5 == 0 ) { ?>
				</div>
				<?php
				}
				endwhile;
				// Reset Post Data
				wp_reset_query();
				?>
			</div>
		</div>
		<?php echo $after_widget;
	}
}
// 2 Column Featured Post Widget
class envince_twocol_posts extends WP_Widget {

	function __construct() {
		$widget_ops  = array(
			'classname'   => 'widget_envince_color widget_featured_posts widget_twocol_posts',
			'description' => __( 'Display latest posts or posts of specific category in two column layout.', 'envince')
		);

		$control_ops = array(
			'width'  => 200,
			'height' => 250
		);

		parent::__construct( false,$name= __( 'TG: Two Column Featured Post Widget', 'envince' ),$widget_ops);
   }

	function form( $instance ) {
		$envince_defaults['title']    = '';
		$envince_defaults['text']     = '';
		$envince_defaults['number']   = 4;
		$envince_defaults['type']     = 'latest';
		$envince_defaults['category'] = '';
		$envince_defaults['child_category'] = '0';

		$instance = wp_parse_args( (array) $instance, $envince_defaults );
		$title    = esc_attr( $instance[ 'title' ] );
		$text     = esc_textarea($instance['text']);
		$number   = $instance['number'];
		$type     = $instance['type'];
		$category = $instance['category'];
		$child_category 				= $instance[ 'child_category' ] ? 'checked="checked"' : '';
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'envince' ); ?></label>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<?php _e( 'Description','envince' ); ?>
		<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e( 'Number of posts to display:', 'envince' ); ?></label>
			<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
		</p>

		<p>
			<input type="radio" <?php checked($type, 'latest') ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="latest"/><?php _e( 'Show latest Posts', 'envince' );?><br />
			<input type="radio" <?php checked($type,'category') ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="category"/><?php _e( 'Show posts from a category', 'envince' );?><br />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Select category', 'envince' ); ?>:</label>
			<?php wp_dropdown_categories( array( 'show_option_none' =>' ','name' => $this->get_field_name( 'category' ), 'selected' => $category ) ); ?>
		</p>

		<p>
			<input class="checkbox" <?php echo $child_category; ?> id="<?php echo $this->get_field_id( 'child_category' ); ?>" name="<?php echo $this->get_field_name( 'child_category' ); ?>" type="checkbox" />
			<label for="<?php echo $this->get_field_id('child_category'); ?>"><?php esc_html_e( 'Check to display the posts from child category of the chosen category.', 'envince' ); ?></label>
		</p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );

		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) );

		$instance[ 'number' ]   = absint( $new_instance[ 'number' ] );
		$instance[ 'type' ]     = $new_instance[ 'type' ];
		$instance[ 'category' ] = $new_instance[ 'category' ];
		$instance[ 'child_category' ] = isset( $new_instance[ 'child_category' ] ) ? 1 : 0;

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$title    = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
		$text     = isset( $instance[ 'text' ] ) ? $instance[ 'text' ] : '';
		$number   = empty( $instance[ 'number' ] ) ? 4 : $instance[ 'number' ];
		$type     = isset( $instance[ 'type' ] ) ? $instance[ 'type' ] : 'latest' ;
		$category = isset( $instance[ 'category' ] ) ? $instance[ 'category' ] : '';
		$child_category = !empty( $instance[ 'child_category' ] ) ? 'true' : 'false';

		if( $type == 'latest' ) {
			$get_featured_posts = new WP_Query(
				array(
				'posts_per_page'        => $number,
				'post_type'             => 'post',
				'ignore_sticky_posts'   => true
				)
			);
		}
		else {
			if ( $child_category == 'true' ) {
				$get_featured_posts = new WP_Query( array(
					'posts_per_page'        => $number,
		            'post_type'             => 'post',
		            'cat'          			=> $category,
		            'no_found_rows'         => true
				) );
			} else {
				$get_featured_posts = new WP_Query( array(
					'posts_per_page'        => $number,
		            'post_type'             => 'post',
		            'category__in'          => $category,
		            'no_found_rows'         => true
				) );
			}
		}
		echo $before_widget;
		?>

		<?php
		if ( $type != 'latest' ) {
			$border_color = 'style="border-bottom-color:' . envince_category_color( $category ) . ';"';
			$title_color = 'style="background:' . envince_category_color( $category ) . ';"';
		} else {
			$border_color = '';
			$title_color = '';
		}
		if ( !empty( $title ) ) { echo '<h3 class="widget-title" '. $border_color .'><span class="wrap"' . $title_color .'>'. esc_html( $title ) .'</span></h3>'; }
		if( !empty( $text ) ) { ?> <p> <?php echo esc_textarea( $text ); ?> </p> <?php } ?>
		<?php
		$i=1;
		while( $get_featured_posts->have_posts() ):$get_featured_posts->the_post();
		?>

		<?php if( $i == 1 ) { $featured = 'envince-featured-big'; } else { $featured = 'envince-featured-small'; } ?>
		<?php if( $i == 1 ) { echo '<div class="first-post col-md-6">'; } elseif ( $i == 2 ) { echo '<div class="following-post col-md-6">'; } ?>
			<div class="single-article clearfix">
				<?php
				if( has_post_thumbnail() ) {
					$image = '';
					$title_attribute = get_the_title( $post->ID );
					$image .= '<figure>';
					$image .= '<a href="' . esc_url( get_permalink() ) . '" title="'.the_title( '', '', false ).'">';
					$image .= get_the_post_thumbnail( $post->ID, $featured, array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ) ) ).'</a>';
					$image .= '</figure>';
					echo $image;
				}
				?>
				<div class="article-content">
					<h3 class="entry-title">
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php the_title(); ?></a>
					</h3>
					<div class="entry-byline">
						<i class="fa fa-calendar"></i>
						<time <?php hybrid_attr( 'entry-published' ); ?>><?php echo get_the_date(); ?></time>
						<i class="fa fa-comment-o"></i>
						<?php comments_popup_link( number_format_i18n( 0 ), number_format_i18n( 1 ), '%', 'comments-link', '' ); ?>
					</div><!-- .entry-byline -->
					<?php if( $i == 1 ) { ?>
						<div class="entry-content">
							<?php the_excerpt(); ?>
					 	</div>
					<?php } ?>
				</div>

			</div>
			<?php if( $i == 1 ) { echo '</div>'; } ?>
			<?php
			$i++;
			endwhile;
			if ( $i > 2 ) { echo '</div>'; }
			// Reset Post Data
			wp_reset_query();
			?>
		<?php echo $after_widget;
	}
}

// 1 Column Featured Post Widget
class envince_onecol_posts extends WP_Widget {

	function __construct() {
		$widget_ops  = array(
			'classname'   => 'widget_envince_color widget_featured_posts widget_onecol_posts',
			'description' => __( 'Display latest posts or posts of specific category in one column layout.', 'envince')
		);

		$control_ops = array(
			'width'  => 200,
			'height' => 250
		);

		parent::__construct( false,$name= __( 'TG: One Column Featured Post Widget', 'envince' ),$widget_ops);
   }

	function form( $instance ) {
		$envince_defaults['title']    = '';
		$envince_defaults['text']     = '';
		$envince_defaults['number']   = 4;
		$envince_defaults['type']     = 'latest';
		$envince_defaults['category'] = '';
		$envince_defaults['child_category'] = '0';

		$instance = wp_parse_args( (array) $instance, $envince_defaults );
		$title    = esc_attr( $instance[ 'title' ] );
		$text     = esc_textarea($instance['text']);
		$number   = $instance['number'];
		$type     = $instance['type'];
		$category = $instance['category'];
		$child_category 				= $instance[ 'child_category' ] ? 'checked="checked"' : '';
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'envince' ); ?></label>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<?php _e( 'Description','envince' ); ?>
		<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e( 'Number of posts to display:', 'envince' ); ?></label>
			<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
		</p>

		<p>
			<input type="radio" <?php checked($type, 'latest') ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="latest"/><?php _e( 'Show latest Posts', 'envince' );?><br />
			<input type="radio" <?php checked($type,'category') ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="category"/><?php _e( 'Show posts from a category', 'envince' );?><br />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Select category', 'envince' ); ?>:</label>
			<?php wp_dropdown_categories( array( 'show_option_none' =>' ','name' => $this->get_field_name( 'category' ), 'selected' => $category ) ); ?>
		</p>

		<p>
			<input class="checkbox" <?php echo $child_category; ?> id="<?php echo $this->get_field_id( 'child_category' ); ?>" name="<?php echo $this->get_field_name( 'child_category' ); ?>" type="checkbox" />
			<label for="<?php echo $this->get_field_id('child_category'); ?>"><?php esc_html_e( 'Check to display the posts from child category of the chosen category.', 'envince' ); ?></label>
		</p>

		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );

		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) );

		$instance[ 'number' ]   = absint( $new_instance[ 'number' ] );
		$instance[ 'type' ]     = $new_instance[ 'type' ];
		$instance[ 'category' ] = $new_instance[ 'category' ];
		$instance[ 'child_category' ] = isset( $new_instance[ 'child_category' ] ) ? 1 : 0;

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$title    = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
		$text     = isset( $instance[ 'text' ] ) ? $instance[ 'text' ] : '';
		$number   = empty( $instance[ 'number' ] ) ? 4 : $instance[ 'number' ];
		$type     = isset( $instance[ 'type' ] ) ? $instance[ 'type' ] : 'latest' ;
		$category = isset( $instance[ 'category' ] ) ? $instance[ 'category' ] : '';
		$child_category = !empty( $instance[ 'child_category' ] ) ? 'true' : 'false';

		if( $type == 'latest' ) {
			$get_featured_posts = new WP_Query(
				array(
				'posts_per_page'        => $number,
				'post_type'             => 'post',
				'ignore_sticky_posts'   => true
				)
			);
		}
		else {
			if ( $child_category == 'true' ) {
				$get_featured_posts = new WP_Query( array(
					'posts_per_page'        => $number,
		            'post_type'             => 'post',
		            'cat'          			=> $category,
		            'no_found_rows'         => true
				) );
			} else {
				$get_featured_posts = new WP_Query( array(
					'posts_per_page'        => $number,
		            'post_type'             => 'post',
		            'category__in'          => $category,
		            'no_found_rows'         => true
				) );
			}
		}
		echo $before_widget;
		?>

		<?php
		if ( $type != 'latest' ) {
			$border_color = 'style="border-bottom-color:' . envince_category_color( $category ) . ';"';
			$title_color = 'style="background:' . envince_category_color( $category ) . ';"';
		} else {
			$border_color = '';
			$title_color = '';
		}
		if ( !empty( $title ) ) { echo '<h3 class="widget-title" '. $border_color .'><span class="wrap"' . $title_color .'>'. esc_html( $title ) .'</span></h3>'; }
		if( !empty( $text ) ) { ?> <p> <?php echo esc_textarea( $text ); ?> </p> <?php } ?>
		<?php
		$i=1;
		while( $get_featured_posts->have_posts() ):$get_featured_posts->the_post();
		?>

		<?php if( $i == 1 ) { $featured = 'envince-featured-big'; } else { $featured = 'envince-featured-small'; } ?>
		<?php if( $i == 1 ) { echo '<div class="first-post">'; } elseif ( $i == 2 ) { echo '<div class="following-post">'; } ?>
			<div class="single-article clearfix">
				<?php
				if( has_post_thumbnail() ) {
					$image = '';
					$title_attribute = get_the_title( $post->ID );
					$image .= '<figure>';
					$image .= '<a href="' . esc_url( get_permalink() ) . '" title="'.the_title( '', '', false ).'">';
					$image .= get_the_post_thumbnail( $post->ID, $featured, array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ) ) ).'</a>';
					$image .= '</figure>';
					echo $image;
				}
				?>
				<div class="article-content">
					<h3 class="entry-title">
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php the_title(); ?></a>
					</h3>
					<div class="entry-byline">
						<i class="fa fa-calendar"></i>
						<time <?php hybrid_attr( 'entry-published' ); ?>><?php echo get_the_date(); ?></time>
						<i class="fa fa-comment-o"></i>
						<?php comments_popup_link( number_format_i18n( 0 ), number_format_i18n( 1 ), '%', 'comments-link', '' ); ?>
					</div><!-- .entry-byline -->
					<?php if( $i == 1 ) { ?>
						<div class="entry-content">
							<?php the_excerpt(); ?>
					 	</div>
					<?php } ?>
				</div>

			</div>
			<?php if( $i == 1 ) { echo '</div>'; } ?>
			<?php
			$i++;
			endwhile;
			if ( $i > 2 ) { echo '</div>'; }
			// Reset Post Data
			wp_reset_query();
			?>
		<?php echo $after_widget;
	}
}

// Image Grid Widget
class envince_imagegrid_posts extends WP_Widget {

	function __construct() {
		$widget_ops  = array(
			'classname'   => 'widget_envince_color widget_featured_posts widget_imagegrid_posts',
			'description' => __( 'Display latest posts or posts of specific category in image grid.', 'envince')
		);

		$control_ops = array(
			'width'  => 200,
			'height' => 250
		);

		parent::__construct( false,$name= __( 'TG: Image Grid Post Widget', 'envince' ),$widget_ops);
   }

	function form( $instance ) {
		$envince_defaults['title']    = '';
		$envince_defaults['text']     = '';
		$envince_defaults['number']   = 4;
		$envince_defaults['type']     = 'latest';
		$envince_defaults['category'] = '';
		$envince_defaults['child_category'] = '0';

		$instance = wp_parse_args( (array) $instance, $envince_defaults );
		$title    = esc_attr( $instance[ 'title' ] );
		$text     = esc_textarea($instance['text']);
		$number   = $instance['number'];
		$type     = $instance['type'];
		$category = $instance['category'];
		$child_category 				= $instance[ 'child_category' ] ? 'checked="checked"' : '';
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'envince' ); ?></label>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<?php _e( 'Description','envince' ); ?>
		<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e( 'Number of posts to display:', 'envince' ); ?></label>
			<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
		</p>

		<p>
			<input type="radio" <?php checked($type, 'latest') ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="latest"/><?php _e( 'Show latest Posts', 'envince' );?><br />
			<input type="radio" <?php checked($type,'category') ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="category"/><?php _e( 'Show posts from a category', 'envince' );?><br />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Select category', 'envince' ); ?>:</label>
			<?php wp_dropdown_categories( array( 'show_option_none' =>' ','name' => $this->get_field_name( 'category' ), 'selected' => $category ) ); ?>
		</p>

		<p>
			<input class="checkbox" <?php echo $child_category; ?> id="<?php echo $this->get_field_id( 'child_category' ); ?>" name="<?php echo $this->get_field_name( 'child_category' ); ?>" type="checkbox" />
			<label for="<?php echo $this->get_field_id('child_category'); ?>"><?php esc_html_e( 'Check to display the posts from child category of the chosen category.', 'envince' ); ?></label>
		</p>

		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );

		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) );

		$instance[ 'number' ]   = absint( $new_instance[ 'number' ] );
		$instance[ 'type' ]     = $new_instance[ 'type' ];
		$instance[ 'category' ] = $new_instance[ 'category' ];
		$instance[ 'child_category' ] = isset( $new_instance[ 'child_category' ] ) ? 1 : 0;

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$title    = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
		$text     = isset( $instance[ 'text' ] ) ? $instance[ 'text' ] : '';
		$number   = empty( $instance[ 'number' ] ) ? 4 : $instance[ 'number' ];
		$type     = isset( $instance[ 'type' ] ) ? $instance[ 'type' ] : 'latest' ;
		$category = isset( $instance[ 'category' ] ) ? $instance[ 'category' ] : '';
		$child_category = !empty( $instance[ 'child_category' ] ) ? 'true' : 'false';

		if( $type == 'latest' ) {
			$get_featured_posts = new WP_Query(
				array(
				'posts_per_page'        => $number,
				'post_type'             => 'post',
				'ignore_sticky_posts'   => true
				)
			);
		}
		else {
			if ( $child_category == 'true' ) {
				$get_featured_posts = new WP_Query( array(
					'posts_per_page'        => $number,
		            'post_type'             => 'post',
		            'cat'          			=> $category,
		            'no_found_rows'         => true
				) );
			} else {
				$get_featured_posts = new WP_Query( array(
					'posts_per_page'        => $number,
		            'post_type'             => 'post',
		            'category__in'          => $category,
		            'no_found_rows'         => true
				) );
			}
		}
		echo $before_widget;
		?>
		<div class="no-gutter">
		<?php
		if ( $type != 'latest' ) {
			$border_color = 'style="border-bottom-color:' . envince_category_color( $category ) . ';"';
			$title_color = 'style="background:' . envince_category_color( $category ) . ';"';
		} else {
			$border_color = '';
			$title_color = '';
		}
		if ( !empty( $title ) ) { echo '<h3 class="widget-title" '. $border_color .'><span class="wrap"' . $title_color .'>'. esc_html( $title ) .'</span></h3>'; }
		if( !empty( $text ) ) { ?> <p> <?php echo esc_textarea( $text ); ?> </p> <?php } ?>
		<div class="widget_imagegrid_posts">
		<?php
			$i=1;
			while( $get_featured_posts->have_posts() ):$get_featured_posts->the_post();
		?>
			<div class="single-article col-md-6 col-sm-6 clearfix">
				<?php
				if( has_post_thumbnail() ) {
					$image = '';
					$title_attribute = get_the_title( $post->ID );
					$image .= '<figure>';
					$image .= '<a href="' . esc_url( get_permalink() ) . '" title="'.the_title( '', '', false ).'">';
					$image .= get_the_post_thumbnail( $post->ID, 'envince-big-grid', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ) ) ).'</a>';
					$image .= '</figure>';
					echo $image;
				} else { ?>
                  <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                     <img src="<?php echo get_template_directory_uri(); ?>/images/default.png">
                  </a>
               <?php }
				?>
				<div class="article-content">
					<h3 class="entry-title">
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php the_title(); ?></a>
					</h3>
					<div class="entry-byline">
						<i class="fa fa-calendar"></i>
						<time <?php hybrid_attr( 'entry-published' ); ?>><?php echo get_the_date(); ?></time>
						<i class="fa fa-comment-o"></i>
						<?php comments_popup_link( number_format_i18n( 0 ), number_format_i18n( 1 ), '%', 'comments-link', '' ); ?>
					</div><!-- .entry-byline -->
				</div>
			</div>
		<?php
		endwhile;
		// Reset Post Data
		wp_reset_query();
		?>
		</div>
		</div><!-- .no-gutter -->
	<?php echo $after_widget;
	}
}
