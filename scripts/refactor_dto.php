<?php
$dir = __DIR__ . '/../src/Dto';
$files = glob($dir . '/*.php');
$changes = [];
foreach ($files as $file) {
    $original = file_get_contents($file);
    $lines = preg_split('/\R/', $original);

    // Remove Spatie use lines and collect indexes
    $newLines = [];
    foreach ($lines as $line) {
        if (preg_match('/^use\\s+Spatie\\\\LaravelData\\\\/', trim($line))) {
            continue;
        }
        $newLines[] = $line;
    }

    $content = implode("\n", $newLines);

    // Remove extends SpatieData alias or FQN
    $content = preg_replace('/class(\s+\w+)\s+extends\s+(?:Spatie\\\\LaravelData\\\\Data|SpatieData)(\s*)/','class$1$2',$content);

    // Capture constructor params with possible MapName attributes
    // Locate constructor parentheses
    if (!str_contains($content, '__construct(')) {
        $changes[$file] = $content;
        continue;
    }

    $start = strpos($content, '__construct');
    $open = strpos($content, '(', $start);
    $depth = 0; $i = $open; $end = null;
    for (; $i < strlen($content); $i++) {
        $ch = $content[$i];
        if ($ch === '(') $depth++;
        if ($ch === ')') { $depth--; if ($depth === 0) { $end = $i; break; } }
    }
    if ($end === null) {
        $changes[$file] = $content;
        continue;
    }

    // For mapping, scan the constructor section in original content line-wise to capture attributes bound to params.
    $params = [];
    $lines2 = preg_split('/\R/', $content);
    $constructLineIndex = null; $parenDepth = 0;
    $accumAttr = null;
    foreach ($lines2 as $idx => $ln) {
        if ($constructLineIndex === null) {
            if (strpos($ln, '__construct') !== false) {
                $constructLineIndex = $idx;
            } else {
                continue;
            }
        }
        // Count parens for this line
        $openCount = substr_count($ln, '(');
        $closeCount = substr_count($ln, ')');
        $parenDepth += $openCount;
        // Inside param block when depth >= 1 after encountering construct
        if ($parenDepth >= 1 && $idx >= $constructLineIndex) {
            $trim = trim($ln);
            if ($trim === '') { $parenDepth -= $closeCount; if ($parenDepth <= 0) break; continue; }
            // Track attribute
            if (str_starts_with($trim, '#[')) {
                if (preg_match('/MapName\(\'([^\']+)\'\)/', $trim, $mm)) {
                    $accumAttr = $mm[1];
                } else {
                    $accumAttr = null;
                }
                $parenDepth -= $closeCount;
                if ($parenDepth <= 0) break;
                continue;
            }
            // Look for promoted property param
            if (preg_match('/public\s+([^\s\$]+)\s*\$([A-Za-z_][A-Za-z0-9_]*)/', $trim, $pm)) {
                $type = trim($pm[1]);
                $name = $pm[2];
                $map = $accumAttr ?: $name;
                $accumAttr = null;
                $params[] = ['name'=>$name,'type'=>$type,'map'=>$map];
            }
        }
        $parenDepth -= $closeCount;
        if ($constructLineIndex !== null && $parenDepth <= 0 && $closeCount > 0) {
            break;
        }
    }

    // Remove MapName attributes occurrences in the content
    $content = preg_replace('/\s*#\[MapName\(.*?\)\]\s*/s', "\n", $content);

    // Insert fromResponse and collect methods if not exist
    if (!str_contains($content, 'static function fromResponse')) {
        // Build argument list with mapping
        $argLines = [];
        foreach ($params as $p) {
            $mapKey = $p['map'];
            // Default null; arrays default []
            $defaultExpr = 'null';
            if (stripos($p['type'], 'array') !== false) {
                $defaultExpr = '[]';
            }
            $argLines[] = sprintf("            %s: \$data['%s'] ?? %s,", $p['name'], $mapKey, $defaultExpr);
        }
        $fromResponse = "\n    public static function fromResponse(array \$data): self\n    {\n        return new self(\n" . implode("\n", $argLines) . "\n        );\n    }\n\n    public static function collect(array \$items): array\n    {\n        return array_map(fn (array \$item) => self::fromResponse(\$item), \$items);\n    }\n";
        // Place before class closing bracket
        $content = preg_replace('/}\s*$/', $fromResponse . "\n}\n", $content);
    }

    $changes[$file] = $content;
}

foreach ($changes as $file => $newContent) {
    file_put_contents($file, $newContent);
}

fwrite(STDOUT, "Refactored " . count($changes) . " DTO files\n");
