<?php
namespace MT\PhotoAnalysis;

class OptionsPage {

	private static function __analyseAllPhotos() {
		$queue = new QueueClient(get_option('mt_pa_queue_topic'));
		$imageBasePath = get_bloginfo('url').'/bilder/';
		$photos = self::__getPhotos();
		foreach ($photos as $photo) {
			$message = $imageBasePath.$photo->path;
			$queue->publish($message, ['id' => $photo->id]);
		}
		return count($photos);
	}
	
	public static function __getPhotos() {
		global $wpdb;
		return $wpdb->get_results("SELECT id, path FROM wp_mt_photo ORDER BY date ASC");
	}

	public function outputContent() {
	?>
	<div class="wrap">
		<h1><?php _e('Fotoanalyse');?> (<?php _e('Beta'); ?>)</h1>
		<?php if (isset($_POST['index'])) : ?>
			<div class="notice notice-success is-dismissible"><p><?php _e('Analysierte Photos'); ?>: <?php echo self::__analyseAllPhotos(); ?></p></div>
		<?php endif; ?>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<lable for="mt_pa_queue_topic"><?php _e('Thema der Warteschlange'); ?></lable>
					</th>
					<td>
						<input name="mt_pa_queue_topic" type="text" value="<?php echo get_option('mt_pa_queue_topic'); ?>" disabled>
					</td>
				</tr>
			</tbody>
		</table>
		<h2><?php _e('Vollindizierung'); ?></h2>
		<form action="" method="POST">
			<p><?php _e('Für neu hochgeladene Bilder wird automatisch eine Fotoanalyse durchgeführt. Um für die bereits bestehenden'
					. 'Bilder eine Analyse durchzuführen, ist eine Vollinidizierung notwendig.'); ?>
			<p>
				<input name="index" type="hidden" value="true">
				<?php submit_button(__('Vollindizierung ausführen')); ?>
			</p>
		</form>
	</div>
	<?php
	}
}