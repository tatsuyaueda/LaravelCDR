<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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

            if (!preg_match("/^.+ CALL:(TS |TE )?(\d{2}\/\d{2}\/\d{2} \d{2}:\d{2}:\d{2}) (.+) -> (.+)$/", $text, $parse)) {
                continue;
            }

            if (!preg_match("/^(.+) (\d{2}:\d{2}:\d{2}) \- (\d{2}:\d{2}:\d{2}) \((\d{2}:\d{2}:\d{2})\) ?(\d*)/", $parse[4], $dest)) {
                continue;
            }

            //var_dump($parse);
            //var_dump($dest);
            // 転送種別
            $type = $parse[1];
            // 時間
            $time = $parse[2];
            // 発信者
            $sender = $parse[3];
            // 着信者
            $destination = $parse[4];

            $startSec = self::convTime($dest[2]);
            $endSec = self::convTime($dest[3]);
            $durSec = self::convTime($dest[4]);
            $item_start = mktime(0, 0, 0) + $startSec;
            $item_end = mktime(0, 0, 0) + $endSec;

            // 日付をまたいでいる場合
            if ($startSec > $endSec) {
                $endSec += 86400;
            }

            $checkSender = preg_match('/^(S\d+:)?\d+$/', $sender);
            $checkDestination = preg_match('/^(S\d+:)?\d+$/', $dest[1]);

            echo "Dest:", $dest[1], "/", $dest[5], "\n";
            echo "Time:", $dest[2], "(", date('c', $item_start), ") - ", $dest[3], "(", date('c', $item_end), ")(", $dest[4], ")", "\n";

            $item_type = "";
            $item_sender = "";
            $item_dest = "";

            if ($checkSender && $checkDestination) {
                echo "### Ext Call From:", $sender, "   To:", $dest[1], "\n";
                // 内線通話
                $item_type = 10;
                $item_sender = $sender;
                $item_dest = $dest[1];
            } else if ($dest[5] != "") {
                echo "### Trk Out  From:", $sender, "   To:", $dest[5], "\n";
                // 外線発信
                $item_type = 21;
                $item_sender = $sender;
                $item_dest = $dest[5];
            } else if ($checkSender && $dest[1] != "") {
                echo "### Trk Hunt From:", $sender, "   To:", $dest[1], "\n";
                // 外線応答
                $item_type = 22;
                $item_sender = $sender;
                $item_dest = $dest[1];
            } else {
                echo "### Trk Inc  From:", $sender, "   To:", $dest[1], "\n";
                // 外線着信
                $item_type = 23;
                $item_sender = $sender;
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

            echo "-----\n";
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
