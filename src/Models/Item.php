<?php

namespace Drewdan\RoyalMailPricing\Models;

class Item {

	public string $name;
	public float $weight;
	public float $length;
	public float $width;
	public float $height;

	public function getName(): string {
		return $this->name;
	}


	public function setName(string $name): self {
		$this->name = $name;

		return $this;
	}

	public function getWeight(): float {
		return $this->weight;
	}

	public function setWeight(float $weight): self {
		$this->weight = $weight;

		return $this;
	}

	public function getLength(): float {
		return $this->length;
	}

	public function setLength(float $length): self {
		$this->length = $length;

		return $this;
	}

	public function getWidth(): float {
		return $this->width;
	}

	public function setWidth(float $width): self {
		$this->width = $width;

		return $this;
	}

	public function getHeight(): float {
		return $this->height;
	}

	public function setHeight(float $height): self {
		$this->height = $height;

		return $this;
	}

	public static function make(): Item {
		return new Item;
	}

}
