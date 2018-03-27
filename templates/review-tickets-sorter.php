<?php
switch ((isset($_GET['view']) ? $_GET['view'] : ''))
{
    case ("technicals"):
      if($_SESSION['user_type']=='Administrator'){
        $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.ticket_status='$stat' AND ticket_t.ticket_category='Technicals'";
      }
      elseif($_SESSION['user_type']=='Requestor'){
        $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.ticket_category = 'Technicals' AND stat.ticket_status = '$stat')";
      }
      break;

    case ("access"):
      if($_SESSION['user_type']=='Administrator'){
        $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.ticket_status='$stat' AND ticket_t.ticket_category='Access'";
      }
      elseif($_SESSION['user_type']=='Requestor'){
        $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.ticket_category = 'Access' AND stat.ticket_status = '$stat')";
      }
      break;

    case ("network"):
      if($_SESSION['user_type']=='Administrator'){
        $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.ticket_status='$stat' AND ticket_t.ticket_category='Network'";
      }
      elseif($_SESSION['user_type']=='Requestor'){
        $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.ticket_category = 'Network' AND stat.ticket_status = '$stat')";
      }
      break;
  }

//if severity button for sorting is selected
switch ((isset($_GET['view']) ? $_GET['view'] : ''))
{
    case ("sev1"):
      $sev = 'SEV1';

      if($_SESSION['user_type'] == "Technicals Group Manager" OR $_SESSION['user_type'] == "Network Group Manager" OR $_SESSION['user_type'] == "Access Group Manager" AND $stat != 'none'){
        $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.it_group_manager_id = '".$_SESSION['user_id']."' AND stat.ticket_status='$stat' AND sev.severity_level='$sev'";

      } elseif ($_SESSION['user_type'] == "Technicals Group Manager" OR $_SESSION['user_type'] == "Network Group Manager" OR $_SESSION['user_type'] == "Access Group Manager" AND $stat == 'none'){
          $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.it_group_manager_id = '".$_SESSION['user_id']."' AND sev.severity_level='$sev'";

      } elseif ($_SESSION['user_type'] ==  "Technician" OR $_SESSION['user_type'] == 'Network Engineer' AND $stat != 'none'){
        $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status where sev.severity_level='$sev' AND stat.ticket_status = '$stat' AND ticket_t.ticket_agent_id = '".$_SESSION['user_id']."'";

      } elseif ($_SESSION['user_type'] == "Network Engineer" OR $_SESSION['user_type'] == 'Technician' AND $stat == 'none'){
        $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status where sev.severity_level='$sev' AND ticket_t.ticket_agent_id = '".$_SESSION['user_id']."'";

      }
      break;

    case ("sev2"):
    $sev = 'SEV2';
    if($_SESSION['user_type'] == "Technicals Group Manager" OR $_SESSION['user_type'] == "Network Group Manager" OR $_SESSION['user_type'] == "Access Group Manager" AND $stat != 'none'){
      $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.it_group_manager_id = '".$_SESSION['user_id']."' AND stat.ticket_status='$stat' AND sev.severity_level='$sev'";

    } elseif (($_SESSION['user_type'] == "Technicals Group Manager" OR $_SESSION['user_type'] == "Network Group Manager" OR $_SESSION['user_type'] == "Access Group Manager") AND $stat == 'none'){
        $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.it_group_manager_id = '".$_SESSION['user_id']."'";

    } elseif ($_SESSION['user_type'] ==  "Technician" OR $_SESSION['user_type'] == 'Network Engineer' AND $stat != 'none'){
      $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status where sev.severity_level='$sev' AND stat.ticket_status = '$stat' AND ticket_t.ticket_agent_id = '".$_SESSION['user_id']."'";

    } elseif ($_SESSION['user_type'] == "Network Engineer" OR $_SESSION['user_type'] == 'Technician' AND $stat == 'none'){
      $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status where sev.severity_level='$sev' AND ticket_t.ticket_agent_id = '".$_SESSION['user_id']."'";

    } else {
      $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE stat.ticket_status = '$stat' AND sev.severity_level='$sev'";
    }
    break;

    case ("sev3"):
      $sev = 'SEV3';
      if($_SESSION['user_type'] == "Technicals Group Manager" OR $_SESSION['user_type'] == "Network Group Manager" OR $_SESSION['user_type'] == "Access Group Manager" AND $stat != 'none'){
        $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.it_group_manager_id = '".$_SESSION['user_id']."' AND stat.ticket_status='$stat' AND sev.severity_level='$sev'";

      } elseif ($_SESSION['user_type'] == "Technicals Group Manager" OR $_SESSION['user_type'] == "Network Group Manager" OR $_SESSION['user_type'] == "Access Group Manager" AND $stat == 'none'){
          $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.it_group_manager_id = '".$_SESSION['user_id']."' AND sev.severity_level='$sev'";

      } elseif ($_SESSION['user_type'] ==  "Technician" OR $_SESSION['user_type'] == 'Network Engineer' AND $stat != 'none'){
        $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status where sev.severity_level='$sev' AND stat.ticket_status = '$stat' AND ticket_t.ticket_agent_id = '".$_SESSION['user_id']."'";

      } elseif ($_SESSION['user_type'] == "Network Engineer" OR $_SESSION['user_type'] == 'Technician' AND $stat == 'none'){
        $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status where sev.severity_level='$sev' AND ticket_t.ticket_agent_id = '".$_SESSION['user_id']."'";

      }
      break;

    case ("sev4"):
      $sev = 'SEV4';
      if($_SESSION['user_type'] == "Technicals Group Manager" OR $_SESSION['user_type'] == "Network Group Manager" OR $_SESSION['user_type'] == "Access Group Manager" AND $stat != 'none'){
        $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.it_group_manager_id = '".$_SESSION['user_id']."' AND stat.ticket_status='$stat' AND sev.severity_level='$sev'";

      } elseif ($_SESSION['user_type'] == "Technicals Group Manager" OR $_SESSION['user_type'] == "Network Group Manager" OR $_SESSION['user_type'] == "Access Group Manager" AND $stat == 'none'){
          $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.it_group_manager_id = '".$_SESSION['user_id']."' AND sev.severity_level='$sev'";

      } elseif ($_SESSION['user_type'] ==  "Technician" OR $_SESSION['user_type'] == 'Network Engineer' AND $stat != 'none'){
        $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status where sev.severity_level='$sev' AND stat.ticket_status = '$stat' AND ticket_t.ticket_agent_id = '".$_SESSION['user_id']."'";

      } elseif ($_SESSION['user_type'] == "Network Engineer" OR $_SESSION['user_type'] == 'Technician' AND $stat == 'none'){
        $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status where sev.severity_level='$sev' AND ticket_t.ticket_agent_id = '".$_SESSION['user_id']."'";
      }
      break;

    case ("sev5"):
      $sev = 'SEV5';
      if($_SESSION['user_type'] == "Technicals Group Manager" OR $_SESSION['user_type'] == "Network Group Manager" OR $_SESSION['user_type'] == "Access Group Manager" AND $stat != 'none'){
        $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.it_group_manager_id = '".$_SESSION['user_id']."' AND stat.ticket_status='$stat' AND sev.severity_level='$sev'";

      } elseif ($_SESSION['user_type'] == "Technicals Group Manager" OR $_SESSION['user_type'] == "Network Group Manager" OR $_SESSION['user_type'] == "Access Group Manager" AND $stat == 'none'){
          $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status WHERE ticket_t.it_group_manager_id = '".$_SESSION['user_id']."' AND sev.severity_level='$sev'";

      } elseif ($_SESSION['user_type'] ==  "Technician" OR $_SESSION['user_type'] == 'Network Engineer' AND $stat != 'none'){
        $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status where sev.severity_level='$sev' AND stat.ticket_status = '$stat' AND ticket_t.ticket_agent_id = '".$_SESSION['user_id']."'";

      } elseif ($_SESSION['user_type'] == "Network Engineer" OR $_SESSION['user_type'] == 'Technician' AND $stat == 'none'){
        $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id) LEFT JOIN user_access_ticket_t USING (ticket_id) LEFT JOIN sla_t sev ON sev.id = ticket_t.severity_level LEFT JOIN ticket_status_t stat ON stat.status_id = ticket_t.ticket_status where sev.severity_level='$sev' AND ticket_t.ticket_agent_id = '".$_SESSION['user_id']."'";

      }
      break;
} ?>
