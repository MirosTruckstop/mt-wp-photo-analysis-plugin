<?php
namespace MT\PhotoAnalysis;
use Google\Cloud\PubSub\PubSubClient;

class OptionsPage {
	
	const queue_topic = 'photo-analysis-request';

	private function __sample_publish() {
		$photos = $this->__getPhotos();
		foreach ($photos as $photo) {
			$this->publish_message(self::queue_topic, $photo->id);
		}
		return $photos;
	}
	
	public static function __getPhotos($limit=1, $output_type='OBJECT') {
		global $wpdb;
		return $wpdb->get_results("SELECT id, date FROM wp_mt_photo ORDER BY date DESC LIMIT ${limit}", $output_type);
	}
	
	/**
	* Publishes a message for a Pub/Sub topic.
	*
	* @param string $projectId  The Google project ID.
	* @param string $topicName  The Pub/Sub topic name.
	* @param string $message  The message to publish.
	*/
	private function publish_message($topicName, $message) {
		$pubsub = new PubSubClient([
			#'projectId' => $projectId,
			'keyFile' => json_decode(GCP_APPLICATION_KEY, true)
		]);
		$topic = $pubsub->topic($topicName);
		$topic->publish(['data' => $message]);
	}

	public function outputContent() {
	?>
	<div class="wrap">
	<h2><?php _e('Fotoanalyse');?> (<?php _e('Beta'); ?></h2>
		<p><?php _e('Hier gibt es nichts zu sehen, oder doch'); ?>: <?php echo count($this->__sample_publish()); ?>!</p>
	</div>
	<?php
	}
}