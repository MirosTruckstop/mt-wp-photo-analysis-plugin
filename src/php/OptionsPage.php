<?php
namespace MT\PhotoAnalysis;
use Google\Cloud\PubSub\PubSubClient;

class OptionsPage {
	
	const queue_topic = 'photo-analysis-request';

	private function __sample_publish() {
		$photos = $this->__getPhotos();
		foreach ($photos as $photo) {
			$message = get_bloginfo('url').'/bilder/'.$photo->path;
			$attributes = ['id' => $photo->id];
			$this->publish_message(self::queue_topic, $message, $attributes);
		}
		return count($photos);
	}
	
	public static function __getPhotos($limit=1, $output_type='OBJECT') {
		global $wpdb;
		// TODO: Remove the WHERE condition
		return $wpdb->get_results("SELECT id, path FROM wp_mt_photo WHERE id = 3908 ORDER BY date ASC LIMIT ${limit}", $output_type);
	}
	
	/**
	 * Publishes a message for a Pub/Sub topic.
	 *
	 * @param string $topicName  The Pub/Sub topic name.
	 * @param string $message  The message to publish.
	 * @param array $attributes The attributes to publish
	*/
	private function publish_message($topicName, $message, $attributes) {
		$pubsub = new PubSubClient([
			'keyFile' => json_decode(GCP_APPLICATION_KEY, true)
		]);
		$topic = $pubsub->topic($topicName);
		$topic->publish([
			'data' => $message,
			'attributes' => $attributes
		]);
	}

	public function outputContent() {
	?>
	<div class="wrap">
	<h2><?php _e('Fotoanalyse');?> (<?php _e('Beta'); ?>)</h2>
		<p><?php _e('Hier gibt es nichts zu sehen, oder doch'); ?>: <?php echo $this->__sample_publish(); ?>!</p>
	</div>
	<?php
	}
}