<?php
switch ((isset($_GET['view']) ? $_GET['view'] : ''))
{
    case ("technicals"):
      $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE stat.ticket_status = '$stat' AND ticket_t.ticket_category='Technicals' AND ticket_t.user_id = '".$_SESSION['user_id']."'";
      break;

    case ("access"):
      $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE stat.ticket_status = '$stat' AND ticket_t.ticket_category='Access' AND ticket_t.user_id = '".$_SESSION['user_id']."'";
      break;

    case ("network"):
      $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE stat.ticket_status = '$stat' AND ticket_t.ticket_category='Network' AND ticket_t.user_id = '".$_SESSION['user_id']."'";
      break;
}

//if severity button for sorting is selected
switch ((isset($_GET['view']) ? $_GET['view'] : ''))
{
    case ("sev1"):
      $sev = 'SEV1';
      if($stat != 'none'){
      $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE stat.ticket_status = '$stat' AND sev.severity_level='$sev' AND ticket_t.user_id = '".$_SESSION['user_id']."'";
    } elseif ($stat == 'none'){
      $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE sev.severity_level = '$sev' AND ticket_t.user_id = '".$_SESSION['user_id']."'";
    }
    break;

    case ("sev2"):
    $sev = 'SEV2';
    if($stat != 'none'){
    $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE stat.ticket_status = '$stat' AND sev.severity_level='$sev' AND ticket_t.user_id = '".$_SESSION['user_id']."'";
    } elseif ($stat == 'none'){
      $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE sev.severity_level = '$sev' AND ticket_t.user_id = '".$_SESSION['user_id']."'";
    }
    break;

    case ("sev3"):
    $sev = 'SEV3';
    if($stat != 'none'){
    $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE stat.ticket_status = '$stat' AND sev.severity_level='$sev' AND ticket_t.user_id = '".$_SESSION['user_id']."'";
  } elseif ($stat == 'none'){
    $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE sev.severity_level = '$sev' AND ticket_t.user_id = '".$_SESSION['user_id']."'";
  }
break;
    case ("sev4"):
    $sev = 'SEV4';
    if($stat != 'none'){
    $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE stat.ticket_status = '$stat' AND sev.severity_level='$sev' AND ticket_t.user_id = '".$_SESSION['user_id']."'";
    } elseif ($stat == 'none'){
      $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE sev.severity_level = '$sev' AND ticket_t.user_id = '".$_SESSION['user_id']."'";
    }
break;
    case ("sev5"):
    $sev = 'SEV5';
    if($stat != 'none'){
    $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE stat.ticket_status = '$stat' AND sev.severity_level='$sev' AND ticket_t.user_id = '".$_SESSION['user_id']."'";
  } elseif ($stat == 'none'){
    $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE sev.severity_level = '$sev' AND ticket_t.user_id = '".$_SESSION['user_id']."'";
  }
  break;
} ?>
