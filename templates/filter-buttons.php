<div class="sorter">
  <!-- Button for Removing Filter -->
  <a href="review-incoming-tickets.php" class="waves-effect btn-sort">Remove Filter <i id="removefilter" class="material-icons">remove_circle</i></a>

  <?php if($row['user_type'] == "Requestor"){ ?>

  <!-- Dropdown Trigger for Category Sorter -->
  <a class="dropdown-button btn-sort" data-activates="categories" data-beloworigin="true">Category<i id="sort" class="material-icons">arrow_drop_down</i></a>
  <!-- Dropdown Structure -->
  <ul id="categories" class="dropdown-content collection">
    <li><a href="?view=technicals" class="technicals">Technicals</a></li>
    <li><a href="?view=access" class="accesstickets">Access</a></li>
    <li><a href="?view=network" class="network">Network</a></li>
  </ul>

<?php } ?>

  <!-- Dropdown Trigger for Severity Sorter -->
  <a class="dropdown-button btn-sort" data-activates="sevlevels" data-beloworigin="true">Severity<i id="sort" class="material-icons">arrow_drop_down</i></a>
  <!-- Dropdown Structure -->
  <ul id="sevlevels" class="dropdown-content collection">
    <li><a href="?view=sev1">SEV1</a></li>
    <li><a href="?view=sev2">SEV2</a></li>
    <li><a href="?view=sev3">SEV3</a></li>
    <li><a href="?view=sev4">SEV4</a></li>
    <li><a href="?view=sev5">SEV5</a></li>
  </ul>
  <a class="btn-search search-toggle"><span id="search"><i class="material-icons search">search</i></span>Search Here</a>
</div>
