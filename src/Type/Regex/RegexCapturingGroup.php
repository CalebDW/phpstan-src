<?php declare(strict_types = 1);

namespace PHPStan\Type\Regex;

use PHPStan\Type\Type;

final class RegexCapturingGroup
{

	private bool $forceNonOptional = false;

	public function __construct(
		private int $id,
		private ?string $name,
		private ?RegexAlternation $alternation,
		private bool $inOptionalQuantification,
		private RegexCapturingGroup|RegexNonCapturingGroup|null $parent,
		private Type $type,
	)
	{
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function forceNonOptional(): void
	{
		$this->forceNonOptional = true;
	}

	public function restoreNonOptional(): void
	{
		$this->forceNonOptional = false;
	}

	public function resetsGroupCounter(): bool
	{
		return $this->parent instanceof RegexNonCapturingGroup && $this->parent->resetsGroupCounter();
	}

	/**
	 * @phpstan-assert-if-true !null $this->getAlternationId()
	 * @phpstan-assert-if-true !null $this->getAlternation()
	 */
	public function inAlternation(): bool
	{
		return $this->alternation !== null;
	}

	public function getAlternation(): ?RegexAlternation
	{
		return $this->alternation;
	}

	public function getAlternationId(): ?int
	{
		if ($this->alternation === null) {
			return null;
		}

		return $this->alternation->getId();
	}

	public function isOptional(): bool
	{
		if ($this->forceNonOptional) {
			return false;
		}

		return $this->inAlternation()
			|| $this->inOptionalQuantification
			|| $this->parent !== null && $this->parent->isOptional();
	}

	public function inOptionalAlternation(): bool
	{
		if (!$this->inAlternation()) {
			return false;
		}

		$parent = $this->parent;
		while ($parent !== null && $parent->getAlternationId() === $this->getAlternationId()) {
			if (!$parent instanceof RegexNonCapturingGroup) {
				return false;
			}
			$parent = $parent->getParent();
		}
		return $parent !== null && $parent->isOptional();
	}

	public function isTopLevel(): bool
	{
		return $this->parent === null
			|| $this->parent instanceof RegexNonCapturingGroup && $this->parent->isTopLevel();
	}

	/** @phpstan-assert-if-true !null $this->getName() */
	public function isNamed(): bool
	{
		return $this->name !== null;
	}

	public function getName(): ?string
	{
		return $this->name;
	}

	public function getType(): Type
	{
		return $this->type;
	}

}