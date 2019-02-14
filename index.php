<?php

if(isset($_POST['sites'])){
	
	$urls = explode(',',$_POST['sites']);
	$data = getMultipleRanks($urls);
	
}



function getRank($siteUrl){
	
	// local array
	//$data = new array();
	
	// load alexa api 
	$xml = simplexml_load_file("http://data.alexa.com/data?cli=10&url=".$siteUrl);
	
	if(isset($xml->SD)){
			$data['status'] = 1;
			$data['reach'] = (int)$xml->SD->REACH->attributes()->RANK;
			$data['global_rank'] = (int)$xml->SD->POPULARITY->attributes()->TEXT;
			$data['local_rank'] = (int)$xml->SD->COUNTRY->attributes()->RANK;
			$data['country'] = $xml->SD->COUNTRY->attributes()->NAME;
			$data['url'] = $siteUrl;		
		} else {
			$data['status'] = 0;
			$data['url'] = $siteUrl;
		}
		// add time for detecting update time
		$data['time'] =  date('Y-m-d',time());	
		 
		return $data;
	
}


function getMultipleRanks($sites)
{
	$cnt = 1;
	foreach($sites as $sitename => $site){
		$site = ltrim(rtrim($site));
		$RankDataArr[$site] = getRank($site);
		$cnt++;
	}
	return $RankDataArr;
}

?>

<html>
	<head>
	
  <title>Alexa Rank Checker. Check Alexa Ranking of 800 URLs At Once - TrafficSolder</title>
   <meta name="Description" content="Alexa Rank Checker Of Any Website Just Paste Here URLs - Unlimited Website Alexa Ranking Checker Free Tool Build By Traffic Solder!">
  <meta name="Keywords" content="alexa, rank, website rank checker, alexa rank checker bulk, website ranking checker">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="stylesheet" href="css/bootstrap.css">
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
		<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
		<link href="https://fonts.googleapis.com/css?family=Josefin+Sans|Noto+Serif+SC|Roboto+Condensed|Staatliches" rel="stylesheet">
	
	</head>
	<body>
		<div class="container-fluid top-1">
			<div class="row">
				<div class="col-sm-12">
					<div class="text-left">
						<h3>Traffic Solder</h3>
					</div>
				</div>
			</div>
		</div>
		
		<div class="container-fluid top-2">
			<div class="row">
				<div class="col-sm-12">
					<div class="text-center">
						<h1>Bulk Alexa Rank Checker</h1>
						<br>
						<span>Here you can check website Alexa rank in bluk just paste here website URL!</span><br>
						<p>Example: <code>https://trafficsolder.com</code></p>
						<P>Use Commas For Checking Bulk Alexa Rank</P>
					</div>
				</div>
			</div>
			
		</div>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					
				</div>
			</div>
			<div class="row ranking-row">
				<div class="col-sm-12">
					<form action="index.php" class="form-horizontal" method="post">
						<textarea class="form-control" name="sites"></textarea>
						<br>
						<input class="form-control btn btn-warning" type="submit">
					</form>
				</div>
			</div>
			<div class="row url-data">
				<div class="col-sm-12">
				    <hr>
					<table class="table table-striped table-bordered table-hover" id="urlTable">
						<thead>
							<tr>
								<th title="S.No">S.NO.</th>
								<th title="URL">URL</th>
								<th title="Reach">Reach</th>
								<th title="Global Rank">Global Rank</th>
								<th title="Local Rank">Local Rank</th>
								<th title="Country">Country</th>
							</tr>
						</thead>
						<tbody id="tbody">
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	<hr>
	<footer>
		<div class="container">
			<div class="row">
				<center>
					<strong> Tool Build By:</stong> <a href="https://trafficsolder.com">Traffic Solder</a>
				</center>
			</div>
		</div>
	</footer>
		
	<script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script type="text/javascript" src="//cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
	
	<script>
	
		var t = $('#urlTable').DataTable({
            select: true,
            dom: 'Bfrtip',
            buttons: ['copyHtml5', {
                extend: 'excelHtml5',
                title: 'TrafficSolder Keyword Volume'
            }, {
                extend: 'csvHtml5',
                title: 'TrafficSolder Keyword Volume'
            }, {
                extend: 'pdfHtml5',
                title: 'TrafficSolder Keyword Volume'
            }],
            language:{
               sSearch: " _INPUT_",
               searchPlaceholder: "Search..."
            }
        });
		
		var data = <?php echo json_encode($data) ?>;
		//console.log(data);
		
		if(data){
			
			var k = 0;
			var flag = 1; // check if data exists for a website

			for(var url in data){		
				for(var url_data in data[url]){
					
					if(url_data=="status"){
						if(data[url][url_data]==1){
							flag = 1;
						} else {
							flag = 0;
						}
					} else if(url_data=="reach"){
						var reach = data[url][url_data];
					} else if(url_data=="global_rank"){
						var global_rank = data[url][url_data];
					} else if(url_data=="local_rank"){
						var local_rank = data[url][url_data];
					} else if(url_data=="country"){
					    if(data[url][url_data]!=null)
    						var country = data[url][url_data][0];
    					else
    					    var country = 'NA';
					}
				}
				
				if(flag == 1)
					t.row.add([(k+1), url ,reach, global_rank, local_rank, country]).draw(false);	
				k++;
			}
			
			$(".url-data").show();
		}
		
		
	</script> 
	
	</body>
</html>

