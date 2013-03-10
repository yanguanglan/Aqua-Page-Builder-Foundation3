<?php
/* Aqua Slides Block */
if(!class_exists('AQ_Slider_Block')) {
	class AQ_Slider_Block extends AQ_Block {
	
		function __construct() {
			$block_options = array(
				'name' => 'Slider',
				'size' => 'span6',
			);
			
			//create the widget
			parent::__construct('AQ_Slider_Block', $block_options);
			
			//add ajax functions
			add_action('wp_ajax_aq_block_slide_add_new', array($this, 'add_slide'));
			
		}
		
		function form($instance) {
		
			$defaults = array(
				'slides' => array(
					1 => array(
						'title' => '',
						'image' => '',
					)
				),
				'type'	=> 'slide',
			);
			
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			
			$slide_types = array(
				'slide' => 'Slides',
				'accordion' => 'Accordion'
			);
			
			?>
			<div class="description cf">
				<ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
					<?php
					$slides = is_array($slides) ? $slides : $defaults['slides'];
					$count = 1;
					foreach($slides as $slide) {	
						$this->slide($slide, $count);
						$count++;
					}
					?>
				</ul>
				<p></p>
				<a href="#" rel="slide" class="aq-sortable-add-new button">Add New</a>
				<p></p>
			</div>
			<p class="description">
				<label for="<?php echo $this->get_field_id('type') ?>">
					Slides style<br/>
					<?php echo aq_field_select('type', $block_id, $slide_types, $type) ?>
				</label>
			</p>
			<?php
		}
		
		function slide($slide = array(), $count = 0) {
				
			?>
			<li id="<?php echo $this->get_field_id('slides') ?>-sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">
				
				<div class="sortable-head cf">
					<div class="sortable-title">
						<strong><?php echo $slide['title'] ?></strong>
					</div>
					<div class="sortable-handle">
						<a href="#">Open / Close</a>
					</div>
				</div>
				
				<div class="sortable-body">
					<p class="slide-desc description">
						<label for="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-title">
							Slide Title<br/>
							<input type="text" id="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('slides') ?>[<?php echo $count ?>][title]" value="<?php echo $slide['title'] ?>" />
						</label>
					</p>
					<p class="slide-desc description">
						<label for="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-content">
							Image<br/>
							<input type="text" id="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-image" class="input-full input-upload" value="<?php echo $slide['image'] ?>" name="<?php echo $this->get_field_name('slides') ?>[<?php echo $count ?>][image]">
							<a href="#" class="aq_upload_button button" rel="image">Upload</a>
						</label>
					</p>
					<p class="slide-desc description"><a href="#" class="sortable-delete">Delete</a></p>
				</div>
				
			</li>
			<?php
		}
		
		function block($instance) {
			extract($instance);
			
			$output = '';
			
				$output .= '<div id="aq_block_slider_'. rand(1, 9999) .'" class="aq_block_slider flexslider">';
				$output .= '<ul class="slides">';

				$i = 1;
				foreach($slides as $slide) {
					$slide_selected = $i == 1 ? 'active' : '';
					$output .= '<li id="aq-slide-'. sanitize_title( $slide['title'] ) . $i .'Slide" class="'.$slide_selected.'">';
					$output .= '<img src="'.$slide['image'].'">';
					if($slide['title']) $output .= '<p class="flex-caption">' . $slide['title'] . '</p>';
					$output .= '</li>';

					$i++;
				}

				$output .= '</ul>';
				$output .= '</div>';
			
			echo $output;
			
		}
		
		/* AJAX add slide */
		function add_slide() {
			$nonce = $_POST['security'];	
			if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
			
			$count = isset($_POST['count']) ? absint($_POST['count']) : false;
			$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
			
			//default key/value for the slide
			$slide = array(
				'title' => 'New Slide',
				'content' => ''
			);
			
			if($count) {
				$this->slide($slide, $count);
			} else {
				die(-1);
			}
			
			die();
		}
		
		function update($new_instance, $old_instance) {
			$new_instance = aq_recursive_sanitize($new_instance);
			return 
			$new_instance;
		}
	}
}