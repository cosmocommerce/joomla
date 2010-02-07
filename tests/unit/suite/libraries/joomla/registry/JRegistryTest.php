<?php
require_once 'PHPUnit/Framework.php';

require_once JPATH_BASE.'/libraries/joomla/registry/registry.php';

/**
 * Test class for JRegistry.
 * Generated by PHPUnit on 2009-10-27 at 15:08:41.
 */
class JRegistryTest extends PHPUnit_Framework_TestCase
{
	/**
	 * Test the JRegistry::__clone method.
	 */
	public function test__clone()
	{
		$a = JRegistry::getInstance('a');
		$a->setValue('_default.foo', 'bar');
		$b = clone $a;

		$this->assertThat(
			serialize($a),
			$this->equalTo(serialize($b))
		);

		$this->assertThat(
			$a,
			$this->logicalNot($this->identicalTo($b))
		);
	}

	/**
	 * Test the JRegistry::__toString method.
	 */
	public function test__toString()
	{
		$a = JRegistry::getInstance('a');
		$a->setValue('_default.foo', 'bar');

		// __toString only allows for a JSON value.
		$this->assertThat(
			(string) $a,
			$this->equalTo('{"foo":"bar"}')
		);
	}

	/**
	 * @todo Implement testDef().
	 */
	/*public function testDef()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
		'This test has not been implemented yet.'
		);
	}*/

	/**
	 * @todo Implement testGet().
	 */
	public function testGet()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
		'This test has not been implemented yet.'
		);
	}

	/**
	 * Test the JRegistry::getInstance method.
	 */
	public function testGetInstance()
	{
		// Test INI format.
		$a = JRegistry::getInstance('a');
		$b = JRegistry::getInstance('a');
		$c = JRegistry::getInstance('c');

		// Check the object type.
		$this->assertThat(
			$a instanceof JRegistry,
			$this->isTrue()
		);

		// Check cache handling for same registry id.
		$this->assertThat(
			$a,
			$this->identicalTo($b)
		);

		// Check cache handling for different registry id.
		$this->assertThat(
			$a,
			$this->logicalNot($this->identicalTo($c))
		);
	}

	/**
	 * Test the JRegistry::loadArray method.
	 */
	public function testLoadArray()
	{
		$array = array(
			'foo' => 'bar'
		);
		$registry = JRegistry::getInstance('test');
		$result = $registry->loadArray($array);

		// Result is always true, no error checking in method.

		// Test getting a known value.
		$this->assertThat(
			$registry->getValue('foo'),
			$this->equalTo('bar')
		);
	}

	/**
	 * Test the JRegistry::loadFile method.
	 */
	public function testLoadFile()
	{
		$registry = JRegistry::getInstance('test');

		// Result is always true, no error checking in method.

		// JSON.
		$result = $registry->loadFile(dirname(__FILE__).'/jregistry.json');

		// Test getting a known value.
		$this->assertThat(
			$registry->getValue('foo'),
			$this->equalTo('bar')
		);

		// INI.
		$result = $registry->loadFile(dirname(__FILE__).'/jregistry.ini', 'ini');

		// Test getting a known value.
		$this->assertThat(
			$registry->getValue('foo'),
			$this->equalTo('bar')
		);

		// XML and PHP versions do not support stringToObject.

		$this->markTestIncomplete(
			'Need to test for a file that does not exist.'
		);
	}

	/**
	 * Test the JRegistry::loadIni method.
	 */
	public function testLoadINI()
	{
		$string = "[section]\nfoo=\"bar\"";

		$registry = JRegistry::getInstance('test');
		$result = $registry->loadIni($string);

		// Result is always true, no error checking in method.

		// Test getting a known value.
		$this->assertThat(
			$registry->getValue('foo'),
			$this->equalTo('bar')
		);
	}

	/**
	 * Test the JRegistry::loadJson method.
	 */
	public function testLoadJSON()
	{
		$string = '{"foo":"bar"}';

		$registry = JRegistry::getInstance('test');
		$result = $registry->loadJson($string);

		// Result is always true, no error checking in method.

		// Test getting a known value.
		$this->assertThat(
			$registry->getValue('foo'),
			$this->equalTo('bar')
		);
	}

	/**
	 * Test the JRegistry::loadObject method.
	 */
	public function testLoadObject()
	{
		$object = new stdClass;
		$object->foo = 'bar';

		$registry = JRegistry::getInstance('test');
		$result = $registry->loadObject($object);

		// Result is always true, no error checking in method.

		// Test getting a known value.
		$this->assertThat(
			$registry->getValue('foo'),
			$this->equalTo('bar')
		);
	}

	/**
	 * Test the JRegistry::loadXML method.
	 */
	public function testLoadXML()
	{
		// Cannot test since stringToObject is not implemented yet.
	}

	/**
	 * Test the JRegistry::merge method.
	 */
	public function testMerge()
	{
		$array1 = array(
			'foo' => 'bar',
			'hoo' => 'hum',
			'dum' => array(
				'dee' => 'dum'
			)
		);

		$array2 = array(
			'foo' => 'soap',
			'dum' => 'huh'
		);
		$registry1 = JRegistry::getInstance('test1');
		$registry1->loadArray($array1);

		$registry2 = JRegistry::getInstance('test2');
		$registry2->loadArray($array2);

		$registry1->merge($registry2);

		// Test getting a known value.
		$this->assertThat(
			$registry1->getValue('foo'),
			$this->equalTo('soap')
		);

		$this->assertThat(
			$registry1->getValue('dum'),
			$this->equalTo('huh')
		);
	}

	/**
	 * Test the JRegistry::set method.
	 */
	/*public function testSet()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
		'This test has not been implemented yet.'
		);
	}*/

	/**
	 * Test the JRegistry::toString method.
	 */
	public function testToString()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
		'This test has not been implemented yet.'
		);
	}

	/**
	 * Test the JRegistry::toArray method.
	 */
	public function testToArray()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
		'This test has not been implemented yet.'
		);
	}

	/**
	 * Test the JRegistry::toObject method.
	 */
	public function testToObject()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
		'This test has not been implemented yet.'
		);
	}

	//
	// The following methods are deprecated in 1.6
	//

	/**
	 * Test the JRegistry::getNamespaces method.
	 */
	public function testGetNameSpaces()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
		'This test has not been implemented yet.'
		);
	}

	/**
	 * Test the JRegistry::getValue method.
	 */
	public function testGetValue()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
		'This test has not been implemented yet.'
		);
	}

	/**
	 * Test the JRegistry::makeNamespace method.
	 */
	public function testMakeNameSpace()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
		'This test has not been implemented yet.'
		);
	}

	/**
	 * Test the JRegistry::setValue method.
	 */
	public function testSetValue()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
		'This test has not been implemented yet.'
		);
	}
}
