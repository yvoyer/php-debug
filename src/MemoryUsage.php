<?php declare(strict_types=1);

namespace Star\Debug;

final class MemoryUsage {
	/**
	 * @var float
	 */
	private $value;

	private $maps = [
        ' bytes',
        ' kilobytes',
        ' megabytes',
        ' gigabytes',
    ];

	/**
	 * @param float $value
	 */
	private function __construct(float $value) {
		$this->value = $value;
	}

	public function toString(): string {
		$value = abs($this->value); // todo offer ways to show negative values
        $selectedSuffix = $this->maps[0];
        foreach ($this->maps as $map) {
            if ($value >= 1024) {
                $value /= 1024;
                continue;
            }

            $selectedSuffix = $map;
            break;
        }

        // todo add higher values
		return round($value / 1048576, 2) . $selectedSuffix;
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
