<?php

if(isset($_GET['amount'])) {
		calculateOne($_GET['amount']);
} else {
		calculateOne(750000000); // Input your amount here!
}

// Setting your parameters here
function appSetting($inputan) {
		$lowerLimitOne = 0;
		$upperLimitOne = 50000000;
		$upperLimitTwo = 250000000;
		$upperLimitThree = 500000000;

		$disc1 = 5;
		$disc2 = 15;
		$disc3 = 25;
		$disc4 = 30;

		if($inputan >= $lowerLimitOne && $inputan <= $upperLimitOne) {
				$process = 1;
		} else {
				if($inputan > $upperLimitOne && $inputan <= $upperLimitTwo) {
						$process = 2;
				} else {
						if($inputan > $upperLimitTwo && $inputan <= $upperLimitThree) {
								$process = 3;
						} else {
								$process = 4;
						}
				}
		}
		return $process.'_'.$upperLimitOne.'_'.$upperLimitTwo.'_'.$upperLimitThree.'_|'.$disc1.'|'.$disc2.'|'.$disc3.'|'.$disc4;
}

function calculateOne($inputan) {

		$filterinput = filterInput($_GET['amount']);
		$process = appSetting($filterinput);
		$data = explode('_', $process);
		$datadisc = explode('|', $process);

		$disc1 = $datadisc[1];
		$disc2 = $datadisc[2];
		$disc3 = $datadisc[3];
		$disc4 = $datadisc[4];

		$step		= $data[0];
		$limit1	= $data[1];
		$limit2	= $data[2];
		$limit3	= $data[3];

		if($step == 1) {
				if($inputan <= $limit1) {
						$total = ($disc1 / 100) * $inputan;
				} else {
						$total = ($disc1 / 100) * $limit1;
				}
				echo '<b>TOTAL PAJAK : '.number($total).'</b>';
		} else {
				$total = ($disc1 / 100) * $limit1;
				$pengurangan_inputan = $inputan - $limit1;
				$step = $step - 1;

				echo 'ANGKA DIINPUT : '.number($filterinput).'<br />';
				echo 'MAKSIMAL LIMIT STEP 1 : '.number($limit1).'<br />';
				echo 'SISA INPUTAN : '.number($pengurangan_inputan).'<br />';
				echo 'PAJAK : '.discount($disc1).'<br />';
				echo 'TOTAL HITUNG STEP 1 : '.number($total).'<br />';
				echo 'SISA STEP : '.$step.'<br />';
				echo '<hr />';

				if($step == 0) {
						die();
				} else {
						calculateTwo($total, [$disc1, $disc2, $disc3, $disc4], $pengurangan_inputan, $inputan, $step, [$limit1, $limit2, $limit3]);
				}
		}
}

function calculateTwo($total, $disc, $pi, $inputan, $step, $limit) {
		if($step == 1) {
				$totalx = ($disc[1] / 100) * $pi;
				$step = $step - 1;
				$taxTotal = $totalx + $total;
				echo 'PAJAK : '.discount($disc[1]).'<br />';
				echo 'TOTAL HITUNG STEP 2 : '.number($totalx).'<br />';
				echo 'SISA STEP : '.$step.'<br />';
				echo '<hr />';
				echo '<b>TOTAL PAJAK : '.number($taxTotal).'</b>';
		} else {
				$limitx = $limit[1] - $limit[0];
				$totalx = ($disc[1] / 100) * $limitx;
				$totalx = $totalx + $total;
				$pengurangan_inputan = $pi - $limitx;
				$step = $step - 1;

				echo 'ANGKA DIINPUT : '.number($pi).'<br />';
				echo 'MAKSIMAL LIMIT STEP 2 : '.number($limit[1]).'<br />';
				echo 'SISA INPUTAN : '.number($pengurangan_inputan).'<br />';
				echo 'PAJAK : '.discount($disc[1]).'<br />';
				echo 'TOTAL HITUNG STEP 2 : '.number($totalx).'<br />';
				echo 'SISA STEP : '.$step.'<br />';
				echo '<hr />';

				if($step == 0) {
						die();
				} else {
						calculateThree($totalx, $disc, $pengurangan_inputan, $inputan, $step, $limit);
				}
		}
}

function calculateThree($total, $disc, $pi, $inputan, $step, $limit) {
		if($step == 1) {
				$totalxx = ($disc[2] / 100) * $pi;
				$step = $step - 1;
				$taxTotal = $totalxx + $total;
				echo 'PAJAK : '.discount($disc[2]).'<br />';
				echo 'TOTAL HITUNG STEP 3 : '.number($totalxx).'<br />';
				echo 'SISA STEP : '.$step.'<br />';
				echo '<hr />';
				echo '<b>TOTAL PAJAK : '.number($taxTotal).'</b>';
		} else {
				$limitxx = $limit[2] - $limit[1];
				$totalxx = ($disc[2] / 100) * $limitxx;
				$totalxx = $totalxx + $total;
				$pengurangan_inputan = $pi - $limitxx;
				$step = $step - 1;

				echo 'ANGKA DIINPUT : '.number($pi).'<br />';
				echo 'MAKSIMAL LIMIT STEP 3 : '.number($limit[2]).'<br />';
				echo 'SISA INPUTAN : '.number($pengurangan_inputan).'<br />';
				echo 'PAJAK : '.discount($disc[2]).'<br />';
				echo 'TOTAL HITUNG STEP 3 : '.number($totalxx).'<br />';
				echo 'SISA STEP : '.$step.'<br />';
				echo '<hr />';

				calculateFour($totalxx, $disc, $pengurangan_inputan, $inputan, $step, $limit);
		}
}

function calculateFour($total, $disc, $pi, $inputan, $step, $limit) {
		if($step == 1) {
				$totalxxx = ($disc[3] / 100) * $pi;
				$step = $step - 1;
				$taxTotal = $totalxxx + $total;
				echo 'PAJAK : '.discount($disc[3]).'<br />';
				echo 'TOTAL HITUNG STEP 4 : '.number($totalxxx).'<br />';
				echo 'SISA STEP : '.$step.'<br />';
				echo '<hr />';
				echo '<b>TOTAL PAJAK : '.number($taxTotal).'</b>';
		} else {
				echo 'Please create next function for calculate';
		}
}

function number($inputan) {
		return 'Rp.'.number_format($inputan, '0');
}

function discount($inputan) {
		return number_format($inputan, '0').' %';
}

function filterInput($inputan) {
		$output = preg_replace("/[^0-9]/", "", $inputan);
		return $output;
}
