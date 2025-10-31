# TLS Extension Secure

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/tls-extension-secure.svg?style=flat-square)](https://packagist.org/packages/tourze/tls-extension-secure)
[![Total Downloads](https://img.shields.io/packagist/dt/tourze/tls-extension-secure.svg?style=flat-square)](https://packagist.org/packages/tourze/tls-extension-secure)
[![PHP Version](https://img.shields.io/packagist/php-v/tourze/tls-extension-secure.svg?style=flat-square)](https://packagist.org/packages/tourze/tls-extension-secure)
[![License](https://img.shields.io/packagist/l/tourze/tls-extension-secure.svg?style=flat-square)](https://packagist.org/packages/tourze/tls-extension-secure)
[![Coverage Status](https://img.shields.io/codecov/c/github/tourze/php-monorepo.svg?style=flat-square)](https://codecov.io/gh/tourze/php-monorepo)

一个用于实现安全相关 TLS 扩展的 PHP 库。该包提供了增强 TLS 连接安全性的扩展实现，特别专注于支持的组扩展，用于椭圆曲线和有限域组协商。

## 功能特性

- **支持的组扩展**: 实现 TLS 支持的组扩展 (RFC 8446 第 4.2.7 节)
- **命名组枚举**: 标准椭圆曲线和有限域组的全面枚举
- **TLS 1.2 & 1.3 兼容性**: 兼容 TLS 1.2 (elliptic_curves) 和 TLS 1.3 (supported_groups)
- **二进制编码/解码**: 完整支持 TLS 线格式编码和解码
- **推荐默认值**: 提供行业标准推荐组配置

## 安装

```bash
composer require tourze/tls-extension-secure
```

## 环境要求

- PHP 8.1 或更高版本
- tourze/enum-extra
- tourze/tls-common
- tourze/tls-extension-naming

## 快速开始

### 基本用法

```php
<?php

use Tourze\TLSExtensionSecure\Extension\SupportedGroupsExtension;
use Tourze\TLSExtensionSecure\Extension\NamedGroup;

// 创建支持的组扩展
$extension = new SupportedGroupsExtension();

// 添加特定组
$extension->addGroup(NamedGroup::X25519->value);
$extension->addGroup(NamedGroup::SECP256R1->value);

// 或者一次设置多个组
$extension->setGroups([
    NamedGroup::X25519->value,
    NamedGroup::SECP256R1->value,
    NamedGroup::SECP384R1->value,
]);

// 使用推荐默认值
$extension->setRecommendedGroups();

// 编码为二进制格式
$binaryData = $extension->encode();

// 从二进制格式解码
$decodedExtension = SupportedGroupsExtension::decode($binaryData);
```

### 使用命名组

```php
<?php

use Tourze\TLSExtensionSecure\Extension\NamedGroup;

// 获取所有推荐组
$recommendedGroups = NamedGroup::getRecommendedGroups();

// 检查组类型
$group = NamedGroup::X25519;
$isEllipticCurve = $group->isEllipticCurve(); // true
$isFiniteField = $group->isFiniteField(); // false

// 获取组信息
$name = $group->getName(); // "x25519"
$label = $group->getLabel(); // "X25519 椭圆曲线"
```

### TLS 版本兼容性

```php
<?php

use Tourze\TLSExtensionSecure\Extension\SupportedGroupsExtension;

$extension = new SupportedGroupsExtension();

// 检查版本兼容性
$supportsTLS12 = $extension->isApplicableForVersion('1.2'); // true
$supportsTLS13 = $extension->isApplicableForVersion('1.3'); // true
```

## API 参考

### SupportedGroupsExtension

- `getType(): int` - 返回扩展类型标识符
- `getGroups(): array` - 返回支持的组标识符数组
- `setGroups(array $groups): self` - 设置支持的组
- `addGroup(int $group): self` - 添加单个组
- `encode(): string` - 编码为 TLS 线格式
- `decode(string $data): static` - 从 TLS 线格式解码
- `setRecommendedGroups(): self` - 设置行业推荐组
- `isApplicableForVersion(string $version): bool` - 检查 TLS 版本兼容性

### NamedGroup

- `getName(): string` - 返回组名称
- `getLabel(): string` - 返回显示标签
- `isEllipticCurve(): bool` - 检查组是否为椭圆曲线
- `isFiniteField(): bool` - 检查组是否为有限域
- `getRecommendedGroups(): array` - 返回 TLS 1.3 推荐组

## 支持的组

### 椭圆曲线组
- **secp256r1** (0x0017) - P-256 曲线
- **secp384r1** (0x0018) - P-384 曲线
- **secp521r1** (0x0019) - P-521 曲线
- **X25519** (0x001D) - Curve25519 (推荐)
- **X448** (0x001E) - Curve448

### 有限域组
- **ffdhe2048** (0x0100) - 2048 位 MODP 组
- **ffdhe3072** (0x0101) - 3072 位 MODP 组
- **ffdhe4096** (0x0102) - 4096 位 MODP 组
- **ffdhe6144** (0x0103) - 6144 位 MODP 组
- **ffdhe8192** (0x0104) - 8192 位 MODP 组

## 贡献

请参阅 [CONTRIBUTING.md](CONTRIBUTING.md) 了解详情。

## 许可证

MIT 许可证。请查看 [License File](LICENSE) 获取更多信息。
