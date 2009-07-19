--TEST--
CFUtilities - json_encode_php51

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$util = new CFUtilities();
	var_dump($util->json_encode_php51(array(
		'a' => array(
			'a' => array(
				'a' => array(
					'a' => array(
						'a' => array(
							'a' => array(
								'a' => 'example',
							),
							'b' => 'example',
						),
						'b' => 'example',
						'c' => 1.2,
					),
					'b' => array(
						'a' => array(
							'a' => 'example',
						),
						'b' => 'example',
					),
					'c' => 'example',
					'd' => 1.2,
				),
				'b' => array(
					'a' => array(
						'a' => 'example',
					),
					'b' => 'example',
				),
				'c' => 'example',
				'd' => 1.2,
			),
			'b' => array(
				'a' => array(
					'a' => 'example',
				),
				'b' => 'example',
			),
			'c' => 'example',
			'd' => 1.2,
		),
		'b' => array(
			'a' => array(
				'a' => 'example',
			),
			'b' => 'example',
		),
		'c' => array(
			'a' => 'example',
		),
		'd' => 'example',
		'e' => 1.2,
	)));
?>

--EXPECT--
string(355) "{"a":{"a":{"a":{"a":{"a":{"a":{"a":"example"},"b":"example"},"b":"example","c":1.2},"b":{"a":{"a":"example"},"b":"example"},"c":"example","d":1.2},"b":{"a":{"a":"example"},"b":"example"},"c":"example","d":1.2},"b":{"a":{"a":"example"},"b":"example"},"c":"example","d":1.2},"b":{"a":{"a":"example"},"b":"example"},"c":{"a":"example"},"d":"example","e":1.2}"
