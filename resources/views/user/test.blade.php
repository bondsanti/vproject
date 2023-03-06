<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<body>
  <?php

$groupedData = [];
foreach ($data as $row) {
    $groupedData[$row->id]['id'] = $row->id;
    $groupedData[$row->id]['team_name'] = $row->team_name;
    $groupedData[$row->id]['subteams'][] = [
        'subteam_name' => $row->subteam_name,
    ];
}

// Convert data to JSON
$jsonData = json_encode(array_values($groupedData));
  ?>
<div class="container">
    <br>
    <div class="card-deck mb-3 text-center">

    <?php foreach (json_decode($jsonData) as $team): ?>
      <div class="card mb-4 shadow-sm">
        <div class="card-header">
          <h4 class="my-0 font-weight-normal"><?php echo $team->team_name; ?></h4>
        </div>
        <div class="card-body">
            <?php foreach ($team->subteams as $subteam): ?>
          <button type="button" class="btn btn-lg btn-block btn-outline-primary"><?php echo $subteam->subteam_name; ?></button>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>


</body>
</html>
