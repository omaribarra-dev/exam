<?php
 
 
$destinations = file('destinations.txt', FILE_IGNORE_NEW_LINES);
$drivers = file('drivers.txt', FILE_IGNORE_NEW_LINES);

$assignments = assignShipmentsToDrivers($destinations, $drivers);
$totalSuitability = calculateTotalSuitability($assignments);

// Output the results
echo "Total Suitability Score: " . $totalSuitability . PHP_EOL;
echo "Assignments:" . PHP_EOL;
foreach ($assignments as $destination => $driver) {
    echo "<br>Destination: " . $destination . "  -->  Driver: " . $driver . PHP_EOL;
}

/**
 * Assign shipment destinations to drivers based on maximum suitability score.
 *
 * @param array $destinations
 * @param array $drivers
 * @return array
 */
function assignShipmentsToDrivers(array $destinations, array $drivers): array
{
    $sortedDrivers = array_map(function ($driver) use ($destinations) {
        return [
            'driver' => $driver,
            'score' => calculateSuitabilityScore($driver, $destinations[0])
        ];
    }, $drivers);

    usort($sortedDrivers, function ($a, $b) {
        return $b['score'] <=> $a['score'];
    });

    $assigned = array_slice($sortedDrivers, 0, count($destinations));

    return array_combine($destinations, array_column($assigned, 'driver'));
}

/**
 * Calculate the total suitability score for all assigned shipments.
 *
 * @param array $assignments
 * @return float
 */
function calculateTotalSuitability(array $assignments): float
{
    $totalSuitability = 0;
    foreach ($assignments as $destination => $driver) {
        $totalSuitability += calculateSuitabilityScore($driver, $destination);
    }
    return $totalSuitability;
}

/**
 * Calculate the suitability score for a driver and shipment destination.
 *
 * @param string $driver
 * @param string $destination
 * @return float
 */
function calculateSuitabilityScore(string $driver, string $destination): float
{
    $driverName = strtolower($driver);
    $destinationLength = strlen($destination);

    $vowels = ['a', 'e', 'i', 'o', 'u'];
    $consonants = array_diff(range('a', 'z'), $vowels);

    $baseSS = $destinationLength % 2 == 0 ? count(array_intersect(str_split($driverName), $vowels)) * 1.5 : count(array_intersect(str_split($driverName), $consonants));

    if (count(calculateCommonFactors($destinationLength, strlen($driverName))) > 1) {
        $baseSS *= 1.5;
    }

    return $baseSS;
}

/**
 * Calculate the common factors of two numbers.
 *
 * @param int $num1
 * @param int $num2
 * @return array
 */
function calculateCommonFactors(int $num1, int $num2): array
{
    $factors = [];
    $limit = min($num1, $num2);
    for ($i = 2; $i <= $limit; $i++) {
        if ($num1 % $i == 0 && $num2 % $i == 0) {
            $factors[] = $i;
        }
    }
    return $factors;
}