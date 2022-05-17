<?php

declare(strict_types=1);

namespace PhpTsvParserGarbutt;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Exception;

date_default_timezone_set('Asia/Tokyo');

class PhpTsvParserGarbutt
{
    protected Logger $logger;

    protected string $err_msg = 'データファイル読み込みでエラーが発生しました。';

    protected string $dependency_path = __DIR__ . '/../../../';

    protected string $filepath;

    protected int $array_length;

    protected string $linefeed;

    protected string $separator;

    protected string $charset_from;

    protected string $charset_to;

    protected string $data;

    /**
     * @param string $filepath
     * @param int    $array_length
     * @param string $linefeed
     * @param string $separator
     * @param string $charset_from
     * @param string $charset_to
     */
    public function __construct(string $filepath, int $array_length, string $linefeed = "\n",string $separator = "\t", string $charset_from = 'UTF-8', string $charset_to = 'UTF-8')
    {
        if( is_file($this->dependency_path . 'composer.json') && is_file($this->dependency_path . 'autoload.php') ) {
            // composer dependency
            require_once $this->dependency_path . 'autoload.php';
        }
        else {
            // standalone
            require_once __DIR__ . '/../vendor/autoload.php';
        }
        $this->logger = new Logger('PhpTsvParserGarbutt');
        $this->logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/app.log', Logger::ERROR));

        $this->filepath = $filepath;
        $this->array_length = $array_length;
        $this->linefeed = $linefeed;
        $this->separator = $separator;
        $this->charset_from = $charset_from;
        $this->charset_to = $charset_to;
    }

    /**
     * @return array
     */
    public function read(): array
    {
        if(
            !file_exists($this->filepath)
            || file_get_contents($this->filepath) === false
        ) {
            $this->logger->error(
                $this->err_msg,
                [
                    'filepath' => $this->filepath,
                ]
            );
            throw new Exception($this->err_msg);
        }
        // データ文字列から改行文字で配列へ
        $dataArr = explode($this->linefeed, file_get_contents($this->filepath));
        // 結果の配列を用意
        $resultArr = [];
        // ループ
        for($i = 0; $i < count($dataArr); $i++) {
            if($dataArr[$i] === '') {
                continue;
            }
            // 文字コード
            $elm = nl2br(
                mb_convert_encoding(
                    $dataArr[$i],
                    $this->charset_to,
                    $this->charset_from
                )
            );
            // 行が空文字列ならば指定要素数の空文字列の配列を生成、そうでなければ指定区切り文字列で分解した要素の配列を生成
            $elmArr = $elm === '' ?  array_fill(0, $this->array_length, '') : explode($this->separator, $elm);

            $resultArr[] = $elmArr;
        }
        return $resultArr;
    }
}
