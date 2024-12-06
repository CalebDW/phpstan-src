<?php declare(strict_types = 1);

namespace PHPStan\DependencyInjection\Type;

use PHPStan\DependencyInjection\Container;

final class LazyDynamicParameterTypeExtensionProvider implements DynamicParameterTypeExtensionProvider
{

	public const FUNCTION_TAG = 'phpstan.dynamicFunctionParameterTypeExtension';
	public const METHOD_TAG = 'phpstan.dynamicMethodParameterTypeExtension';
	public const STATIC_METHOD_TAG = 'phpstan.dynamicStaticMethodParameterTypeExtension';

	public function __construct(private Container $container)
	{
	}

	public function getDynamicFunctionParameterTypeExtensions(): array
	{
		return $this->container->getServicesByTag(self::FUNCTION_TAG);
	}

	public function getDynamicMethodParameterTypeExtensions(): array
	{
		return $this->container->getServicesByTag(self::METHOD_TAG);
	}

	public function getDynamicStaticMethodParameterTypeExtensions(): array
	{
		return $this->container->getServicesByTag(self::STATIC_METHOD_TAG);
	}

}
