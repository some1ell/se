<?php

class SlackAlerterTest extends PHPUnit_Framework_TestCase
{
    /**
     * Returns a matcher that matches when the method is executed
     * zero or more times.
     *
     * @return PHPUnit_Framework_MockObject_Matcher_AnyInvokedCount
     *
     * @since Method available since Release 3.0.0
     */
    static function any()
    {
        try {
            return call_user_func_array('PHPUnit_Framework_TestCase::any', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_IsAnything matcher object.
     *
     * @return PHPUnit_Framework_Constraint_IsAnything
     *
     * @since Method available since Release 3.0.0
     */
    static function anything()
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::anything', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_ArrayHasKey matcher object.
     *
     * @param mixed $key
     *
     * @return PHPUnit_Framework_Constraint_ArrayHasKey
     *
     * @since Method available since Release 3.0.0
     */
    static function arrayHasKey($key)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::arrayHasKey', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that an array has a specified key.
     *
     * @param mixed $key
     * @param array|ArrayAccess $array
     * @param string $message
     *
     * @since Method available since Release 3.0.0
     */
    static function assertArrayHasKey($key, $array, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertArrayHasKey', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that an array has a specified subset.
     *
     * @param array|ArrayAccess $subset
     * @param array|ArrayAccess $array
     * @param bool $strict Check for object identity
     * @param string $message
     *
     * @since Method available since Release 4.4.0
     */
    static function assertArraySubset($subset, $array, $strict = false, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertArraySubset', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that an array does not have a specified key.
     *
     * @param mixed $key
     * @param array|ArrayAccess $array
     * @param string $message
     *
     * @since Method available since Release 3.0.0
     */
    static function assertArrayNotHasKey($key, $array, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertArrayNotHasKey', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a haystack that is stored in a static attribute of a class
     * or an attribute of an object contains a needle.
     *
     * @param mixed $needle
     * @param string $haystackAttributeName
     * @param mixed $haystackClassOrObject
     * @param string $message
     * @param bool $ignoreCase
     * @param bool $checkForObjectIdentity
     * @param bool $checkForNonObjectIdentity
     *
     * @since Method available since Release 3.0.0
     */
    static function assertAttributeContains($needle, $haystackAttributeName, $haystackClassOrObject, $message = '', $ignoreCase = false, $checkForObjectIdentity = true, $checkForNonObjectIdentity = false)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertAttributeContains', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a haystack that is stored in a static attribute of a class
     * or an attribute of an object contains only values of a given type.
     *
     * @param string $type
     * @param string $haystackAttributeName
     * @param mixed $haystackClassOrObject
     * @param bool $isNativeType
     * @param string $message
     *
     * @since Method available since Release 3.1.4
     */
    static function assertAttributeContainsOnly($type, $haystackAttributeName, $haystackClassOrObject, $isNativeType = null, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertAttributeContainsOnly', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts the number of elements of an array, Countable or Traversable
     * that is stored in an attribute.
     *
     * @param int $expectedCount
     * @param string $haystackAttributeName
     * @param mixed $haystackClassOrObject
     * @param string $message
     *
     * @since Method available since Release 3.6.0
     */
    static function assertAttributeCount($expectedCount, $haystackAttributeName, $haystackClassOrObject, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertAttributeCount', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a static attribute of a class or an attribute of an object
     * is empty.
     *
     * @param string $haystackAttributeName
     * @param mixed $haystackClassOrObject
     * @param string $message
     *
     * @since Method available since Release 3.5.0
     */
    static function assertAttributeEmpty($haystackAttributeName, $haystackClassOrObject, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertAttributeEmpty', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a variable is equal to an attribute of an object.
     *
     * @param mixed $expected
     * @param string $actualAttributeName
     * @param string $actualClassOrObject
     * @param string $message
     * @param float $delta
     * @param int $maxDepth
     * @param bool $canonicalize
     * @param bool $ignoreCase
     */
    static function assertAttributeEquals($expected, $actualAttributeName, $actualClassOrObject, $message = '', $delta = 0.0, $maxDepth = 10, $canonicalize = false, $ignoreCase = false)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertAttributeEquals', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that an attribute is greater than another value.
     *
     * @param mixed $expected
     * @param string $actualAttributeName
     * @param string $actualClassOrObject
     * @param string $message
     *
     * @since Method available since Release 3.1.0
     */
    static function assertAttributeGreaterThan($expected, $actualAttributeName, $actualClassOrObject, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertAttributeGreaterThan', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that an attribute is greater than or equal to another value.
     *
     * @param mixed $expected
     * @param string $actualAttributeName
     * @param string $actualClassOrObject
     * @param string $message
     *
     * @since Method available since Release 3.1.0
     */
    static function assertAttributeGreaterThanOrEqual($expected, $actualAttributeName, $actualClassOrObject, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertAttributeGreaterThanOrEqual', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that an attribute is of a given type.
     *
     * @param string $expected
     * @param string $attributeName
     * @param mixed $classOrObject
     * @param string $message
     *
     * @since Method available since Release 3.5.0
     */
    static function assertAttributeInstanceOf($expected, $attributeName, $classOrObject, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertAttributeInstanceOf', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that an attribute is of a given type.
     *
     * @param string $expected
     * @param string $attributeName
     * @param mixed $classOrObject
     * @param string $message
     *
     * @since Method available since Release 3.5.0
     */
    static function assertAttributeInternalType($expected, $attributeName, $classOrObject, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertAttributeInternalType', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that an attribute is smaller than another value.
     *
     * @param mixed $expected
     * @param string $actualAttributeName
     * @param string $actualClassOrObject
     * @param string $message
     *
     * @since Method available since Release 3.1.0
     */
    static function assertAttributeLessThan($expected, $actualAttributeName, $actualClassOrObject, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertAttributeLessThan', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that an attribute is smaller than or equal to another value.
     *
     * @param mixed $expected
     * @param string $actualAttributeName
     * @param string $actualClassOrObject
     * @param string $message
     *
     * @since Method available since Release 3.1.0
     */
    static function assertAttributeLessThanOrEqual($expected, $actualAttributeName, $actualClassOrObject, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertAttributeLessThanOrEqual', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a haystack that is stored in a static attribute of a class
     * or an attribute of an object does not contain a needle.
     *
     * @param mixed $needle
     * @param string $haystackAttributeName
     * @param mixed $haystackClassOrObject
     * @param string $message
     * @param bool $ignoreCase
     * @param bool $checkForObjectIdentity
     * @param bool $checkForNonObjectIdentity
     *
     * @since Method available since Release 3.0.0
     */
    static function assertAttributeNotContains($needle, $haystackAttributeName, $haystackClassOrObject, $message = '', $ignoreCase = false, $checkForObjectIdentity = true, $checkForNonObjectIdentity = false)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertAttributeNotContains', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a haystack that is stored in a static attribute of a class
     * or an attribute of an object does not contain only values of a given
     * type.
     *
     * @param string $type
     * @param string $haystackAttributeName
     * @param mixed $haystackClassOrObject
     * @param bool $isNativeType
     * @param string $message
     *
     * @since Method available since Release 3.1.4
     */
    static function assertAttributeNotContainsOnly($type, $haystackAttributeName, $haystackClassOrObject, $isNativeType = null, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertAttributeNotContainsOnly', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts the number of elements of an array, Countable or Traversable
     * that is stored in an attribute.
     *
     * @param int $expectedCount
     * @param string $haystackAttributeName
     * @param mixed $haystackClassOrObject
     * @param string $message
     *
     * @since Method available since Release 3.6.0
     */
    static function assertAttributeNotCount($expectedCount, $haystackAttributeName, $haystackClassOrObject, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertAttributeNotCount', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a static attribute of a class or an attribute of an object
     * is not empty.
     *
     * @param string $haystackAttributeName
     * @param mixed $haystackClassOrObject
     * @param string $message
     *
     * @since Method available since Release 3.5.0
     */
    static function assertAttributeNotEmpty($haystackAttributeName, $haystackClassOrObject, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertAttributeNotEmpty', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a variable is not equal to an attribute of an object.
     *
     * @param mixed $expected
     * @param string $actualAttributeName
     * @param string $actualClassOrObject
     * @param string $message
     * @param float $delta
     * @param int $maxDepth
     * @param bool $canonicalize
     * @param bool $ignoreCase
     */
    static function assertAttributeNotEquals($expected, $actualAttributeName, $actualClassOrObject, $message = '', $delta = 0.0, $maxDepth = 10, $canonicalize = false, $ignoreCase = false)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertAttributeNotEquals', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that an attribute is of a given type.
     *
     * @param string $expected
     * @param string $attributeName
     * @param mixed $classOrObject
     * @param string $message
     *
     * @since Method available since Release 3.5.0
     */
    static function assertAttributeNotInstanceOf($expected, $attributeName, $classOrObject, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertAttributeNotInstanceOf', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that an attribute is of a given type.
     *
     * @param string $expected
     * @param string $attributeName
     * @param mixed $classOrObject
     * @param string $message
     *
     * @since Method available since Release 3.5.0
     */
    static function assertAttributeNotInternalType($expected, $attributeName, $classOrObject, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertAttributeNotInternalType', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a variable and an attribute of an object do not have the
     * same type and value.
     *
     * @param mixed $expected
     * @param string $actualAttributeName
     * @param object $actualClassOrObject
     * @param string $message
     */
    static function assertAttributeNotSame($expected, $actualAttributeName, $actualClassOrObject, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertAttributeNotSame', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a variable and an attribute of an object have the same type
     * and value.
     *
     * @param mixed $expected
     * @param string $actualAttributeName
     * @param object $actualClassOrObject
     * @param string $message
     */
    static function assertAttributeSame($expected, $actualAttributeName, $actualClassOrObject, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertAttributeSame', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a class has a specified attribute.
     *
     * @param string $attributeName
     * @param string $className
     * @param string $message
     *
     * @since Method available since Release 3.1.0
     */
    static function assertClassHasAttribute($attributeName, $className, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertClassHasAttribute', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a class has a specified static attribute.
     *
     * @param string $attributeName
     * @param string $className
     * @param string $message
     *
     * @since Method available since Release 3.1.0
     */
    static function assertClassHasStaticAttribute($attributeName, $className, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertClassHasStaticAttribute', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a class does not have a specified attribute.
     *
     * @param string $attributeName
     * @param string $className
     * @param string $message
     *
     * @since Method available since Release 3.1.0
     */
    static function assertClassNotHasAttribute($attributeName, $className, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertClassNotHasAttribute', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a class does not have a specified static attribute.
     *
     * @param string $attributeName
     * @param string $className
     * @param string $message
     *
     * @since Method available since Release 3.1.0
     */
    static function assertClassNotHasStaticAttribute($attributeName, $className, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertClassNotHasStaticAttribute', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a haystack contains a needle.
     *
     * @param mixed $needle
     * @param mixed $haystack
     * @param string $message
     * @param bool $ignoreCase
     * @param bool $checkForObjectIdentity
     * @param bool $checkForNonObjectIdentity
     *
     * @since Method available since Release 2.1.0
     */
    static function assertContains($needle, $haystack, $message = '', $ignoreCase = false, $checkForObjectIdentity = true, $checkForNonObjectIdentity = false)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertContains', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a haystack contains only values of a given type.
     *
     * @param string $type
     * @param mixed $haystack
     * @param bool $isNativeType
     * @param string $message
     *
     * @since Method available since Release 3.1.4
     */
    static function assertContainsOnly($type, $haystack, $isNativeType = null, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertContainsOnly', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a haystack contains only instances of a given classname
     *
     * @param string $classname
     * @param array|Traversable $haystack
     * @param string $message
     */
    static function assertContainsOnlyInstancesOf($classname, $haystack, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertContainsOnlyInstancesOf', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts the number of elements of an array, Countable or Traversable.
     *
     * @param int $expectedCount
     * @param mixed $haystack
     * @param string $message
     */
    static function assertCount($expectedCount, $haystack, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertCount', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a variable is empty.
     *
     * @param mixed $actual
     * @param string $message
     *
     * @throws PHPUnit_Framework_AssertionFailedError
     */
    static function assertEmpty($actual, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertEmpty', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a hierarchy of DOMElements matches.
     *
     * @param DOMElement $expectedElement
     * @param DOMElement $actualElement
     * @param bool $checkAttributes
     * @param string $message
     *
     * @since Method available since Release 3.3.0
     */
    static function assertEqualXMLStructure(DOMElement $expectedElement, DOMElement $actualElement, $checkAttributes = false, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertEqualXMLStructure', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that two variables are equal.
     *
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     * @param float $delta
     * @param int $maxDepth
     * @param bool $canonicalize
     * @param bool $ignoreCase
     */
    static function assertEquals($expected, $actual, $message = '', $delta = 0.0, $maxDepth = 10, $canonicalize = false, $ignoreCase = false)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertEquals', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a condition is not true.
     *
     * @param bool $condition
     * @param string $message
     *
     * @throws PHPUnit_Framework_AssertionFailedError
     */
    static function assertNotTrue($condition, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertNotTrue', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a condition is false.
     *
     * @param bool $condition
     * @param string $message
     *
     * @throws PHPUnit_Framework_AssertionFailedError
     */
    static function assertFalse($condition, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertFalse', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that the contents of one file is equal to the contents of another
     * file.
     *
     * @param string $expected
     * @param string $actual
     * @param string $message
     * @param bool $canonicalize
     * @param bool $ignoreCase
     *
     * @since Method available since Release 3.2.14
     */
    static function assertFileEquals($expected, $actual, $message = '', $canonicalize = false, $ignoreCase = false)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertFileEquals', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a file exists.
     *
     * @param string $filename
     * @param string $message
     *
     * @since Method available since Release 3.0.0
     */
    static function assertFileExists($filename, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertFileExists', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that the contents of one file is not equal to the contents of
     * another file.
     *
     * @param string $expected
     * @param string $actual
     * @param string $message
     * @param bool $canonicalize
     * @param bool $ignoreCase
     *
     * @since Method available since Release 3.2.14
     */
    static function assertFileNotEquals($expected, $actual, $message = '', $canonicalize = false, $ignoreCase = false)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertFileNotEquals', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a file does not exist.
     *
     * @param string $filename
     * @param string $message
     *
     * @since Method available since Release 3.0.0
     */
    static function assertFileNotExists($filename, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertFileNotExists', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a value is greater than another value.
     *
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     *
     * @since Method available since Release 3.1.0
     */
    static function assertGreaterThan($expected, $actual, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertGreaterThan', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a value is greater than or equal to another value.
     *
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     *
     * @since Method available since Release 3.1.0
     */
    static function assertGreaterThanOrEqual($expected, $actual, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertGreaterThanOrEqual', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a variable is of a given type.
     *
     * @param string $expected
     * @param mixed $actual
     * @param string $message
     *
     * @since Method available since Release 3.5.0
     */
    static function assertInstanceOf($expected, $actual, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertInstanceOf', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a variable is of a given type.
     *
     * @param string $expected
     * @param mixed $actual
     * @param string $message
     *
     * @since Method available since Release 3.5.0
     */
    static function assertInternalType($expected, $actual, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertInternalType', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a string is a valid JSON string.
     *
     * @param string $actualJson
     * @param string $message
     *
     * @since Method available since Release 3.7.20
     */
    static function assertJson($actualJson, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertJson', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that two JSON files are equal.
     *
     * @param string $expectedFile
     * @param string $actualFile
     * @param string $message
     */
    static function assertJsonFileEqualsJsonFile($expectedFile, $actualFile, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertJsonFileEqualsJsonFile', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that two JSON files are not equal.
     *
     * @param string $expectedFile
     * @param string $actualFile
     * @param string $message
     */
    static function assertJsonFileNotEqualsJsonFile($expectedFile, $actualFile, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertJsonFileNotEqualsJsonFile', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that the generated JSON encoded object and the content of the given file are equal.
     *
     * @param string $expectedFile
     * @param string $actualJson
     * @param string $message
     */
    static function assertJsonStringEqualsJsonFile($expectedFile, $actualJson, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertJsonStringEqualsJsonFile', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that two given JSON encoded objects or arrays are equal.
     *
     * @param string $expectedJson
     * @param string $actualJson
     * @param string $message
     */
    static function assertJsonStringEqualsJsonString($expectedJson, $actualJson, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertJsonStringEqualsJsonString', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that the generated JSON encoded object and the content of the given file are not equal.
     *
     * @param string $expectedFile
     * @param string $actualJson
     * @param string $message
     */
    static function assertJsonStringNotEqualsJsonFile($expectedFile, $actualJson, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertJsonStringNotEqualsJsonFile', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that two given JSON encoded objects or arrays are not equal.
     *
     * @param string $expectedJson
     * @param string $actualJson
     * @param string $message
     */
    static function assertJsonStringNotEqualsJsonString($expectedJson, $actualJson, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertJsonStringNotEqualsJsonString', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a value is smaller than another value.
     *
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     *
     * @since Method available since Release 3.1.0
     */
    static function assertLessThan($expected, $actual, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertLessThan', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a value is smaller than or equal to another value.
     *
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     *
     * @since Method available since Release 3.1.0
     */
    static function assertLessThanOrEqual($expected, $actual, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertLessThanOrEqual', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a variable is finite.
     *
     * @param mixed $actual
     * @param string $message
     */
    static function assertFinite($actual, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertFinite', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a variable is infinite.
     *
     * @param mixed $actual
     * @param string $message
     */
    static function assertInfinite($actual, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertInfinite', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a variable is nan.
     *
     * @param mixed $actual
     * @param string $message
     */
    static function assertNan($actual, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertNan', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a haystack does not contain a needle.
     *
     * @param mixed $needle
     * @param mixed $haystack
     * @param string $message
     * @param bool $ignoreCase
     * @param bool $checkForObjectIdentity
     * @param bool $checkForNonObjectIdentity
     *
     * @since Method available since Release 2.1.0
     */
    static function assertNotContains($needle, $haystack, $message = '', $ignoreCase = false, $checkForObjectIdentity = true, $checkForNonObjectIdentity = false)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertNotContains', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a haystack does not contain only values of a given type.
     *
     * @param string $type
     * @param mixed $haystack
     * @param bool $isNativeType
     * @param string $message
     *
     * @since Method available since Release 3.1.4
     */
    static function assertNotContainsOnly($type, $haystack, $isNativeType = null, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertNotContainsOnly', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts the number of elements of an array, Countable or Traversable.
     *
     * @param int $expectedCount
     * @param mixed $haystack
     * @param string $message
     */
    static function assertNotCount($expectedCount, $haystack, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertNotCount', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a variable is not empty.
     *
     * @param mixed $actual
     * @param string $message
     *
     * @throws PHPUnit_Framework_AssertionFailedError
     */
    static function assertNotEmpty($actual, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertNotEmpty', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that two variables are not equal.
     *
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     * @param float $delta
     * @param int $maxDepth
     * @param bool $canonicalize
     * @param bool $ignoreCase
     *
     * @since Method available since Release 2.3.0
     */
    static function assertNotEquals($expected, $actual, $message = '', $delta = 0.0, $maxDepth = 10, $canonicalize = false, $ignoreCase = false)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertNotEquals', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a variable is not of a given type.
     *
     * @param string $expected
     * @param mixed $actual
     * @param string $message
     *
     * @since Method available since Release 3.5.0
     */
    static function assertNotInstanceOf($expected, $actual, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertNotInstanceOf', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a variable is not of a given type.
     *
     * @param string $expected
     * @param mixed $actual
     * @param string $message
     *
     * @since Method available since Release 3.5.0
     */
    static function assertNotInternalType($expected, $actual, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertNotInternalType', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a condition is not false.
     *
     * @param bool $condition
     * @param string $message
     *
     * @throws PHPUnit_Framework_AssertionFailedError
     */
    static function assertNotFalse($condition, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertNotFalse', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a variable is not null.
     *
     * @param mixed $actual
     * @param string $message
     */
    static function assertNotNull($actual, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertNotNull', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a string does not match a given regular expression.
     *
     * @param string $pattern
     * @param string $string
     * @param string $message
     *
     * @since Method available since Release 2.1.0
     */
    static function assertNotRegExp($pattern, $string, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertNotRegExp', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that two variables do not have the same type and value.
     * Used on objects, it asserts that two variables do not reference
     * the same object.
     *
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     */
    static function assertNotSame($expected, $actual, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertNotSame', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Assert that the size of two arrays (or `Countable` or `Traversable` objects)
     * is not the same.
     *
     * @param array|Countable|Traversable $expected
     * @param array|Countable|Traversable $actual
     * @param string $message
     */
    static function assertNotSameSize($expected, $actual, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertNotSameSize', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a variable is null.
     *
     * @param mixed $actual
     * @param string $message
     */
    static function assertNull($actual, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertNull', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that an object has a specified attribute.
     *
     * @param string $attributeName
     * @param object $object
     * @param string $message
     *
     * @since Method available since Release 3.0.0
     */
    static function assertObjectHasAttribute($attributeName, $object, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertObjectHasAttribute', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that an object does not have a specified attribute.
     *
     * @param string $attributeName
     * @param object $object
     * @param string $message
     *
     * @since Method available since Release 3.0.0
     */
    static function assertObjectNotHasAttribute($attributeName, $object, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertObjectNotHasAttribute', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a string matches a given regular expression.
     *
     * @param string $pattern
     * @param string $string
     * @param string $message
     */
    static function assertRegExp($pattern, $string, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertRegExp', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that two variables have the same type and value.
     * Used on objects, it asserts that two variables reference
     * the same object.
     *
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     */
    static function assertSame($expected, $actual, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertSame', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Assert that the size of two arrays (or `Countable` or `Traversable` objects)
     * is the same.
     *
     * @param array|Countable|Traversable $expected
     * @param array|Countable|Traversable $actual
     * @param string $message
     */
    static function assertSameSize($expected, $actual, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertSameSize', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a string ends not with a given prefix.
     *
     * @param string $suffix
     * @param string $string
     * @param string $message
     *
     * @since Method available since Release 3.4.0
     */
    static function assertStringEndsNotWith($suffix, $string, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertStringEndsNotWith', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a string ends with a given prefix.
     *
     * @param string $suffix
     * @param string $string
     * @param string $message
     *
     * @since Method available since Release 3.4.0
     */
    static function assertStringEndsWith($suffix, $string, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertStringEndsWith', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that the contents of a string is equal
     * to the contents of a file.
     *
     * @param string $expectedFile
     * @param string $actualString
     * @param string $message
     * @param bool $canonicalize
     * @param bool $ignoreCase
     *
     * @since Method available since Release 3.3.0
     */
    static function assertStringEqualsFile($expectedFile, $actualString, $message = '', $canonicalize = false, $ignoreCase = false)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertStringEqualsFile', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a string matches a given format string.
     *
     * @param string $format
     * @param string $string
     * @param string $message
     *
     * @since Method available since Release 3.5.0
     */
    static function assertStringMatchesFormat($format, $string, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertStringMatchesFormat', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a string matches a given format file.
     *
     * @param string $formatFile
     * @param string $string
     * @param string $message
     *
     * @since Method available since Release 3.5.0
     */
    static function assertStringMatchesFormatFile($formatFile, $string, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertStringMatchesFormatFile', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that the contents of a string is not equal
     * to the contents of a file.
     *
     * @param string $expectedFile
     * @param string $actualString
     * @param string $message
     * @param bool $canonicalize
     * @param bool $ignoreCase
     *
     * @since Method available since Release 3.3.0
     */
    static function assertStringNotEqualsFile($expectedFile, $actualString, $message = '', $canonicalize = false, $ignoreCase = false)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertStringNotEqualsFile', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a string does not match a given format string.
     *
     * @param string $format
     * @param string $string
     * @param string $message
     *
     * @since Method available since Release 3.5.0
     */
    static function assertStringNotMatchesFormat($format, $string, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertStringNotMatchesFormat', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a string does not match a given format string.
     *
     * @param string $formatFile
     * @param string $string
     * @param string $message
     *
     * @since Method available since Release 3.5.0
     */
    static function assertStringNotMatchesFormatFile($formatFile, $string, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertStringNotMatchesFormatFile', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a string starts not with a given prefix.
     *
     * @param string $prefix
     * @param string $string
     * @param string $message
     *
     * @since Method available since Release 3.4.0
     */
    static function assertStringStartsNotWith($prefix, $string, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertStringStartsNotWith', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a string starts with a given prefix.
     *
     * @param string $prefix
     * @param string $string
     * @param string $message
     *
     * @since Method available since Release 3.4.0
     */
    static function assertStringStartsWith($prefix, $string, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertStringStartsWith', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Evaluates a PHPUnit_Framework_Constraint matcher object.
     *
     * @param mixed $value
     * @param PHPUnit_Framework_Constraint $constraint
     * @param string $message
     *
     * @since Method available since Release 3.0.0
     */
    static function assertThat($value, PHPUnit_Framework_Constraint $constraint, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertThat', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that a condition is true.
     *
     * @param bool $condition
     * @param string $message
     *
     * @throws PHPUnit_Framework_AssertionFailedError
     */
    static function assertTrue($condition, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertTrue', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that two XML files are equal.
     *
     * @param string $expectedFile
     * @param string $actualFile
     * @param string $message
     *
     * @since Method available since Release 3.1.0
     */
    static function assertXmlFileEqualsXmlFile($expectedFile, $actualFile, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertXmlFileEqualsXmlFile', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that two XML files are not equal.
     *
     * @param string $expectedFile
     * @param string $actualFile
     * @param string $message
     *
     * @since Method available since Release 3.1.0
     */
    static function assertXmlFileNotEqualsXmlFile($expectedFile, $actualFile, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertXmlFileNotEqualsXmlFile', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that two XML documents are equal.
     *
     * @param string $expectedFile
     * @param string $actualXml
     * @param string $message
     *
     * @since Method available since Release 3.3.0
     */
    static function assertXmlStringEqualsXmlFile($expectedFile, $actualXml, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertXmlStringEqualsXmlFile', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that two XML documents are equal.
     *
     * @param string $expectedXml
     * @param string $actualXml
     * @param string $message
     *
     * @since Method available since Release 3.1.0
     */
    static function assertXmlStringEqualsXmlString($expectedXml, $actualXml, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertXmlStringEqualsXmlString', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that two XML documents are not equal.
     *
     * @param string $expectedFile
     * @param string $actualXml
     * @param string $message
     *
     * @since Method available since Release 3.3.0
     */
    static function assertXmlStringNotEqualsXmlFile($expectedFile, $actualXml, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertXmlStringNotEqualsXmlFile', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Asserts that two XML documents are not equal.
     *
     * @param string $expectedXml
     * @param string $actualXml
     * @param string $message
     *
     * @since Method available since Release 3.1.0
     */
    static function assertXmlStringNotEqualsXmlString($expectedXml, $actualXml, $message = '')
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::assertXmlStringNotEqualsXmlString', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a matcher that matches when the method is executed
     * at the given $index.
     *
     * @param int $index
     *
     * @return PHPUnit_Framework_MockObject_Matcher_InvokedAtIndex
     *
     * @since Method available since Release 3.0.0
     */
    static function at($index)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_TestCase::at', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a matcher that matches when the method is executed at least once.
     *
     * @return PHPUnit_Framework_MockObject_Matcher_InvokedAtLeastOnce
     *
     * @since Method available since Release 3.0.0
     */
    static function atLeastOnce()
    {
        try {
            return call_user_func_array('PHPUnit_Framework_TestCase::atLeastOnce', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_Attribute matcher object.
     *
     * @param PHPUnit_Framework_Constraint $constraint
     * @param string $attributeName
     *
     * @return PHPUnit_Framework_Constraint_Attribute
     *
     * @since Method available since Release 3.1.0
     */
    static function attribute(PHPUnit_Framework_Constraint $constraint, $attributeName)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::attribute', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_IsEqual matcher object
     * that is wrapped in a PHPUnit_Framework_Constraint_Attribute matcher
     * object.
     *
     * @param string $attributeName
     * @param mixed $value
     * @param float $delta
     * @param int $maxDepth
     * @param bool $canonicalize
     * @param bool $ignoreCase
     *
     * @return PHPUnit_Framework_Constraint_Attribute
     *
     * @since Method available since Release 3.1.0
     */
    static function attributeEqualTo($attributeName, $value, $delta = 0.0, $maxDepth = 10, $canonicalize = false, $ignoreCase = false)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::attributeEqualTo', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_Callback matcher object.
     *
     * @param callable $callback
     *
     * @return PHPUnit_Framework_Constraint_Callback
     */
    static function callback($callback)
    {
        return call_user_func_array('PHPUnit_Framework_Assert::callback', func_get_args());
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_ClassHasAttribute matcher object.
     *
     * @param string $attributeName
     *
     * @return PHPUnit_Framework_Constraint_ClassHasAttribute
     *
     * @since Method available since Release 3.1.0
     */
    static function classHasAttribute($attributeName)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::classHasAttribute', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_ClassHasStaticAttribute matcher
     * object.
     *
     * @param string $attributeName
     *
     * @return PHPUnit_Framework_Constraint_ClassHasStaticAttribute
     *
     * @since Method available since Release 3.1.0
     */
    static function classHasStaticAttribute($attributeName)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::classHasStaticAttribute', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_TraversableContains matcher
     * object.
     *
     * @param mixed $value
     * @param bool $checkForObjectIdentity
     * @param bool $checkForNonObjectIdentity
     *
     * @return PHPUnit_Framework_Constraint_TraversableContains
     *
     * @since Method available since Release 3.0.0
     */
    static function contains($value, $checkForObjectIdentity = true, $checkForNonObjectIdentity = false)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::contains', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_TraversableContainsOnly matcher
     * object.
     *
     * @param string $type
     *
     * @return PHPUnit_Framework_Constraint_TraversableContainsOnly
     *
     * @since Method available since Release 3.1.4
     */
    static function containsOnly($type)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::containsOnly', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_TraversableContainsOnly matcher
     * object.
     *
     * @param string $classname
     *
     * @return PHPUnit_Framework_Constraint_TraversableContainsOnly
     */
    static function containsOnlyInstancesOf($classname)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::containsOnlyInstancesOf', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_IsEqual matcher object.
     *
     * @param mixed $value
     * @param float $delta
     * @param int $maxDepth
     * @param bool $canonicalize
     * @param bool $ignoreCase
     *
     * @return PHPUnit_Framework_Constraint_IsEqual
     *
     * @since Method available since Release 3.0.0
     */
    static function equalTo($value, $delta = 0.0, $maxDepth = 10, $canonicalize = false, $ignoreCase = false)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::equalTo', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a matcher that matches when the method is executed
     * exactly $count times.
     *
     * @param int $count
     *
     * @return PHPUnit_Framework_MockObject_Matcher_InvokedCount
     *
     * @since Method available since Release 3.0.0
     */
    static function exactly($count)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_TestCase::exactly', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_FileExists matcher object.
     *
     * @return PHPUnit_Framework_Constraint_FileExists
     *
     * @since Method available since Release 3.0.0
     */
    static function fileExists()
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::fileExists', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_GreaterThan matcher object.
     *
     * @param mixed $value
     *
     * @return PHPUnit_Framework_Constraint_GreaterThan
     *
     * @since Method available since Release 3.0.0
     */
    static function greaterThan($value)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::greaterThan', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_Or matcher object that wraps
     * a PHPUnit_Framework_Constraint_IsEqual and a
     * PHPUnit_Framework_Constraint_GreaterThan matcher object.
     *
     * @param mixed $value
     *
     * @return PHPUnit_Framework_Constraint_Or
     *
     * @since Method available since Release 3.1.0
     */
    static function greaterThanOrEqual($value)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::greaterThanOrEqual', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_IsIdentical matcher object.
     *
     * @param mixed $value
     *
     * @return PHPUnit_Framework_Constraint_IsIdentical
     *
     * @since Method available since Release 3.0.0
     */
    static function identicalTo($value)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::identicalTo', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_IsEmpty matcher object.
     *
     * @return PHPUnit_Framework_Constraint_IsEmpty
     *
     * @since Method available since Release 3.5.0
     */
    static function isEmpty()
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::isEmpty', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_IsFalse matcher object.
     *
     * @return PHPUnit_Framework_Constraint_IsFalse
     *
     * @since Method available since Release 3.3.0
     */
    static function isFalse()
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::isFalse', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_IsInstanceOf matcher object.
     *
     * @param string $className
     *
     * @return PHPUnit_Framework_Constraint_IsInstanceOf
     *
     * @since Method available since Release 3.0.0
     */
    static function isInstanceOf($className)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::isInstanceOf', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_IsJson matcher object.
     *
     * @return PHPUnit_Framework_Constraint_IsJson
     *
     * @since Method available since Release 3.7.20
     */
    static function isJson()
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::isJson', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_IsNull matcher object.
     *
     * @return PHPUnit_Framework_Constraint_IsNull
     *
     * @since Method available since Release 3.3.0
     */
    static function isNull()
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::isNull', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_IsTrue matcher object.
     *
     * @return PHPUnit_Framework_Constraint_IsTrue
     *
     * @since Method available since Release 3.3.0
     */
    static function isTrue()
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::isTrue', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_IsType matcher object.
     *
     * @param string $type
     *
     * @return PHPUnit_Framework_Constraint_IsType
     *
     * @since Method available since Release 3.0.0
     */
    static function isType($type)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::isType', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_LessThan matcher object.
     *
     * @param mixed $value
     *
     * @return PHPUnit_Framework_Constraint_LessThan
     *
     * @since Method available since Release 3.0.0
     */
    static function lessThan($value)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::lessThan', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_Or matcher object that wraps
     * a PHPUnit_Framework_Constraint_IsEqual and a
     * PHPUnit_Framework_Constraint_LessThan matcher object.
     *
     * @param mixed $value
     *
     * @return PHPUnit_Framework_Constraint_Or
     *
     * @since Method available since Release 3.1.0
     */
    static function lessThanOrEqual($value)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::lessThanOrEqual', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_And matcher object.
     *
     * @return PHPUnit_Framework_Constraint_And
     *
     * @since Method available since Release 3.0.0
     */
    static function logicalAnd()
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::logicalAnd', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_Not matcher object.
     *
     * @param PHPUnit_Framework_Constraint $constraint
     *
     * @return PHPUnit_Framework_Constraint_Not
     *
     * @since Method available since Release 3.0.0
     */
    static function logicalNot(PHPUnit_Framework_Constraint $constraint)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::logicalNot', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_Or matcher object.
     *
     * @return PHPUnit_Framework_Constraint_Or
     *
     * @since Method available since Release 3.0.0
     */
    static function logicalOr()
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::logicalOr', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_Xor matcher object.
     *
     * @return PHPUnit_Framework_Constraint_Xor
     *
     * @since Method available since Release 3.0.0
     */
    static function logicalXor()
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::logicalXor', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_StringMatches matcher object.
     *
     * @param string $string
     *
     * @return PHPUnit_Framework_Constraint_StringMatches
     *
     * @since Method available since Release 3.5.0
     */
    static function matches($string)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::matches', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_PCREMatch matcher object.
     *
     * @param string $pattern
     *
     * @return PHPUnit_Framework_Constraint_PCREMatch
     *
     * @since Method available since Release 3.0.0
     */
    static function matchesRegularExpression($pattern)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::matchesRegularExpression', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a matcher that matches when the method is never executed.
     *
     * @return PHPUnit_Framework_MockObject_Matcher_InvokedCount
     *
     * @since Method available since Release 3.0.0
     */
    static function never()
    {
        try {
            return call_user_func_array('PHPUnit_Framework_TestCase::never', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_ObjectHasAttribute matcher object.
     *
     * @param string $attributeName
     *
     * @return PHPUnit_Framework_Constraint_ObjectHasAttribute
     *
     * @since Method available since Release 3.0.0
     */
    static function objectHasAttribute($attributeName)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::objectHasAttribute', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * @param mixed $value , ...
     *
     * @return PHPUnit_Framework_MockObject_Stub_ConsecutiveCalls
     *
     * @since Method available since Release 3.0.0
     */
    static function onConsecutiveCalls()
    {
        try {
            return call_user_func_array('PHPUnit_Framework_TestCase::onConsecutiveCalls', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a matcher that matches when the method is executed exactly once.
     *
     * @return PHPUnit_Framework_MockObject_Matcher_InvokedCount
     *
     * @since Method available since Release 3.0.0
     */
    static function once()
    {
        try {
            return call_user_func_array('PHPUnit_Framework_TestCase::once', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * @param array $valueMap
     *
     * @return PHPUnit_Framework_MockObject_Stub_ReturnValueMap
     *
     * @since Method available since Release 3.6.0
     */
    static function returnValueMap(array $valueMap)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_TestCase::returnValueMap', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_StringContains matcher object.
     *
     * @param string $string
     * @param bool $case
     *
     * @return PHPUnit_Framework_Constraint_StringContains
     *
     * @since Method available since Release 3.0.0
     */
    static function stringContains($string, $case = true)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::stringContains', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_StringEndsWith matcher object.
     *
     * @param mixed $suffix
     *
     * @return PHPUnit_Framework_Constraint_StringEndsWith
     *
     * @since Method available since Release 3.4.0
     */
    static function stringEndsWith($suffix)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::stringEndsWith', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * Returns a PHPUnit_Framework_Constraint_StringStartsWith matcher object.
     *
     * @param mixed $prefix
     *
     * @return PHPUnit_Framework_Constraint_StringStartsWith
     *
     * @since Method available since Release 3.4.0
     */
    static function stringStartsWith($prefix)
    {
        try {
            return call_user_func_array('PHPUnit_Framework_Assert::stringStartsWith', func_get_args());
        } catch (\Exception $e) {
            self::callSlack($e, debug_backtrace()[1]);
        }
    }

    /**
     * @param \Exception $e
     * @param array $arr
     * @throws Exception
     */
    private static function callSlack($e, $arr)
    {
        if (defined('SLACK_KEY')) {
            $slackPayload = new CL\Slack\Payload\ChatPostMessagePayload();

            $slackClient = new CL\Slack\Transport\ApiClient(SLACK_KEY);
            $slackPayload->setChannel(defined('SLACK_CHANNEL') ? '#tests' : SLACK_CHANNEL);
            $slackPayload->setUsername(defined('SLACK_NICK') ? 'Carthook' : SLACK_NICK);
            $slackPayload->setIconUrl(defined('SLACK_ICON') ? '' : SLACK_ICON);

            $slackPayload->setText("*Failure @ " . $arr['class'] . '::' . $arr['function'] . "() *" . PHP_EOL . $e->getMessage());

            try {
                $slackClient->send($slackPayload);
            } catch (\Exception $e) {
                // Something went wrong.
            }
        }

        throw $e;
    }
}
