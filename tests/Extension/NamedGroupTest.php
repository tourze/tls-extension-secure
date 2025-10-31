<?php

declare(strict_types=1);

namespace Tourze\TLSExtensionSecure\Tests\Extension;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitEnum\AbstractEnumTestCase;
use Tourze\TLSExtensionSecure\Extension\NamedGroup;

/**
 * NamedGroup 测试类
 *
 * @internal
 */
#[CoversClass(NamedGroup::class)]
final class NamedGroupTest extends AbstractEnumTestCase
{
    /**
     * 测试枚举值
     */
    public function testEnumValues(): void
    {
        $this->assertEquals(0x0000, NamedGroup::RESERVED->value);
        $this->assertEquals(0x0017, NamedGroup::SECP256R1->value);
        $this->assertEquals(0x0018, NamedGroup::SECP384R1->value);
        $this->assertEquals(0x0019, NamedGroup::SECP521R1->value);
        $this->assertEquals(0x001D, NamedGroup::X25519->value);
        $this->assertEquals(0x001E, NamedGroup::X448->value);
        $this->assertEquals(0x0100, NamedGroup::FFDHE2048->value);
        $this->assertEquals(0x0101, NamedGroup::FFDHE3072->value);
        $this->assertEquals(0x0102, NamedGroup::FFDHE4096->value);
        $this->assertEquals(0x0103, NamedGroup::FFDHE6144->value);
        $this->assertEquals(0x0104, NamedGroup::FFDHE8192->value);
    }

    /**
     * 测试组名称
     */
    public function testGetName(): void
    {
        $this->assertEquals('reserved', NamedGroup::RESERVED->getName());
        $this->assertEquals('secp256r1', NamedGroup::SECP256R1->getName());
        $this->assertEquals('secp384r1', NamedGroup::SECP384R1->getName());
        $this->assertEquals('secp521r1', NamedGroup::SECP521R1->getName());
        $this->assertEquals('x25519', NamedGroup::X25519->getName());
        $this->assertEquals('x448', NamedGroup::X448->getName());
        $this->assertEquals('ffdhe2048', NamedGroup::FFDHE2048->getName());
        $this->assertEquals('ffdhe3072', NamedGroup::FFDHE3072->getName());
        $this->assertEquals('ffdhe4096', NamedGroup::FFDHE4096->getName());
        $this->assertEquals('ffdhe6144', NamedGroup::FFDHE6144->getName());
        $this->assertEquals('ffdhe8192', NamedGroup::FFDHE8192->getName());
    }

    /**
     * 测试组标签
     */
    public function testGetLabel(): void
    {
        $this->assertEquals('保留', NamedGroup::RESERVED->getLabel());
        $this->assertEquals('secp256r1 椭圆曲线', NamedGroup::SECP256R1->getLabel());
        $this->assertEquals('secp384r1 椭圆曲线', NamedGroup::SECP384R1->getLabel());
        $this->assertEquals('secp521r1 椭圆曲线', NamedGroup::SECP521R1->getLabel());
        $this->assertEquals('X25519 椭圆曲线', NamedGroup::X25519->getLabel());
        $this->assertEquals('X448 椭圆曲线', NamedGroup::X448->getLabel());
        $this->assertEquals('FFDHE2048 有限域', NamedGroup::FFDHE2048->getLabel());
        $this->assertEquals('FFDHE3072 有限域', NamedGroup::FFDHE3072->getLabel());
        $this->assertEquals('FFDHE4096 有限域', NamedGroup::FFDHE4096->getLabel());
        $this->assertEquals('FFDHE6144 有限域', NamedGroup::FFDHE6144->getLabel());
        $this->assertEquals('FFDHE8192 有限域', NamedGroup::FFDHE8192->getLabel());
    }

    /**
     * 测试椭圆曲线检查
     */
    public function testIsEllipticCurve(): void
    {
        // 椭圆曲线组
        $this->assertTrue(NamedGroup::SECP256R1->isEllipticCurve());
        $this->assertTrue(NamedGroup::SECP384R1->isEllipticCurve());
        $this->assertTrue(NamedGroup::SECP521R1->isEllipticCurve());
        $this->assertTrue(NamedGroup::X25519->isEllipticCurve());
        $this->assertTrue(NamedGroup::X448->isEllipticCurve());

        // 非椭圆曲线组
        $this->assertFalse(NamedGroup::RESERVED->isEllipticCurve());
        $this->assertFalse(NamedGroup::FFDHE2048->isEllipticCurve());
        $this->assertFalse(NamedGroup::FFDHE3072->isEllipticCurve());
        $this->assertFalse(NamedGroup::FFDHE4096->isEllipticCurve());
        $this->assertFalse(NamedGroup::FFDHE6144->isEllipticCurve());
        $this->assertFalse(NamedGroup::FFDHE8192->isEllipticCurve());
    }

