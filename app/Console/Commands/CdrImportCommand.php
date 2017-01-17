<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;

class CdrImportCommand extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'CDR Import Command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        // read from stdin
        $fd = fopen("php://stdin", "r");

        while (!feof($fd)) {
            $text = fgets($fd);

            // 通話ログのみパースする
            if(!preg_match("/CALL:/", $text)){
                continue;
            }
            
            Log::debug("### Begen of Record");

            if (!preg_match("/CALL:(TS|TE)?\s*(\d{2}\/\d{2}\/\d{2} \d{2}:\d{2}:\d{2}) (.+) -> (.+)$/", $text, $parse)) {
                Log::error("Log Parse Error[1000]: $text");
                continue;
            }

            if (!preg_match("/^(.+) (\d{2}:\d{2}:\d{2}) \- (\d{2}:\d{2}:\d{2}) \((\d{2}:\d{2}:\d{2})\) ?(\d*)/", $parse[4], $dest)) {
                Log::error("Log Parse Error[1010]: $parse[4]");
                continue;
            }

            Log::debug("Parse Result[1000]");
            Log::debug(print_r($parse, true));
            Log::debug("Parse Result[1010]");
            Log::debug(print_r($dest, true));
            
            // 転送種別
            //$type = $parse[1];
            // 時間
            //$time = $parse[2];
            // 発信者
            $sender = $parse[3];
            // 着信者
            //$destination = $parse[4];

            $startSec = self::convTime($dest[2]);
            $endSec = self::convTime($dest[3]);
            $durSec = self::convTime($dest[4]);
            $item_start = mktime(0, 0, 0) + $startSec;
            $item_end = mktime(0, 0, 0) + $endSec;

            // 日付をまたいでいる場合
            if ($startSec > $endSec) {
                $endSec += 86400;
            }

            // 数字だけの場合は内線として見なす
            $checkSender = preg_match('/^(S\d+:)?\d+$/', $sender);
            // 数字だけの場合は内線として見なす
            $checkDestination = preg_match('/^(S\d+:)?\d+$/', $dest[1]);
            
            // 外線着信・外線応答時の不要な情報を削る
            if(preg_match('/^\d+\(\d+\)(\d*)$/', $dest[1], $dest2)){
                $dest[1] = $dest2[1];
            }
            if(preg_match('/^\d+\(\d+\)(\d*)$/', $sender, $sender2)){
                $sender = $sender2[1];
            }
            
            $item_type = "";
            $item_sender = $sender;
            $item_dest = "";

            if ($checkSender && $checkDestination) {
                // 内線通話
                Log::debug("# Ext Call From:$sender To:$dest[1]");
                $item_type = 10;
                $item_dest = $dest[1];
            } else if ($dest[5] != "") {
                // 外線発信
                Log::debug("# Trk Out From:$sender To:$dest[5]");
                $item_type = 21;
                $item_dest = $dest[5];
            } else if ($checkSender && $dest[1] != "") {
                // 外線応答
                Log::debug("# Trk Hunt From:$sender To:$dest[1]");
                $item_type = 22;
                $item_dest = $dest[1];
            } else {
                // 外線着信
                Log::debug("# Trk Inc From:$sender To:$dest[1]");
                $item_type = 23;
                $item_dest = $dest[1];
            }

            $cdr = new \App\Cdr;
            $cdr->Type = $item_type;
            $cdr->Sender = $item_sender;
            $cdr->Destination = $item_dest;
            $cdr->StartDateTime = date('c', $item_start);
            $cdr->EndDateTime = date('c', $item_end);
            $cdr->Duration = $durSec;
            $cdr->save();
            
            Log::debug(print_r($cdr, true));

            Log::debug("### End of Record");
        }

        fclose($fd);
    }

    /**
     * HH:MM:SSを秒数に変換
     * @param string $value
     * @return int
     */
    public function convTime($value) {

        $item = explode(':', $value);

        $secs = intval($item[0]) * 60 * 60;
        $secs+= intval($item[1]) * 60;
        $secs+= intval($item[2]);

        return $secs;
    }

}
