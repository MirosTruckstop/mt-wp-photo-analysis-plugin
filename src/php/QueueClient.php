<?php
namespace MT\PhotoAnalysis;
use Google\Cloud\PubSub\PubSubClient;

class QueueClient {
	
	/**
	 * 
	 * @param string $topicName The Pub/Sub topic name.
	 */
	public function __construct($topicName) {
		$pubsub = new PubSubClient([
			'keyFile' => json_decode(GCP_APPLICATION_KEY, true)
		]);
		$this->topic = $pubsub->topic($topicName);
	}
	
	/**
	 * Publishes a message for the Pub/Sub topic.
	 *
	 * @param string $message  The message to publish.
	 * @param array $attributes The attributes to publish
	 */
	public function publish($message, $attributes) {
		$this->topic->publish([
			'data' => $message,
			'attributes' => $attributes
		]);
	}
	
}
