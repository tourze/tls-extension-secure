# TLS Extension Secure

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/tls-extension-secure.svg?style=flat-square)](https://packagist.org/packages/tourze/tls-extension-secure)
[![Total Downloads](https://img.shields.io/packagist/dt/tourze/tls-extension-secure.svg?style=flat-square)](https://packagist.org/packages/tourze/tls-extension-secure)
[![PHP Version](https://img.shields.io/packagist/php-v/tourze/tls-extension-secure.svg?style=flat-square)](https://packagist.org/packages/tourze/tls-extension-secure)
[![License](https://img.shields.io/packagist/l/tourze/tls-extension-secure.svg?style=flat-square)](https://packagist.org/packages/tourze/tls-extension-secure)
[![Coverage Status](https://img.shields.io/codecov/c/github/tourze/php-monorepo.svg?style=flat-square)](https://codecov.io/gh/tourze/php-monorepo)

A PHP library for implementing security-related TLS extensions. This package provides
implementations for TLS extensions that enhance the security of TLS connections,
particularly focusing on Supported Groups extension for elliptic curve and finite
field group negotiation.

## Features

- **Supported Groups Extension**: Implements the TLS Supported Groups extension (RFC 8446 Section 4.2.7)
- **Named Group Enumeration**: Comprehensive enumeration of standard elliptic curves and finite field groups
- **TLS 1.2 & 1.3 Compatibility**: Works with both TLS 1.2 (elliptic_curves) and TLS 1.3 (supported_groups)
- **Binary Encoding/Decoding**: Full support for TLS wire format encoding and decoding
- **Recommended Defaults**: Provides industry-standard recommended group configurations

## Installation

```bash
composer require tourze/tls-extension-secure
```

## Requirements

- PHP 8.1 or higher
- tourze/enum-extra
- tourze/tls-common
- tourze/tls-extension-naming

## Quick Start

### Basic Usage

```php
<?php

use Tourze\TLSExtensionSecure\Extension\SupportedGroupsExtension;
use Tourze\TLSExtensionSecure\Extension\NamedGroup;

// Create a Supported Groups extension
$extension = new SupportedGroupsExtension();

// Add specific groups
$extension->addGroup(NamedGroup::X25519->value);
$extension->addGroup(NamedGroup::SECP256R1->value);

// Or set multiple groups at once
$extension->setGroups([
    NamedGroup::X25519->value,
    NamedGroup::SECP256R1->value,
    NamedGroup::SECP384R1->value,
]);

// Use recommended defaults
$extension->setRecommendedGroups();

// Encode to binary format
$binaryData = $extension->encode();

// Decode from binary format
$decodedExtension = SupportedGroupsExtension::decode($binaryData);
```

### Working with Named Groups

```php
<?php

use Tourze\TLSExtensionSecure\Extension\NamedGroup;

// Get all recommended groups
$recommendedGroups = NamedGroup::getRecommendedGroups();

// Check group types
$group = NamedGroup::X25519;
$isEllipticCurve = $group->isEllipticCurve(); // true
$isFiniteField = $group->isFiniteField(); // false

// Get group information
$name = $group->getName(); // "x25519"
$label = $group->getLabel(); // "X25519 椭圆曲线"
```

### TLS Version Compatibility

```php
<?php

use Tourze\TLSExtensionSecure\Extension\SupportedGroupsExtension;

$extension = new SupportedGroupsExtension();

// Check version compatibility
$supportsTLS12 = $extension->isApplicableForVersion('1.2'); // true
$supportsTLS13 = $extension->isApplicableForVersion('1.3'); // true
```

## API Reference

### SupportedGroupsExtension

- `getType(): int` - Returns the extension type identifier
- `getGroups(): array` - Returns array of supported group identifiers
- `setGroups(array $groups): self` - Sets the supported groups
- `addGroup(int $group): self` - Adds a single group
- `encode(): string` - Encodes to TLS wire format
- `decode(string $data): static` - Decodes from TLS wire format
- `setRecommendedGroups(): self` - Sets industry-recommended groups
- `isApplicableForVersion(string $version): bool` - Checks TLS version compatibility

### NamedGroup

- `getName(): string` - Returns the group name
- `getLabel(): string` - Returns the display label
- `isEllipticCurve(): bool` - Checks if group is an elliptic curve
- `isFiniteField(): bool` - Checks if group is a finite field
- `getRecommendedGroups(): array` - Returns recommended groups for TLS 1.3

## Supported Groups

### Elliptic Curve Groups
- **secp256r1** (0x0017) - P-256 curve
- **secp384r1** (0x0018) - P-384 curve  
- **secp521r1** (0x0019) - P-521 curve
- **X25519** (0x001D) - Curve25519 (recommended)
- **X448** (0x001E) - Curve448

### Finite Field Groups
- **ffdhe2048** (0x0100) - 2048-bit MODP group
- **ffdhe3072** (0x0101) - 3072-bit MODP group
- **ffdhe4096** (0x0102) - 4096-bit MODP group
- **ffdhe6144** (0x0103) - 6144-bit MODP group
- **ffdhe8192** (0x0104) - 8192-bit MODP group

## Contributing

Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
