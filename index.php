<?php
require("auth_admin.php"); //Authentication
require("APIClient.php");
require("config.php");

//Set up API class
$api = new APIClient();

//Beacons

//Delete
if(isset($_POST['deleteBeaconID'])){
    $beaconID = $_POST['deleteBeaconID'];
    $api->deleteBeacon($beaconID);
}

//Add
if(isset($_POST['addBeaconUuid'])){
    $beaconUuid = $_POST['addBeaconUuid'];
    $beaconMajor = $_POST['addBeaconMajor'];
    $beaconMinor = $_POST['addBeaconMinor'];
    $beaconBrand = $_POST['addBeaconBrand'];
    $beaconModel = $_POST['addBeaconModel'];
    $api->addBeacon($beaconUuid, $beaconMajor, $beaconMinor, $beaconBrand, $beaconModel);   
}

//Update

if(isset($_POST['editBeaconUUID'])){
    $beaconID = $_POST['editBeaconID'];
    $beaconUuid = $_POST['editBeaconUUID'];
    $beaconMajor = $_POST['editLocation'];
    $beaconMinor = $_POST['editSublocation'];
    $beaconBrand = $_POST['editBeaconBrand'];
    $beaconModel = $_POST['editBeaconModel'];
    $api->updateBeacon($beaconID, $beaconUuid, $beaconMajor, $beaconMinor, $beaconBrand, $beaconModel);   
}
//Locations

//Insert
if(isset($_POST['addLocationName'])){
    $locationName = $_POST['addLocationName'];
    $api->addLocation($locationName);
}

//Edit
if(isset($_POST['editLocationName'])){
    $locationID = $_POST['editLocationID'];
    $locationName = $_POST['editLocationName'];
    $api->updateLocation($locationID,$locationName);
}

//Delete
if(isset($_POST['deleteLocationID'])){
    $locationID = $_POST['deleteLocationID'];
    $api->deleteLocation($locationID);
}


//Sublocations

//Insert
if(isset($_POST['addSublocationName'])){
    $sublocationName = $_POST['addSublocationName'];
    $api->addSublocation($sublocationName);
}

//Edit
if(isset($_POST['editSublocationName'])){
    $sublocationID = $_POST['editSublocationID'];
    $sublocationName = $_POST['editSublocationName'];
    $api->updateSublocation($sublocationID,$sublocationName);
}

//Delete
if(isset($_POST['deleteSublocationID'])){
    $sublocationID = $_POST['deleteSublocationID'];
    $api->deleteSublocation($sublocationID);
}


//Get beacons, locations, and sublocations from API to display in tables

$endpoints = array(
    $apiEndpoint.'/beacons',
    $apiEndpoint.'/locations',
    $apiEndpoint.'/sublocations',
);

$response = $api->multiRequest($endpoints);

$beacons = json_decode($response[0])->beacons;
$beaconsCount = count($beacons);

$locations = json_decode($response[1])->locations;
$locationsCount = count($locations);

$sublocations = json_decode($response[2])->sublocations;
$sublocationsCount = count($sublocations);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <meta name="robots" content="noindex">
    
    <title>AirTime</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="assets/css/custom.css">
    <link rel="stylesheet" type="text/css" href="assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css">    
    
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <script src="assets/js/chart-master/Chart.js"></script>
    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->
      <header class="header black-bg">
      <div class="airtime-logo">
            <img src="assets/img/logo.png">
            <div class="pull-right">
                                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#helpModal" style="margin-top:-60px; margin-right: 10px;"> Help </button>
                                    </div>
      </div>


        </header>


