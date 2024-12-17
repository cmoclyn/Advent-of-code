<?php

$input = dirname(__DIR__) . "/input.txt";

$content = file_get_contents($input);

echo "Step 1 => get readable string\n";
$readableArray = convertInputToReadableArray($content);
echo "Step 2 => order string\n";
$orderedArray = order($readableArray);
echo "Step 3 => get checksum\n";
echo getCheckSum($orderedArray);

function convertInputToReadableArray(string $content): array {
    $chars = str_split($content);
    $outputArray = [];
    $isFile = true;
    $currentId = 0;

    foreach ($chars as $char) {
        $number = (int)$char;
        $currentChar = $isFile ? $currentId : '.';
        for($i = 0; $i < $number; $i++) {
            $outputArray[] = $currentChar;
        }

        if($isFile) {
            $currentId++;
        }

        $isFile = !$isFile;
    }
    echo "Max file id => $currentId\n";

    return $outputArray;
}

function order(array $notOrdered): array {
    $orderedArray = $notOrdered;
    while(!preg_match("/^\d+\.+$/", implode('', $orderedArray))) {
        $lastIdFile = getLastIdFileAndRemoveIt($orderedArray);
        $orderedArray = placeIdInFirstFreePlace($orderedArray, $lastIdFile);
    }
    return $orderedArray;
}

function placeIdInFirstFreePlace(array $orderedArray, ?string $lastIdFile): array
{
    foreach($orderedArray as &$char) {
        if($char === '.'){
            $char = $lastIdFile;
            break;
        }
    }
    return $orderedArray;
}


function getLastIdFileAndRemoveIt(array &$orderedArray): ?string {
    for($i = count($orderedArray) - 1; $i >= 0; $i--) {
        $char = $orderedArray[$i];
        if($char !== '.'){
            $orderedArray[$i] = '.';
            return $char;
        }
    }
    return null;
}

function getCheckSum(array $orderedString): int {
    $checksum = 0;

    foreach($orderedString as $key => $number) {
        $checksum += $key * (int)$number;
    }
    return $checksum;
}