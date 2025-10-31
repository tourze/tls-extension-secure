<?php

declare(strict_types=1);

namespace Tourze\TLSExtensionSecure\Tests\Extension;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\TLSExtensionNaming\Extension\ExtensionType;
use Tourze\TLSExtensionSecure\Extension\SupportedGroupsExtension;

/**
 * 支持的组扩展测试类
 *
 * @internal
 */
#[CoversClass(SupportedGroupsExtension::class)]
final class SupportedGroupsExtensionTest extends TestCase
{
    /**
     * 测试扩展类型是否正确
     */
    public function testType(): void
    {
        $extension = new SupportedGroupsExtension();
        $this->assertEquals(ExtensionType::SUPPORTED_GROUPS->value, $extension->getType());
    }

    /**
     * 测试设置和获取支持的组
     */
    public function testSetAndGetGroups(): void
    {
        $extension = new SupportedGroupsExtension();

        // 测试默认值
        $this->assertEmpty($extension->getGroups());

        // 测试设置组
        $groups = [0x0017, 0x0018, 0x0019]; // secp256r1, secp384r1, secp521r1
        $extension->setGroups($groups);
        $this->assertEquals($groups, $extension->getGroups());

        // 测试添加组
        $extension = new SupportedGroupsExtension();
        $extension->addGroup(0x0017); // secp256r1
        $extension->addGroup(0x0018); // secp384r1
        $this->assertEquals([0x0017, 0x0018], $extension->getGroups());
    }

    /**
     * 测试扩展的编码和解码
     */
    public function testEncodeAndDecode(): void
    {
        $originalExtension = new SupportedGroupsExtension();
        $originalExtension->setGroups([0x0017, 0x0018]); // secp256r1, secp384r1

        // 编码
        $encodedData = $originalExtension->encode();
        $this->assertNotEmpty($encodedData);

        // 解码
        $decodedExtension = SupportedGroupsExtension::decode($encodedData);

        // 验证解码后的扩展与原始扩展相同
        $this->assertEquals($originalExtension->getGroups(), $decodedExtension->getGroups());
    }

    /**
     * 测试编码格式是否符合RFC规范
     */
    public function testEncodeFormat(): void
    {
        $extension = new SupportedGroupsExtension();
        $extension->setGroups([0x0017, 0x0018]); // secp256r1, secp384r1

        $encoded = $extension->encode();

        // 扩展数据应为：
        // - 2字节的组列表长度 (0004) - 4字节，2个组
        // - 2字节的第一个组 (0017) - secp256r1
        // - 2字节的第二个组 (0018) - secp384r1
        $expected = hex2bin('0004') . hex2bin('0017') . hex2bin('0018');

        $this->assertEquals($expected, $encoded);
    }

    /**
     * 测试解码无效数据时的异常处理
     */
    public function testDecodeInvalidData(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        // 创建无效的数据 (长度字段表示有2个字节的数据，但实际只有1个字节)
        $invalidData = hex2bin('0002') . hex2bin('00');

        SupportedGroupsExtension::decode($invalidData);
    }

    /**
     * 测试TLS版本兼容性
     */
    public function testVersionCompatibility(): void
    {
        $extension = new SupportedGroupsExtension();

        // 此扩展应适用于TLS 1.2和TLS 1.3
        $this->assertTrue($extension->isApplicableForVersion('1.2'));
        $this->assertTrue($extension->isApplicableForVersion('1.3'));
    }

    /**
     * 测试添加组功能
     */
    public function testAddGroup(): void
    {
        $extension = new SupportedGroupsExtension();

        // 初始状态为空
        $this->assertEmpty($extension->getGroups());

        // 添加第一个组
        $result = $extension->addGroup(0x0017); // secp256r1
        $this->assertSame($extension, $result); // 验证返回自身以支持链式调用
        $this->assertEquals([0x0017], $extension->getGroups());

        // 添加第二个组
        $extension->addGroup(0x0018); // secp384r1
        $this->assertEquals([0x0017, 0x0018], $extension->getGroups());

        // 尝试重复添加同一个组（不应重复）
        $extension->addGroup(0x0017); // secp256r1
        $this->assertEquals([0x0017, 0x0018], $extension->getGroups());

        // 添加第三个不同的组
        $extension->addGroup(0x001D); // x25519
        $this->assertEquals([0x0017, 0x0018, 0x001D], $extension->getGroups());

        // 验证组的顺序保持添加顺序
        $newExtension = new SupportedGroupsExtension();
        $newExtension->addGroup(0x001D) // x25519
            ->addGroup(0x0017)  // secp256r1
            ->addGroup(0x0018) // secp384r1
        ;
        $this->assertEquals([0x001D, 0x0017, 0x0018], $newExtension->getGroups());
    }
}