<body>
      <section>
          <section class="wrapper">

              <div class="row">
                  <div class="col-lg-12 main-chart">
                  
                  	<div class="row mtbox">
                  	<a href="#beacons" aria-controls="beacons" role="tab" data-toggle="tab" class="select-beacons">
                  		<div class="col-md-3 col-sm-3 col-sm-offset-1 col-md-offset-1 box0 active-test ">
                  			<div class="box1">
					  			<i class="fa fa-wifi fa-5x"></i>
					  			<h3>Beacons (<?php echo $beaconsCount; ?>)</h3>
                  			</div>
                  		</div>
                  	</a>
                  	
                  	<a href="#locations" aria-controls="locations" role="tab" data-toggle="tab" class="select-locations">
                  		<div class="col-md-3 col-sm-3 box0">
                  			<div class="box1">
					  			<i class="fa fa-location-arrow fa-5x"></i>
					  			<h3>Locations (<?php echo $locationsCount; ?>)</h3>
                  			</div>
                  		</div>
                  		
                  	</a>
                  	<a href="#sublocations" aria-controls="sublocations" role="tab" data-toggle="tab" class="select-sublocations">
                  		<div class="col-md-3 col-sm-3 box0">
                  			<div class="box1">
					  			<i class="fa fa-location-arrow fa-5x"></i>
					  			<h3>Sublocations (<?php echo $sublocationsCount; ?>)</h3>
                  			</div>
                  		</div>                  	<!-- /row mt --> 
                  	</a>                     					
                  </div>
                      <!-- /col-lg-9 END SECTION MIDDLE -->
                <!-- **********************************************************************************************************************************************************
      RIGHT SIDEBAR CONTENT
      *********************************************************************************************************************************************************** -->
            </div>
        </section>

        <section class="wrapper">
            <div role="tabpanel">
                <!-- Tab panes -->
            </div>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="beacons">
                    <div class="row mt">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="content-panel">
                                <h4>Beacons
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#addBeaconModal" style="margin-top:-10px; margin-right: 10px;"> Add Beacon </button>
                                    </div>
                                    
                                    
                                </h4>
                                <hr>
                                <table class="table table-striped table-advance table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>UUID</th>
                                            <th>Location</th>
                                            <th>Sublocation</th>
                                            <th>Brand</th>
                                            <th>Model</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($beacons as $beacon){?>
                                        
                                        <tr>
                                            <td><?php echo $beacon->id;?></td>
                                            
                                            <td><?php echo $beacon->uuid;?></td>

                                            <td><?php echo $beacon->major_name;?></td>

                                            <td><?php echo $beacon->minor_name;?></td>

                                            <td><?php echo $beacon->brand;?></td>

                                            <td><?php echo $beacon->model;?></td>

                                            <td>
                                              <button class="btn btn-primary btn-xs open-editBeaconDialog" data-toggle="modal" data-target="#editBeaconModal" data-beaconid='<?php echo $beacon->id; ?>' data-uuid='<?php echo $beacon->uuid; ?>' data-locationid='<?php echo $beacon->major;?>' data-sublocationid='<?php echo $beacon->minor;?>' data-brand='<?php echo $beacon->brand; ?>' data-model='<?php echo $beacon->model; ?>'><i class="fa fa-pencil"></i></button>&nbsp;&nbsp;&nbsp;&nbsp;
                                              <button class="btn btn-danger btn-xs open-deleteBeaconDialog" data-toggle="modal" data-target="#deleteBeaconModal" data-beaconid='<?php echo $beacon->id;?>'><i class="fa fa-trash-o "></i></button> 
                                            </td>
                                        </tr><?php } ?>
                                    </tbody>
                                </table>
                            </div><!-- /content-panel -->
                        </div><!-- /col-md-12 -->
                        <div class="col-md-1"></div>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane" id="locations">
                    <div class="row mt">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="content-panel">
                                <h4>Locations
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#addLocationModal" style="margin-top:-10px; margin-right: 10px;"> Add Location </button>
                                    </div>
                                </h4>
                                <hr>
                                <table class="table table-striped table-advance table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($locations as $location){?>

                                        <tr>
                                            <td><?php echo $location->id;?></td>

                                            <td><?php echo $location->name;?></td>

                                                                                        <td>
                                              <button class="btn btn-primary btn-xs open-editLocationDialog" data-toggle="modal" data-target="#editLocationModal" data-locationid ='<?php echo $location->id;?>' data-locationname='<?php echo $location->name;?>'><i class="fa fa-pencil"></i></button>&nbsp;&nbsp;&nbsp;&nbsp;
                                              <button class="btn btn-danger btn-xs open-deleteLocationDialog" data-toggle="modal" data-target="#deleteLocationModal" data-locationid='<?php echo $location->id;?>'><i class="fa fa-trash-o "></i></button>
                                            </td>
                                        </tr><?php } ?>
                                    </tbody>
                                </table>
                            </div><!-- /content-panel -->
                        </div><!-- /col-md-12 -->
                        <div class="col-md-1"></div>
                    </div>                
                </div>

                <div role="tabpanel" class="tab-pane" id="sublocations">
                    <div class="row mt">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="content-panel">
                                <h4>Sublocations
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#addSublocationModal" style="margin-top:-10px; margin-right: 10px;"> Add Sublocation </button>
                                    </div>
                                </h4>
                                <hr>
                                <table class="table table-striped table-advance table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($sublocations as $sublocation){?>

                                        <tr>
                                            <td><?php echo $sublocation->id;?></td>

                                            <td><?php echo $sublocation->name;?></td>

                                            <td>
                                              <button class="btn btn-primary btn-xs open-editSublocationDialog" data-toggle="modal" data-target="#editSublocationModal" data-sublocationid='<?php echo $sublocation->id;?>' data-sublocationname='<?php echo $sublocation->name;?>'><i class="fa fa-pencil"></i></button>&nbsp;&nbsp;&nbsp;&nbsp;
                                              <button class="btn btn-danger btn-xs open-deleteSublocationDialog" data-toggle="modal" data-target="#deleteSublocationModal" data-sublocationid='<?php echo $sublocation->id;?>'><i class="fa fa-trash-o "></i></button>                                              
                                            </td>
                                        </tr><?php } ?>
                                    </tbody>
                                </table>
                            </div><!-- /content-panel -->
                        </div><!-- /col-md-12 -->
                        <div class="col-md-1"></div>
                    </div>                  
                </div>
            </div>
        </section>
        
        
        
        
        
        
        
        
        
        <!--         Help modal -->
    <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center;">AirTime Help</h4>
                </div>

                <div class="modal-body">
                        <div class="modal-body">
                            <h4>1) Add A Location</h4>
                            <p>If needed, add a new location. A location represents the physical space that a beacon will occupy. (e.g. A Starbucks or office building)</p><br>
                            
                            <h4>2) Add A Sublocation</h4>
                            <p>If needed, add a new sublocation. A sublocation represents a place inside a location that the beacon will occupy. (e.g. Front door or a desk)</p><br>
                            
                            <h4>3) Add A Beacon</h4>
                            <p>A beacon contains a UUID, location, and sublocation. The UUID must be the same for all beacons within the same location, as the app can only interact with one UUID at a time. Optionally, you can make note of the brand and model of the beacon to help manage your beacons.</p><br>
                            
                            <h4>4) Configure Beacon</h4>
                            <p>Next you need to update your beacon's configuration to match the beacon you just created. This process differs for each beacon manufacturer. After updating, restart AirTime so that it will see the new beacons.</p>
                            <p>
                                Manufacturer-specific guides:<br>
                                •<a href="https://community.estimote.com/hc/en-us/articles/200868188-How-do-I-modify-UUID-major-and-minor-values-" target="_blank">Estimote</a><br>
                                •<a href="https://gimbal.com/doc/ios_proximity_ibeacon_quickstart.html" target="_blank">Gimbal</a>    
                            </p>
                            
                            
                            
                            <input type="hidden" name="deleteBeaconID" id="deleteBeaconID" value="">
                        </div>
                </div>

