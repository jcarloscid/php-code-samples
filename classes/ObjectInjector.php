<?php

/**
 * @author Carlos Cid
 * @package php-reusable
 * @version 0.1
 *  
 * This is the main class to implement dependency injection.

 * It assumes that you have an XML file similar to this one: 
 * <?xml version="1.0" encoding="UTF-8"?>
 * <my_applications>
 * 	<application>
 * 		<type ID="mytype">
 * 			<location>classes/mytype_1_0_2.php</location>
 * 		</type>
 * 	</application>
 * 	<application>
 * 		<type ID="config">
 * 			<location>cfg/my_production_config.xml</location>
 * 		</type>
 * 	</application>
 * </my_applications>
 * 
 * So you can implement two things out of this:
 * - createObject(): Constructs an arbitrary object. You call the injector with the object 
 *                   type (<type ID="mytype">) and receive and instance of the object implemented
 *                   by the class implemented inside the <location> module. This can be used, for 
 *                   instance, to easily change the version of the implementation to use.
 * - getImplementator(): This is used to just retrieve a file name from the XML file. In the sample
 * 					 <type ID="config"> represents an XML containing some contetnt required by the 
 * 					 application. It is simple to change the actual file providing such content
 * 					 without modifying the application code. 
 */

class ObjectInjector {

	// This is the XML that contains the actual implementations of the types to inject.
	private const XML_FILE_NAME = "MyApplication.xml";

	// Cannot create objects of this class
	private function __construct() {
	}

    /**
     * Retrieves the file name implementing a given type.
     * 
     * @param  string $type Type ID 
     * @return string The <location> element of the XML file correspoondint to the type ID.
     */
	public static function getImplementator($type) {
		$xmlDoc = new DOMDocument();

		if (file_exists(self::XML_FILE_NAME)) {
			$xmlDoc->load(self::XML_FILE_NAME);
			$searchNode = $xmlDoc->getElementsByTagName("type");
			foreach ($searchNode as $searchNode) {
				$typeID = $searchNode->getAttribute("ID");
				if ($typeID == $type) {
					$location = $searchNode->getElementsByTagName("location");
					return $location->item(0)->nodeValue;
				}
			}
		}
		return FALSE;
	}

	/**
	 * Creates an instance of an arbitrary object.
	 * 
	 * @param  string $type The type ID of the object requested.
	 * @param  array $properties_array An array of properties that will be passed to the obejct constructor. Can be NULL.
	 * @return object The instance of the object created or FALSE on error.
	 */
	public static function createObject($type, $properties_array = NULL) {
		$implementator = self::getImplementator($type);

		if ( ($implementator == FALSE) || (!file_exists($implementator)) ) {
			return FALSE;
		} else {
			require_once($implementator);
			$class_array = get_declared_classes();
			$last_position = count($class_array) - 1;
			$class_name = $class_array[$last_position];
			if (is_null($properties_array)) {
				$new_object = new $class_name();
			} else {
				$new_object = new $class_name($properties_array);				
			}
			return $new_object;
		}
	}
}

?>
