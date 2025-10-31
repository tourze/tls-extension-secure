<?php

declare(strict_types=1);

namespace Tourze\TLSExtensionSecure\Tests\Exception;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitBase\AbstractExceptionTestCase;
use Tourze\TLSExtensionSecure\Exception\InvalidExtensionDataException;

/**
 * InvalidExtensionDataException 测试类
 *
 * @internal
 */
#[CoversClass(InvalidExtensionDataException::class)]
final class InvalidExtensionDataExceptionTest extends AbstractExceptionTestCase
{
    /**
     * 测试异常类继承关系
     */
    public function testInheritance(): void
    {
        $exception = new InvalidExtensionDataException();
        $this->assertInstanceOf(\InvalidArgumentException::class, $exception);
        $this->assertInstanceOf(\Exception::class, $exception);
    }

    /**
     * 测试异常消息
     */
    public function testMessage(): void
    {
        $message = 'Test extension data is invalid';
        $exception = new InvalidExtensionDataException($message);
        $this->assertEquals($message, $exception->getMessage());
    }

    /**
     * 测试异常代码
     */
    public function testCode(): void
    {
        $code = 1001;
        $exception = new InvalidExtensionDataException('Test message', $code);
        $this->assertEquals($code, $exception->getCode());
    }

    /**
     * 测试异常链
     */
    public function testPrevious(): void
    {
        $previous = new \RuntimeException('Previous exception');
        $exception = new InvalidExtensionDataException('Test message', 0, $previous);
        $this->assertSame($previous, $exception->getPrevious());
    }

    /**
     * 测试默认构造
     */
    public function testDefaultConstruction(): void
    {
        $exception = new InvalidExtensionDataException();
        $this->assertEquals('', $exception->getMessage());
        $this->assertEquals(0, $exception->getCode());
        $this->assertNull($exception->getPrevious());
    }
}