<!--
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> <button type="submit" class="btn btn-danger">Delete</button>
                </div>
-->
            </div>
        </div>
    </div>          
<!--         End help modal -->
        
        
        
        
        
<!----BEACONS-------------------------------------------------------------------->        
         
<!--         Add beacon modal -->
    <div class="modal fade" id="addBeaconModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center;">New Beacon</h4>
                </div>

                <div class="modal-body">
                    <form id="addBeaconForm" method="post">
                        <div class="modal-body">
                            <label>UUID</label><br>
                            <input type="text" name="addBeaconUuid" id="addBeaconUiud" placeholder="Enter Beacon UUID" value="<?php echo $udid; ?>" size="40"><br><br>
                            <label>Location</label><br>
                           <select placeholder="Choose a new location" name = "addBeaconMajor">
                            
                            <?php foreach ($locations as $location){?>
                                <option
                                    value="<?php echo $location->id;?>">
                                    <?php echo $location->name;?>
                                </option>
                            <?php } ?>
                            </select><br><br>
                            
                            <label>Sublocation</label><br> 
                            <select name = "addBeaconMinor">
                            <?php foreach ($sublocations as $sublocation){?>
                                <option
                                    value="<?php echo $sublocation->id;?>">
                                    <?php echo $sublocation->name;?>
                                </option>
                            <?php } ?>
                            </select><br><br>
                            
                            <label>Brand</label><br>
                            <input type="text" name="addBeaconBrand" id="addBeaconBrand" value=""><br><br>
                            <label>Model</label><br>
                            <input type="text" name="addBeaconModel" id="addBeaconModel" value=""><br><br>
                        </div>
                

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> <button type="submit" class="btn btn-success">Save</button>
                </div>
                        
                </form>
            </div>
        </div>
    </div>   
              </div>
<!--         End add beacon modal -->

