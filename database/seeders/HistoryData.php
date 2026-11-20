<?php

namespace Database\Seeders;

use RuntimeException;

/**
 * Production credits extracted from https://github.com/newtheatre/history-project.
 */
class HistoryData
{
    /**
     * @return list<array{title: string, playwright: string, season: string, year: string, cast: list<array{name: string, role: string, note: string}>, crew: list<array{name: string, role: string, note: string}>}>
     */
    public static function shows(): array
    {
        $contents = file_get_contents(database_path('seeders/history-shows.json'));
        if ($contents === false) {
            throw new RuntimeException('Cannot read the history archive seed data.');
        }

        $data = json_decode($contents, true, flags: JSON_THROW_ON_ERROR);
        if (! is_array($data) || ! array_is_list($data)) {
            throw new RuntimeException('Invalid history archive seed data.');
        }

        $shows = [];
        foreach ($data as $record) {
            if (! is_array($record) || ! is_string($record['title'] ?? null) || ! is_string($record['playwright'] ?? null) || ! is_string($record['season'] ?? null) || ! is_string($record['year'] ?? null)) {
                throw new RuntimeException('Invalid production in history archive seed data.');
            }
            $shows[] = [
                'title' => $record['title'],
                'playwright' => $record['playwright'],
                'season' => $record['season'],
                'year' => $record['year'],
                'cast' => self::credits($record['cast'] ?? null),
                'crew' => self::credits($record['crew'] ?? null),
            ];
        }

        return $shows;
    }

    /** @return list<array{name: string, role: string, note: string}> */
    private static function credits(mixed $credits): array
    {
        if (! is_array($credits) || ! array_is_list($credits)) {
            throw new RuntimeException('Invalid credits in history archive seed data.');
        }

        $result = [];
        foreach ($credits as $credit) {
            if (! is_array($credit) || ! is_string($credit['name'] ?? null) || ! is_string($credit['role'] ?? null) || ! is_string($credit['note'] ?? null)) {
                throw new RuntimeException('Invalid credit in history archive seed data.');
            }
            $result[] = ['name' => $credit['name'], 'role' => $credit['role'], 'note' => $credit['note']];
        }

        return $result;
    }
}
