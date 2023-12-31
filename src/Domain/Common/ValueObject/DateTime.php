<?php

declare(strict_types=1);

namespace App\Domain\Common\ValueObject;

use DateTimeImmutable;
use DateTimeInterface;
use InvalidArgumentException;
use Stringable;

final class DateTime implements Stringable
{
    /** @var string Constant for date format. */
    private const FORMAT = 'c';

    /** @var string The underlying date. */
    private readonly string $date;

    private function __construct(
        string $date
    ) {
        if (!DateTimeImmutable::createFromFormat(self::FORMAT, $date)) {
            throw new InvalidArgumentException(sprintf('Invalid date provided: \'%s\' Format: \'%s\'.', $date, self::FORMAT));
        }

        $this->date = $date;
    }

    /**
     * Create an instance from a string.
     *
     * @param string $dateString the date string
     */
    public static function fromString(string $dateString): self
    {
        return new self($dateString);
    }

    /**
     * Create an instance from a DateTimeInterface.
     *
     * @param DateTimeInterface $dateTime the date
     */
    public static function fromDateTimeInterface(DateTimeInterface $dateTime): self
    {
        $dateString = $dateTime->format(self::FORMAT);

        return new self($dateString);
    }

    /**
     * Get a string representation of this object.
     *
     * @return string the date in a string format
     */
    public function __toString(): string
    {
        return $this->date;
    }

    /**
     * Format the object as a string, using the PHP DateTime formatting options.
     */
    public function format(string $formatString): string
    {
        $immutable = $this->toDateTimeImmutable();

        return $immutable->format($formatString);
    }

    /**
     * Get a DateTimeImmutable version of this object.
     *
     * @return DateTimeImmutable the date in a DateTimeImmutable format
     */
    public function toDateTimeImmutable(): DateTimeImmutable
    {
        /** @var DateTimeImmutable $dateTimeImmutable */
        $dateTimeImmutable = DateTimeImmutable::createFromFormat(self::FORMAT, $this->date);

        return $dateTimeImmutable;
    }

    /**
     * Test for equality between dates.
     *
     * @param DateTime $dateTime the date to compare to
     *
     * @return bool true if the two objects are equal
     */
    public function equals(DateTime $dateTime): bool
    {
        return (string) $dateTime === (string) $this->date;
    }

    /**
     * Determine if this date occurs before another date.
     */
    public function isBefore(DateTime $other): bool
    {
        return $this->toTimestamp() < $other->toTimestamp();
    }

    /**
     * Determine if this date occurs after another date.
     */
    public function isAfter(DateTime $other): bool
    {
        return $this->toTimestamp() > $other->toTimestamp();
    }

    /**
     * Create a DateTime object from a timestamp in seconds.
     */
    public static function fromTimestamp(int $timestamp): self
    {
        $immutable = DateTimeImmutable::createFromFormat('U', (string) $timestamp);

        if (!$immutable) {
            throw new InvalidArgumentException('Invalid timestamp');
        }

        return static::fromDateTimeInterface($immutable);
    }

    /**
     * Create a DateTime object from a timestamp in milliseconds.
     */
    public static function fromMillisecondsTimestamp(int $timestamp): self
    {
        // Convert to seconds, storing the fractional milliseconds separately.
        $seconds = floor($timestamp / 1000);
        $fractionalMilliseconds = $timestamp - ($seconds * 1000);

        $immutable = DateTimeImmutable::createFromFormat('U.u', (string) $seconds.'.'.$fractionalMilliseconds);

        if (!$immutable) {
            throw new InvalidArgumentException('Invalid timestamp');
        }

        // We now have the correct milliseconds value, though we will lose this resolution when converting to string.

        return static::fromDateTimeInterface($immutable);
    }

    /**
     * Get a timestamp representation of the date.
     */
    public function toTimestamp(): int
    {
        return (int) $this->toDateTimeImmutable()
            ->format('U');
    }
}
