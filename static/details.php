<main class="content">
				<div class="container-fluid p-0">
                <div class="row">
                        <div class="col-12 col-md-8 col-xxl-3 d-flex order-2 order-xxl-3">
							<div class="card flex-fill w-100">
								<div class="card-header">
									<div class="row">
                                        <div class="col-md-6 mt-3">
                                            <h5 class="card-title mb-0">Vente Par jour</h5>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <select class="form-control shadow-none text-secondary">
                                                <option value="1">Janvier</option>
                                                <option value="2">Fevrier</option>
                                                <option value="3">Mars</option>
                                                <option value="4">Avril</option>
                                                <option value="5">Mai</option>
                                                <option value="6">Juin</option>
                                                <option value="7">Juiller</option>
                                                <option value="8">Aout</option>
                                                <option value="9">Septembre</option>
                                                <option value="10">Octobre</option>
                                                <option value="11">Novembre</option>
                                                <option value="12">Decembre</option>
                                            </select>
                                        </div>
                                    </div>
								</div>
								<div class="card-body d-flex">
									<div class="align-self-center w-100">
										<div class="row">
                                            <div class="col-12">
                                                <table class="table mb-0">
                                                    
                                                </table>
                                            </div>
										</div>
									</div>
								</div>
							</div>
						</div>
                    </div>
					<div class="row">
						<div class="col-12 col-md-8 col-xxl-3 d-flex order-2 order-xxl-3">
							<div class="card flex-fill w-100">
								<div class="card-header">
									<h5 class="card-title mb-0">MONTANT VENDU PAR MOIS</h5>
								</div>
								<div class="card-body py-3">
									<div class="chart chart-sm">
										<canvas id="chartjs-dashboard-line"></canvas>
									</div>
								</div>
							</div>
						</div>

						<div class="col-12 col-md-6 col-xxl-3 d-flex order-2 order-xxl-3 d-none">
							<div class="card flex-fill w-100">
								<div class="card-header">
									<h5 class="card-title mb-0">Article le plus vendu</h5>
								</div>
								<div class="card-body d-flex">
									<div class="align-self-center w-100">
										<div class="row">
										<div class="col-12 py-3">
											<div class="chart chart-xs">
												<canvas id="chartjs-dashboard-pie"></canvas>
											</div>
										</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</div>

					<div class="row">
						<div class="col-12 col-md-8 col-xxl-12 d-flex">
							<div class="card flex-fill w-100">
								<div class="card-header">
									<h5 class="card-title mb-0">QUANTITE VENDU PAR MOIS</h5>
								</div>
								<div class="card-body d-flex w-100">
									<div class="align-self-center chart chart-lg">
										<canvas id="chartjs-dashboard-bar"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</main>

			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-start">
							<p class="mb-0">
								&copy; <a class="text-muted" href="" target="_blank"><strong>Backend of LMK Kalala</strong></a><a class="text-muted" href="https://adminkit.io/" target="_blank"><strong> & AdminKit</strong></a>
							</p>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>

	<script src="<?=base_url('static/')?>js/app.js"></script>

	<script>
		document.addEventListener("DOMContentLoaded", function() {
			var ctx = document.getElementById("chartjs-dashboard-line").getContext("2d");
			var gradient = ctx.createLinearGradient(0, 0, 0, 225);
			gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
			gradient.addColorStop(1, "rgba(215, 227, 244, 0)");
			// Line chart

			$.ajax({
					type:'POST',
					url:'<?=base_url('Panel/money')?>',
					dataType:'json',	
					success: function(data){
						$('button').prop('disabled',false);
						if(data.status == 'success'){
			new Chart(document.getElementById("chartjs-dashboard-line"), {
				type: "line",
				data: {
					labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
					datasets: [{
						label: "Sales ($)",
						fill: true,
						backgroundColor: gradient,
						borderColor: window.theme.primary,
						data: data.money
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false
					},
					tooltips: {
						intersect: false
					},
					hover: {
						intersect: true
					},
					plugins: {
						filler: {
							propagate: false
						}
					},
					scales: {
						xAxes: [{
							reverse: true,
							gridLines: {
								color: "rgba(0,0,0,0.0)"
							}
						}],
						yAxes: [{
							ticks: {
								stepSize: 1000
							},
							display: true,
							borderDash: [3, 3],
							gridLines: {
								color: "rgba(0,0,0,0.0)"
							}
						}]
					}
				}
			});

						}

					},
					error: function (data) {
						console.log('Error:', data);
					}
			});

		});
	</script>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Pie chart
			$.ajax({
				type:'POST',
					url:'<?=base_url('Panel/bestsoldProduct')?>',
					dataType:'json',	
					success: function(data){
						$('button').prop('disabled',false);
						if(data.status == 'success'){
							var labels = data.sellers;
							var montant = data.montant;
							new Chart(document.getElementById("chartjs-dashboard-pie"), {
								type: "pie",
								data: {
									labels: labels,
									datasets: [{
										data: montant,
										backgroundColor: [
											window.theme.primary,
											window.theme.warning,
											window.theme.danger,
											window.theme.success,
											window.theme.info
										],
										borderWidth: 5
									}]
								},
								options: {
									responsive: !window.MSInputMethodContext,
									maintainAspectRatio: false,
									legend: {
										display: false
									},
									cutoutPercentage: 75
								}
							});
						}else{
							console.log('Error Best seller');
						}
					},
					error: function (data) {
						console.log('Error:', data);
					}
			});
		});
	</script>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Bar chart
			$.ajax({
					type:'POST',
					url:'<?=base_url('Panel/number/')?>',
					dataType:'json',	
					success: function(data){
						$('button').prop('disabled',false);
						if(data.status == 'success'){

							new Chart(document.getElementById("chartjs-dashboard-bar"), {
								type: "bar",
								data: {
									labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
									datasets: [{
										label: "No",
										backgroundColor: window.theme.primary,
										borderColor: window.theme.primary,
										hoverBackgroundColor: window.theme.primary,
										hoverBorderColor: window.theme.primary,
										data: data.number,//[54, 67, 41, 55, 62, 45, 55, 73, 60, 76, 48, 79],
										barPercentage: .75,
										categoryPercentage: .5
									}]
								},
								options: {
									maintainAspectRatio: false,
									legend: {
										display: false
									},
									scales: {
										yAxes: [{
											gridLines: {
												display: false
											},
											stacked: false,
											ticks: {
												stepSize: 20
											}
										}],
										xAxes: [{
											stacked: false,
											gridLines: {
												color: "transparent"
											}
										}]
									}
								}
							});
						}

					},
					error: function (data) {
						console.log('Error:', data);
					}
				});
			});
	</script>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			var markers = [{
					coords: [31.230391, 121.473701],
					name: "Shanghai"
				},
				{
					coords: [28.704060, 77.102493],
					name: "Delhi"
				},
				{
					coords: [6.524379, 3.379206],
					name: "Lagos"
				},
				{
					coords: [35.689487, 139.691711],
					name: "Tokyo"
				},
				{
					coords: [23.129110, 113.264381],
					name: "Guangzhou"
				},
				{
					coords: [40.7127837, -74.0059413],
					name: "New York"
				},
				{
					coords: [34.052235, -118.243683],
					name: "Los Angeles"
				},
				{
					coords: [41.878113, -87.629799],
					name: "Chicago"
				},
				{
					coords: [51.507351, -0.127758],
					name: "London"
				},
				{
					coords: [40.416775, -3.703790],
					name: "Madrid "
				}
			];
			var map = new jsVectorMap({
				map: "world",
				selector: "#world_map",
				zoomButtons: true,
				markers: markers,
				markerStyle: {
					initial: {
						r: 9,
						strokeWidth: 7,
						stokeOpacity: .4,
						fill: window.theme.primary
					},
					hover: {
						fill: window.theme.primary,
						stroke: window.theme.primary
					}
				},
				zoomOnScroll: false
			});
			window.addEventListener("resize", () => {
				map.updateSize();
			});
		});
	</script>

</body>

</html>