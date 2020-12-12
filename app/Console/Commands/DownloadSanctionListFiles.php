<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DownloadSanctionListFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'download-sanction-list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will download all sanction list files';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $sanctionList1 = file_get_contents('https://www.treasury.gov/ofac/downloads/prgrmlst.txt', false, stream_context_create($arrContextOptions));
        $sanctionList2 = file_get_contents('https://www.treasury.gov/ofac/downloads/sdnlist.txt', false, stream_context_create($arrContextOptions));
        $sanctionList3 = file_get_contents('https://webgate.ec.europa.eu/europeaid/fsd/fsf/public/files/csvFullSanctionsList_1_1/content?token=dG9rZW4tMjAxNw', false, stream_context_create($arrContextOptions));

        Storage::disk('public')->put('sanction-list/prgmlst.txt', $sanctionList1);
        Storage::disk('public')->put('sanction-list/sdnlist.txt', $sanctionList2);
        Storage::disk('public')->put('sanction-list/eu-sanction-list.txt', $sanctionList3);
    }
}
