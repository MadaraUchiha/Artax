<?php

class NotifierTraitTest extends PHPUnit_Framework_TestCase
{
  /**
   * @covers Artax\Events\NotifierTrait::notify
   */
  public function testNotifySendsMessageToMediatorIfSet()
  {
    $stub = $this->getMock('MockMediatorBecausePHPUnitChokesOnCallableTypehint');
    $stub->expects($this->once())
         ->method('notify')
         ->will($this->returnArgument(0));
      
    $n = new NotifierTraitImplementationClass($stub);
    $this->assertEquals('test.event', $n->notify('test.event'));
  }
  
  /**
   * @covers Artax\Events\NotifierTrait::notify
   */
  public function testNotifySendsObjectInstanceOnNullDataParameter()
  {
    $stub = $this->getMock('MockMediatorBecausePHPUnitChokesOnCallableTypehint');
    $stub->expects($this->once())
         ->method('notify')
         ->will($this->returnArgument(1));
      
    $n = new NotifierTraitImplementationClass($stub);
    $this->assertEquals($n, $n->notify('test.event'));
  }
  
  /**
   * @covers Artax\Events\NotifierTrait::notify
   */
  public function testNotifyDoesNothingIfMediatorIsNull()
  {      
    $n = new NotifierTraitImplementationClass();
  }
}

class MockMediatorBecausePHPUnitChokesOnCallableTypehint
{
  public function notify($event)
  {
  }
}

class NotifierTraitImplementationClass
{
  use Artax\Events\NotifierTrait;
  
  public function __construct($mediator=NULL)
  {
    $this->mediator = $mediator;
  }
}
