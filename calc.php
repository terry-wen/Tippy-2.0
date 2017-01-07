<!DOCTYPE HTML>
<html>
  <head>
    <title>Tippy 2.0</title>
    <link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu+Mono" rel="stylesheet">
    <link rel="stylesheet" href="home.css">
  </head>
  <body>
    <div class="container calc">
      <?php
        $vPrice = $vTip = $vSplit = true;
        $vSubmit = false;
        $bill = $tip = $total = $cTip = $tipAmt = $split = $sTip = $sTotal = "";

        if(isset($_POST['submit'])) {
          $bill = $_POST['bill'];
          $split = $_POST['split'];

          if(empty($bill) || !is_numeric($bill) || $bill <= 0)
            $vPrice = false;

          if(empty($_POST['tip']))
            $vTip = false;
          else {
            $tip = $_POST['tip'];
            if($tip == 'custom') {
              $cTip = $_POST['ctip'];
              if(empty($cTip))
                $cTip = 25;
              else if(!is_numeric($cTip) || $cTip <= 0)
                $vTip = false;
            }
          }

          if(empty($split))
            $split = 1;
          else if(!ctype_digit($split) || $split <= 0)
            $vSplit = false;

          $vSubmit = $vPrice && $vTip && $vSplit;
          if($vSubmit) {
            if($tip == 'custom')
              $tipAmt = $bill * $cTip / 100;
            else
              $tipAmt = $bill * $tip / 100;
            $total = $bill + $tipAmt;
            $sTip = $tipAmt / $split;
            $sTotal = $total / $split;
          }
        }
       ?>

      <div class="title">
        <h1>TIP CALCULATOR</h1>
      </div>
      <form class="form" method="post" action="">
        <div class="subtotal">
          <h2>Bill Subtotal</h2>
          <div class="content">
            <div style="height: 30px"><span style="width: 10px; padding: 2px;">$</span>
              <input class="input" type="text" name="bill" placeholder="100.00" value="<?php echo $bill?>">
            </div>
            <?php if(!$vPrice) { ?>
              <div class="error">Please enter a valid bill amount.</div>
            <?php } ?>
          </div>
        </div>
        <div class="tip">
          <h2>Tip Percentage</h2>
          <div class="content">
            <?php
              for($i = 10; $i <= 20; $i += 5) {
             ?>
                <input type="radio" name="tip" value="<?php echo $i?>" <?php if(isset($tip) && $tip == $i) echo "checked";?>>
                  <?php echo ($i) . '%';?>
            <?php } ?>
              <input type="radio" name="tip" value="custom" <?php if(isset($tip) && $tip == 'custom') echo "checked";?>>
              <input class="input" type="text" name="ctip" placeholder="25" value="<?php if(isset($tip) && $tip == 'custom') echo $cTip;?>"><span style="width: 10px; padding: 2px;">%</span>
          </div>
          <?php if(!$vTip) { ?>
            <div class="error">Please enter a valid tip amount.</div>
          <?php } ?>
        </div>
        <div class="split">
          <h2>Split Among:</h2>
          <div class="content">
            <div class="sp"><input class="input input-split" type="text" name="split" placeholder="1" value="<?php echo $split;?>"><div style="width: 64px; float: right; padding: 1px;">People</div></div>
            <?php if(!$vSplit) { ?>
              <div class="error">Please enter a valid number of people.</div>
            <?php } ?>
          </div>
        </div>
        <input class="btn btn-default calculate" name="submit" type="submit" value="Calculate!">
      </form>

      <?php if($vSubmit) { ?>
        <div class="result">
            <span>Tip: $<?php echo (number_format($tipAmt, 2));?></span><br/>
            <span>Total: $<?php echo (number_format($total, 2));?></span><br/>
          <?php if($split > 1) { ?>
            <span>Tip per person: $<?php echo (number_format($sTip, 2));?></span><br/>
            <span>Total per person: $<?php echo (number_format($sTotal, 2));?></span>
        </div>
      <?php } } ?>
    </div>
  </body>
</html>
