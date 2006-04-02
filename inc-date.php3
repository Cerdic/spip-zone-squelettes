<?
$date1 = date("D");
$date2 = date("d");
$date3 = date("n");
$date4 = date("Y");


switch($date1)
  {
   case 'Mon':
        echo 'lundi '.$date2;
        break;

   case 'Tue':
        echo 'mardi '.$date2;
         break;

   case 'Wed':
         echo 'mercredi '.$date2;
         break;

   case 'Thu':
        echo 'jeudi '.$date2;
        break;

    case 'Fri':
         echo 'vendredi '.$date2;
        break;

   case 'Sat':
        echo 'samedi '.$date2;
        break;

   case 'Sun':
        echo 'dimanche '.$date2;
         break;

  }


switch($date3)
  {
   case '01':
        echo ' janvier '.$date4;
        break;

   case '02':
         echo ' f&eacute;vrier '.$date4;
        break;

   case '03':
         echo ' mars '.$date4;
        break;

   case '04':
         echo ' avril '.$date4;
        break;

   case '05':
        echo ' mai '.$date4;
        break;

   case '06':
         echo ' juin '.$date4;
        break;

   case '07':
         echo ' juillet '.$date4;
         break;

   case '08':
         echo ' ao&ucirc;t '.$date4;
        break;

   case '09':
        echo ' septembre '.$date4;
        break;

   case '10':
        echo ' octobre '.$date4;
        break;

   case '11':
        echo ' novembre '.$date4;
         break;

   case '12':
         echo ' d&eacute;cembre '.$date4;
        break;

  }
?>