<!-- Edit beacon modal -->
    <div class="modal fade" id="editBeaconModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center;">Edit Beacon</h4>
                </div>

                <div class="modal-body">
                    <form id="editBeaconForm" method="post">
                        <div class="modal-body">
                            <label>UUID</label><br>
                            <input type="text" name="editBeaconUUID" id="editBeaconUUID" size="40"><br><br>
                            <label>Location</label><br> 
                            <select name="editLocation" id="editLocation">
                            
                            <?php foreach ($locations as $location){?>
                                <option
                                    value="<?php echo $location->id;?>">
                                    <?php echo $location->name;?>
                                </option>
                            <?php } ?>
                            </select><br><br>
                            
                            <label>Sublocation</label><br> 
                            <select name = "editSublocation" id ="editSublocation">
                            <?php foreach ($sublocations as $sublocation){?>
                                <option
                                    value="<?php echo $sublocation->id;?>">
                                    <?php echo $sublocation->name;?>
                                </option>
                            <?php } ?>
                            </select><br><br>
                            
                            <label>Brand</label><br>
                            <input type="text" name="editBeaconBrand" id="editBeaconBrand" value=""><br><br>
                            <label>Model</label><br>
                            <input type="text" name="editBeaconModel" id="editBeaconModel" value=""><br><br>

                            <input type="hidden" name="editBeaconID" id="editBeaconID" value="">

                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> <button type="submit" class="btn btn-success">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>          
<!--         End edit beacon modal -->
          
<!--         Delete beacon modal -->
    <div class="modal fade" id="deleteBeaconModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center;">Delete Beacon?</h4>
                </div>

                <div class="modal-body">
                    <form id="deleteBeaconForm" method="post">
                        <div class="modal-body">
                            <h4>This cannot be undone</h4>
                            <input type="hidden" name="deleteBeaconID" id="deleteBeaconID" value="">
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> <button type="submit" class="btn btn-danger">Delete</button>
                </div>
                </form>
            </div>
        </div>
    </div>          
<!--         End delete beacon modal -->
          
<!----LOCATIONS-------------------------------------------------------------------->   
          
<!--         Add location modal -->
    <div class="modal fade" id="addLocationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center;">New Location</h4>
                </div>

                <div class="modal-body">
                    <form id="addLocationForm" method="post">
                        <div class="modal-body">
                            <label>Name</label><br>
                            <input type="text" name="addLocationName" id="addLocationName" placeholder="Design on Tap">
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> <button type="submit" class="btn btn-success">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>          
<!--         End add location modal -->
          
<!--         Edit location modal -->
    <div class="modal fade" id="editLocationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center;">Edit location</h4>
                </div>

                <div class="modal-body">
                    <form id="editLocationForm" method="post">
                        <div class="modal-body">
                            <label>Name</label><br>
                            <input type="text" name="editLocationName" id="editLocationName" placeholder="Front Door">
                            <input type="hidden" name="editLocationID" id="editLocationID" value="">

                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> <button type="submit" class="btn btn-success">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>          
<!--         End edit location modal -->
          
<!--         Delete location modal -->
    <div class="modal fade" id="deleteLocationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center;">Delete Location?</h4>
                </div>

                <div class="modal-body">
                    <form id="deleteLocationForm" method="post">
                        <div class="modal-body">
                            <h4>This cannot be undone</h4>
                            <input type="hidden" name="deleteLocationID" id="deleteLocationID" value="">
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> <button type="submit" class="btn btn-danger">Delete</button>
                </div>
                </form>
            </div>
        </div>
    </div>          
<!--         End delete location modal -->
          
<!----SUBLOCATIONS-------------------------------------------------------------------->   
          
<!--         Add sublocation modal -->
    <div class="modal fade" id="addSublocationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center;">New Sublocation</h4>
                </div>

                <div class="modal-body">
                    <form id="addSublocationForm" method="post">
                        <div class="modal-body">
                            <label>Name</label><br>
                            <input type="text" name="addSublocationName" id="addSublocationName" placeholder="Front Door">
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> <button type="submit" class="btn btn-success">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>          
<!--         End add sublocation modal -->

<!--         Edit sublocation modal -->
    <div class="modal fade" id="editSublocationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center;">Edit Sublocation</h4>
                </div>

                <div class="modal-body">
                    <form id="editSublocationForm" method="post">
                        <div class="modal-body">
                            <label>Name</label><br>
                            <input type="text" name="editSublocationName" id="editSublocationName" placeholder="Front Door">
                            <input type="hidden" name="editSublocationID" id="editSublocationID" value="">

                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> <button type="submit" class="btn btn-success">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>          
