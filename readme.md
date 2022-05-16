# Garbutt

## Abstract

tsv (csv) をパースするための簡易的なパッケージ

## Usage

1. Add key `repositories` and values same as below.
2. Add repository name and branch name in `require`.
3. Generate Instance and using.

### repositories

```json
    "name": "foobar/myapp",

    // 略

    "repositories": {
        "arm-band/php-tsv-parser-garbutt": {
            "type": "vcs",
            "url": "https://github.com/arm-band/php-tsv-parser-garbutt"
        }
    },
```

### require

```json
    "name": "foobar/myapp",

    // 略

    "require": {
        "arm-band/php-tsv-parser-garbutt": "main"
    }
```

### sample

```php
require_once 'vendor/autoload.php';

use PhpTsvParserGarbutt\PhpTsvParserGarbutt;

/**
 * PhpTsvParserGarbutt
 * 
 * @param string $filepath      : (required) Filepath of datafile.
 * @param int    $array_length  : (required) Assumed number of elements in the array expanded from the csv/tsv.
 * @param string $linefeed      : Assumed string of linefeed.
 * @param string $separator     : Assumed string of separator.
 * @param string $charset_from  : Character sets before conversion.
 * @param string $charset_to    : Character sets after conversion.
 */
$appInstance = new PhpTsvParserGarbutt(__DIR__ . '/data/testdata.tsv', 7);
/* testdata.tsv

0001	Townsville Airport	Garbutt Airport	TSV	オーストラリア	AU	https://www.townsvilleairport.com.au
0002	Tokyo International Airport	東京国際空港	HND	日本	JP	https://tokyo-haneda.com
0003	Aeroporto Internacional Aristides Pereira	アリスティデス・ペレイラ国際空港	BVC	カーボベルデ	CV	http://www.infraero.gov.br/index.php/br/situacao-dos-voos/por-aeroporto.html

*/

// fileread
$parsedData = $appInstance->read();
```