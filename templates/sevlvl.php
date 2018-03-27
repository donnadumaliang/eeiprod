<?php switch($row['severity_level'])
{
    case("1"):
        $class = 'sev1';
        break;

   case("SEV2"):
       $class = 'sev2';
       break;

   case("SEV3"):
       $class = 'sev3';
       break;

   case("SEV4"):
       $class = 'sev4';
       break;

   case("SEV5"):
       $class = 'sev5';
       break;

  case(""):
      $class = 'blanksev';
      break;
} ?>
