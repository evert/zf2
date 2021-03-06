<?php

namespace ZendTest\Code\Scanner;

use Zend\Code\Scanner\FileScanner,
    PHPUnit_Framework_TestCase as TestCase;

class ClassScannerTest extends TestCase
{
    public function testClassScannerHasClassInformation()
    {
        $file  = new FileScanner(__DIR__ . '/../TestAsset/FooClass.php');
        $class = $file->getClass('ZendTest\Code\TestAsset\FooClass');
        $this->assertEquals('ZendTest\Code\TestAsset\FooClass', $class->getName());
        $this->assertEquals('FooClass', $class->getShortName());
        $this->assertFalse($class->isFinal());
        $this->assertTrue($class->isAbstract());
        $this->assertFalse($class->isInterface());
        $interfaces = $class->getInterfaces();
        $this->assertContains('ArrayAccess', $interfaces);
        $this->assertContains('A\B\C\D\Blarg', $interfaces);
        $this->assertContains('ZendTest\Code\TestAsset\Local\SubClass', $interfaces);
        $methods = $class->getMethods();
        $this->assertInternalType('array', $methods);
        $this->assertContains('fooBarBaz', $methods);
    }

    public function testClassScannerHasConstant()
    {
        $file  = new FileScanner(__DIR__ . '/../TestAsset/FooClass.php');
        $class = $file->getClass('ZendTest\Code\TestAsset\FooClass');
        $this->assertInternalType('array', $class->getConstants());
    }

    public function testClassScannerHasProperties()
    {
        $file  = new FileScanner(__DIR__ . '/../TestAsset/FooClass.php');
        $class = $file->getClass('ZendTest\Code\TestAsset\FooClass');
        $this->assertInternalType('array', $class->getProperties());
        $this->assertContains('bar', $class->getProperties());
    }

    public function testClassScannerHasMethods()
    {
        $file  = new FileScanner(__DIR__ . '/../TestAsset/FooClass.php');
        $class = $file->getClass('ZendTest\Code\TestAsset\FooClass');
        $this->assertContains('fooBarBaz', $class->getMethods());
    }

    public function testClassScannerReturnsMethodsWithMethodScanners()
    {
        $file    = new FileScanner(__DIR__ . '/../TestAsset/FooClass.php');
        $class   = $file->getClass('ZendTest\Code\TestAsset\FooClass');
        $methods = $class->getMethods(true);
        foreach ($methods as $method) {
            $this->assertInstanceOf('Zend\Code\Scanner\MethodScanner', $method);
        }
    }

}
