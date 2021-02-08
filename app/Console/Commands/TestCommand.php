<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Phpml\Classification\KNearestNeighbors;
use Phpml\Regression\LeastSquares;
use QL\QueryList;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test_command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '测试';

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
        try {
            $targets1 = $this->doStrToArray('180,373,496,638,609,439,316,350,464,540,547,455,500,305');
            $targets2 = $this->doStrToArray('258,420,500,602,516,396,345,345,442,509,493,471,393,281');

            $targets = $targets1;

//            $targets = [
//                ['180'], ['373'],['496'], ['638'],['609'], ['439'], ['316'],['350'],['464'], ['540'],['547'],  ['455'],['500'],['305'],
//            ];
            print_r($targets);
            foreach ($targets as &$target){
                $target = intval($target[0]);
            }

            unset($target);
            $total = count($targets);
            $samples = [];
            $hour = 8;
            for($i=0;$i<$total;$i++) {
                $samples[] = [$hour++];
            }

            echo chr(10);

            $regression = new LeastSquares();
            $regression->train($samples, $targets);

            $nextDay = 8;
            $nextDayHigh = $regression->predict([$nextDay]);

            foreach ($samples as $key => $val) {
                print_r(['第'.$val[0].'时段 = '.$targets[$key]]);
            }

            echo '第'.$nextDay.'时段 ：';
            echo(round($nextDayHigh));
            echo chr(10);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }

        exit;

        $x = [2, 3, 4, 5, 6, 7];
        $y = [5.5, 7, 6.8, 9.5, 11, 14];
//        $x = [
//            '1', '2', '3', '4', '5', '6', '7', '8', '9', '10',
//            '11', '12', '13', '14', '15', '16', '17', '18', '19', '20',
//            '21', '22', '23', '24', '25', '26', '27', '28', '29', '30',
//            '31', '32', '33', '34', '35'
//        ];
//
//        $y = [
//            '180', '258', '114', '106', '117', '210', '214', '136', '125', '96',
//            '146', '204', '188', '149', '111', '151', '124', '171', '189', '136',
//            '150', '164', '309', '182', '138', '324', '297', '178', '207', '227',
//            '174', '295', '270', '208', '350'
//        ];

        $count = count($x);
        $arrayX = array_sum($x);
        $arrayY = array_sum($y);

        logger( 'count='.$count );
        logger( 'x的和为='.$arrayX );
        logger( 'y的和为='.$arrayY );

        $mean_x = $arrayX / $count;
        $mean_y = $arrayY / $count;
        $sum_x = 0.0;
        $sum_y = 0.0;

        for ($i = 0;  $i < $count; $i++) {
            $sum_x += ($x[$i] - $mean_x) * ($y[$i] - $mean_y);
            $sum_y += pow(($x[$i] - $mean_x), 2);
        }

        $K = $sum_x / $sum_y;
        $b = $mean_y - $K * $mean_x;

        $y = $K + $b;

        echo $y;

//        logger(' k = '.$K);
//        logger(' b = '.$b);
    }

    public function doStrToArray($str)
    {
        $str = explode(',', $str);
        $data = [];
        foreach ($str as $val) {
            $data[] = [
                ltrim(rtrim($val, ''), '')
            ];
        }

        return $data;
    }
}