<!--         End edit sublocation modal -->
   
<!--         Delete sublocation modal -->
    <div class="modal fade" id="deleteSublocationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center;">Delete Sublocation?</h4>
                </div>

                <div class="modal-body">
                    <form id="deleteSublocationForm" method="post">
                        <div class="modal-body">
                            <h4>This cannot be undone</h4>
                            <input type="hidden" name="deleteSublocationID" id="deleteSublocationID" value="">
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> <button type="submit" class="btn btn-danger">Delete</button>
                </div>
                </form>
            </div>
        </div>
    </div>          
<!--         End delete sublocation modal -->
          
          
<!------------------------------------------------------------------------>   
          
          


        
        
    </section><!--main content end-->
    <!--footer start-->
</body>
</html>
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery-1.8.3.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.sparkline.js"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>
    
    <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="assets/js/gritter-conf.js"></script>

    <!--script for this page-->
    <script src="assets/js/sparkline-chart.js"></script>    
	<script src="assets/js/zabuto_calendar.js"></script>	
	
	<script type="application/javascript">
    	
    	  if(window.location.hash) {
              var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
              if (hash == "beacons"){
                  
              }
              if (hash == "locations"){
//                   $('#tabpanel li:eq(2) a').tab('show') // Select third tab (0-indexed)
//                   $('#tab-pane a[href="#locations"]').tab('show') // Select tab by name
//                   $('.locations').('show')
              }
              if (hash == "sublocations"){
                  
              }
              // hash found
          } else {
              // No hash found
          }
    	
    	//Document hash
       	$(document).on("click", ".select-beacons", function () {
	        document.location.hash = "beacons";
	    });
	    
	   $(document).on("click", ".select-locations", function () {
	        document.location.hash = "locations";
	    });
	    
	   $(document).on("click", ".select-sublocations", function () {
	        document.location.hash = "sublocations";
	    });
        
        //Beacon modals
       	$(document).on("click", ".open-deleteBeaconDialog", function () {
	        var beaconID = $(this).data('beaconid');
	        $(".modal-body #deleteBeaconID").val(beaconID);
	    });
	    
	   $(document).on("click", ".open-editBeaconDialog", function () {
    	   var beaconID = $(this).data('beaconid');
	       $(".modal-body #editBeaconID").val(beaconID);
	       
	        var beaconUUID = $(this).data('uuid');
	       $(".modal-body #editBeaconUUID").val(beaconUUID);

	        var beaconLocation = $(this).data('BeaconLoc');
	        $(".modal-body #editBeaconName").val(beaconLocation);
           
           var beaconSublocation = $(this).data('BeaconSubloc');
	        $(".modal-body #editBeaconName").val(beaconSublocation);
	        
	       var beaconBrand = $(this).data('brand');
	        $(".modal-body #editBeaconBrand").val(beaconBrand);
           
           var beaconModel = $(this).data('model');
	        $(".modal-body #editBeaconModel").val(beaconModel);
	        
	       var locationID = $(this).data('locationid');
	        $(".modal-body #editLocation").val(locationID);
	        
	       var sublocationID = $(this).data('sublocationid');
	        $(".modal-body #editSublocation").val(sublocationID);
	    });
        
        //Location modals
       	$(document).on("click", ".open-deleteLocationDialog", function () {
	        var locationID = $(this).data('locationid');
	        $(".modal-body #deleteLocationID").val(locationID);
	    });
	    
	   $(document).on("click", ".open-editLocationDialog", function () {
	        var locationID = $(this).data('locationid');
	        $(".modal-body #editLocationID").val(locationID);
	        
	        var locationName = $(this).data('locationname');
	        $(".modal-body #editLocationName").val(locationName);
	    });
        
    	//Sublocation modals
       	$(document).on("click", ".open-deleteSublocationDialog", function () {
	        var sublocationID = $(this).data('sublocationid');
	        $(".modal-body #deleteSublocationID").val(sublocationID);
	    });
	    
	   $(document).on("click", ".open-editSublocationDialog", function () {
	        var sublocationID = $(this).data('sublocationid');
	        $(".modal-body #editSublocationID").val(sublocationID);
	        
	        var sublocationName = $(this).data('sublocationname');
	        $(".modal-body #editSublocationName").val(sublocationName);
	    });
        
        //active selection
        var $boxes = $('.box0');
        
        $boxes.click(function() {
            $boxes.removeClass('active-test');
            $boxes.addClass('');
            $(this).addClass('active-test');
            $(this).removeClass('');
        });

    </script>

  </body>
</html>