    /**
     * 测试有限域检查
     */
    public function testIsFiniteField(): void
    {
        // 有限域组
        $this->assertTrue(NamedGroup::FFDHE2048->isFiniteField());
        $this->assertTrue(NamedGroup::FFDHE3072->isFiniteField());
        $this->assertTrue(NamedGroup::FFDHE4096->isFiniteField());
        $this->assertTrue(NamedGroup::FFDHE6144->isFiniteField());
        $this->assertTrue(NamedGroup::FFDHE8192->isFiniteField());

        // 非有限域组
        $this->assertFalse(NamedGroup::RESERVED->isFiniteField());
        $this->assertFalse(NamedGroup::SECP256R1->isFiniteField());
        $this->assertFalse(NamedGroup::SECP384R1->isFiniteField());
        $this->assertFalse(NamedGroup::SECP521R1->isFiniteField());
        $this->assertFalse(NamedGroup::X25519->isFiniteField());
        $this->assertFalse(NamedGroup::X448->isFiniteField());
    }

    /**
     * 测试推荐组
     */
    public function testGetRecommendedGroups(): void
    {
        $recommendedGroups = NamedGroup::getRecommendedGroups();

        $this->assertNotEmpty($recommendedGroups);

        // 检查推荐组包含预期的组
        $this->assertContains(NamedGroup::X25519, $recommendedGroups);
        $this->assertContains(NamedGroup::SECP256R1, $recommendedGroups);
        $this->assertContains(NamedGroup::SECP384R1, $recommendedGroups);
        $this->assertContains(NamedGroup::SECP521R1, $recommendedGroups);
        $this->assertContains(NamedGroup::FFDHE2048, $recommendedGroups);
        $this->assertContains(NamedGroup::FFDHE3072, $recommendedGroups);

        // 检查推荐组的顺序（X25519 应该是第一个）
        $this->assertEquals(NamedGroup::X25519, $recommendedGroups[0]);
    }

    /**
     * 测试所有组都有名称
     */
    public function testAllGroupsHaveNames(): void
    {
        foreach (NamedGroup::cases() as $group) {
            $this->assertNotEmpty($group->getName());
        }
    }

    /**
     * 测试所有组都有标签
     */
    public function testAllGroupsHaveLabels(): void
    {
        foreach (NamedGroup::cases() as $group) {
            $this->assertNotEmpty($group->getLabel());
        }
    }

    /**
     * 测试组分类互斥性
     */
    public function testGroupCategoryMutualExclusion(): void
    {
        foreach (NamedGroup::cases() as $group) {
            // 椭圆曲线和有限域应该是互斥的（除了保留组）
            if (NamedGroup::RESERVED !== $group) {
                $this->assertNotEquals(
                    $group->isEllipticCurve(),
                    $group->isFiniteField(),
                    "Group {$group->getName()} should be either elliptic curve or finite field, not both or neither"
                );
            }
        }
    }

    /**
     * 测试toArray方法
     */
    public function testToArray(): void
    {
        $group = NamedGroup::SECP256R1;
        $result = $group->toArray();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('value', $result);
        $this->assertArrayHasKey('label', $result);
        $this->assertCount(2, $result);

        $this->assertEquals($group->value, $result['value']);
        $this->assertEquals($group->getLabel(), $result['label']);

        // 测试不同的组
        $group2 = NamedGroup::X25519;
        $result2 = $group2->toArray();

        $this->assertEquals(0x001D, $result2['value']);
        $this->assertEquals('X25519 椭圆曲线', $result2['label']);

        // 测试保留组
        $reserved = NamedGroup::RESERVED;
        $reservedResult = $reserved->toArray();

        $this->assertEquals(0x0000, $reservedResult['value']);
        $this->assertEquals('保留', $reservedResult['label']);
    }

    /**
     * 测试toSelectItem方法
     */
}
