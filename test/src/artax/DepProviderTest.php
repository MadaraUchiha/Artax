<?php

class DepProviderTest extends PHPUnit_Framework_TestCase
{
  public function testBeginsEmpty()
  {
    $dp = new artax\DepProvider(new artax\DotNotation);
    $this->assertEmpty($dp->all());
    return $dp;
  }
  
  /**
   * @depends testBeginsEmpty
   * @covers artax\DepProvider::make
   * @covers artax\DepProvider::getInjectedInstance
   * @covers artax\DepProvider::parseConstructorArgs
   */
  public function testMakeReturnsInjectedFromReflection($dp)
  {
    $injected = $dp->make('TestNeedsDep');
    $this->assertEquals($injected, new TestNeedsDep(new TestDependency));
  }
  
  /**
   * @depends testBeginsEmpty
   * @covers artax\DepProvider::make
   * @covers artax\DepProvider::getInjectedInstance
   */
  public function testMakeReturnsCustomObjectValsIfPassed($dp)
  {
    $dep = new TestDependency;
    $dep->testProp = 'something';
    $custom   = ['testDep'=>$dep];
    $injected = $dp->make('TestNeedsDep', $custom);
    $this->assertEquals($injected->testDep, $dep);
  }
  
  /**
   * @depends testBeginsEmpty
   * @covers artax\DepProvider::make
   * @covers artax\DepProvider::getInjectedInstance
   */
  public function testMakeReturnsInjectedUsingBucketSpecifiedClassNames($dp)
  {
    $specdVals = ['testDep'=>'SpecdTestDependency'];
    $dp->set('TestNeedsDep', $specdVals);
    $injected = $dp->make('TestNeedsDep');
    $this->assertEquals($injected, new TestNeedsDep(new SpecdTestDependency));
  }
}

class TestDependency
{
  public $testProp = 'testVal';
}

class SpecdTestDependency extends TestDependency
{
  public $testProp = 'testVal';
}

class TestNeedsDep
{
  public $testDep;
  public function __construct(TestDependency $testDep)
  {
    $this->testDep = $testDep;
  }
}
