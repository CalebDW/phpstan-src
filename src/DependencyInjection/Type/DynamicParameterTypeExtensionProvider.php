<?php declare(strict_types = 1);

namespace PHPStan\DependencyInjection\Type;

use PHPStan\Type\DynamicFunctionParameterTypeExtension;
use PHPStan\Type\DynamicMethodParameterTypeExtension;
use PHPStan\Type\DynamicStaticMethodParameterTypeExtension;

interface DynamicParameterTypeExtensionProvider
{

	/** @return DynamicFunctionParameterTypeExtension[] */
	public function getDynamicFunctionParameterTypeExtensions(): array;

	/** @return DynamicMethodParameterTypeExtension[] */
	public function getDynamicMethodParameterTypeExtensions(): array;

	/** @return DynamicStaticMethodParameterTypeExtension[] */
	public function getDynamicStaticMethodParameterTypeExtensions(): array;

}
