<?php

declare(strict_types=1);

namespace Tests\PhpTsvParserGarbuttTest;

use PHPUnit\Framework\TestCase;
use PhpTsvParserGarbutt\PhpTsvParserGarbutt;
use Exception;

class PhpTsvParserGarbuttTest extends TestCase
{
    /**
     * @test : read tsv test
     */
    public function testReadTsv(): void
    {
        $appInstance = new PhpTsvParserGarbutt(__DIR__ . '/data/testdata.tsv', 7);

        $assertData = [
            [
                '0001',
                'Townsville Airport',
                'Garbutt Airport',
                'TSV',
                'オーストラリア',
                'AU',
                'https://www.townsvilleairport.com.au',
            ],
            [
                '0002',
                'Tokyo International Airport',
                '東京国際空港',
                'HND',
                '日本',
                'JP',
                'https://tokyo-haneda.com',
            ],
            [
                '0003',
                'Aeroporto Internacional Aristides Pereira',
                'アリスティデス・ペレイラ国際空港',
                'BVC',
                'カーボベルデ',
                'CV',
                'http://www.infraero.gov.br/index.php/br/situacao-dos-voos/por-aeroporto.html',
            ],
        ];
        $parsedData = $appInstance->read();

        $this->assertEquals($assertData, $parsedData);
    }
    /**
     * @test : read csv test
     */
    public function testReadCsv(): void
    {
        $appInstance = new PhpTsvParserGarbutt(__DIR__ . '/data/testdata.csv', 7, "\n", ',');

        $assertData = [
            [
                '0001',
                'Townsville Airport',
                'Garbutt Airport',
                'TSV',
                'オーストラリア',
                'AU',
                'https://www.townsvilleairport.com.au',
            ],
            [
                '0002',
                'Tokyo International Airport',
                '東京国際空港',
                'HND',
                '日本',
                'JP',
                'https://tokyo-haneda.com',
            ],
            [
                '0003',
                'Aeroporto Internacional Aristides Pereira',
                'アリスティデス・ペレイラ国際空港',
                'BVC',
                'カーボベルデ',
                'CV',
                'http://www.infraero.gov.br/index.php/br/situacao-dos-voos/por-aeroporto.html',
            ],
        ];
        $parsedData = $appInstance->read();
        $this->assertEquals($assertData, $parsedData);
    }

    /**
     * @test : read error test
     */
    public function testReadException(): void
    {
        $appInstance = new PhpTsvParserGarbutt(__DIR__ . '/data/testdata.txt', 1);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('データファイル読み込みでエラーが発生しました。');
        $appInstance->read();
    }
}
