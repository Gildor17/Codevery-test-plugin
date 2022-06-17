<?php

if (!defined("ABSPATH")) { exit;}

if (!class_exists("COTE_Widget")) {
	class COTE_Widget extends WP_Widget {
		private $layout;
		// The construct part
		function __construct() {
			parent::__construct(
				'cote_widget',
				'Codevery Widget',
				['description' => 'Codevery widget']
			);
		}

		// Creating widget front-end
		public function widget($args, $instance) {
			try {
				$this->layout = COTE_Utils::getWidgetLayouts();

				$title = $this->layout['title'];

//				if (!empty($args)&&!empty($args['id'])&&strpos($args['id'], 'sidebar')!==false) {
				if (!empty($args)&&!empty($args['id'])) {
					$widget = self::constructWidget($this->layout, $args);
					if (!empty($widget)) {
						echo $args['before_widget'];
						echo $widget;
						echo $args['after_widget'];
                    }
				}

				return true;
			}
			catch (Exception $ex) {}
			catch (Error $ex) {}
			return false;
		}

		public static function constructWidget($layout, $args = null, $preview = false, $wCounter = null) {
			try {
				$widget = '';
//				return $widget;
				if (!empty($preview)&&!empty($wCounter)) {
					$bonusClass = 'widget-preview-'.$wCounter;
				}

				if (!empty($layout['image'])) {
					$topImageUrl = $layout['image'];
				}

				if (!empty($args)&&empty($preview)) {
					$layout['title'] .= $args['before_title'] . $layout['title'] . $args['after_title'];
				} else {
					$layout['title'] .= '<div class="widget-title">'.$layout['title'].'</div>';
				}

				$widget .= '"'.include(COTE_PLUGIN_PATH."/views/cote-widget.php").'"';

				return "";
			}
			catch (Exception $ex) {}
			catch (Error $ex) {}
			return '';
		}

		// Creating widget Backend
		public function form($instance) {
			if (isset($instance['title'])) {
				$title = $instance['title'];
			} else {
				$title = __('New title');
			}
			// Widget admin form
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<?php
		}

		// Updating widget replacing old instances with new
		public function update($new_instance, $old_instance) {
			$instance = array();
			$instance['title'] = (!empty($new_instance['title']))?strip_tags($new_instance['title']):'';
			return $instance;
		}
	}
}
