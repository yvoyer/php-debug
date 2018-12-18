<?php declare(strict_types=1);

namespace Star\Debug;

final class MemoryUsage {
	/**
	 * @var float
	 */
	private $value;

	/**
	 * @param float $value
	 */
	private function __construct(float $value) {
		$this->value = $value;
	}

	public function toString(): string {
		$value = abs($this->value); // todo offer ways to show negative values
		if ($value < 1024) {
			return $value . " bytes";
		} elseif ($value < 1048576) {
			return round($value / 1024, 2) . " kilobytes";
		}

        // todo add higher values
		return round($value / 1048576, 2) . " megabytes";
	}

	public function isNegative(): bool
	{
		return $this->value < 0;
	}

	public function diff(MemoryUsage $usage): MemoryUsage {
		return MemoryUsage::fromFloat($this->value - $usage->value);
	}

	public static function fromFloat(float $value): self {
		return new self($value);
	}

	public static function currentUsage(): self {
		return self::fromFloat(\memory_get_usage());
	}
}
