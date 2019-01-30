<?php
namespace MT\PhotoAnalysis;

use Google\Cloud\PubSub\PubSubClient;

class QueueClient
{
	
	/**
	 * @param string $topicName The Pub/Sub topic name.
	 */
	public function __construct($topicName)
	{
		$pubsub = new PubSubClient([
			'keyFile' => json_decode(GCP_APPLICATION_KEY, true)
		]);
		$this->topic = $pubsub->topic($topicName);
	}
	
	/**
	 * Publishes a message for the Pub/Sub topic.
	 *
	 * @param string $image_uri  The image URI to publish.
	 * @param array  $attributes The attributes to publish
	 *
	 * @return null
	 */
	public function publish($image_uri, $attributes)
	{
		$data = json_encode([
			'image_uri' => $image_uri,
			'jwt' => GCP_JWT
		]);
		$this->topic->publish([
			'data' => $data,
			'attributes' => $attributes
		]);
	}
}
